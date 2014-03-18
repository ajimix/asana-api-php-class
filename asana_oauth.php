<?php

class AsanaAuth {

    public $CurlHeaders;
    public $ResponseCode;
 
    private $_AuthorizeUrl = "https://app.asana.com/-/oauth_authorize";
    private $_AccessTokenUrl = "https://app.asana.com/-/oauth_token";
 
    public function __construct() {
        $this->CurlHeaders = array();
        $this->ResponseCode = 0;
    }
 
    public function RequestAccessCode ($client_id, $redirect_url) {
        return($this->_AuthorizeUrl . "?client_id=" . $client_id . "&response_type=code&redirect_uri=" . $redirect_url);
    }
 
    // Convert an authorization code into an access token.
    public function GetAccessToken($client_id, $client_secret, $auth_code, $redirect_url) {        
        // Init cUrl.
        $r = $this->InitCurl($this->_AccessTokenUrl);
 
        // Add client ID and client secret to the headers.
        curl_setopt($r, CURLOPT_HTTPHEADER, array (
            "Authorization: Basic " . base64_encode($client_id . ":" . $client_secret),
        ));        
 
        // Assemble POST parameters for the request.
        $post_fields = "code=" . urlencode($auth_code) . "&grant_type=authorization_code&redirect_uri=" . $redirect_url . "&client_id=" . $client_id . "&client_secret=" . $client_secret;
 
        // Obtain and return the access token from the response.
        curl_setopt($r, CURLOPT_POST, true);
        curl_setopt($r, CURLOPT_POSTFIELDS, $post_fields);
 
        $response = curl_exec($r);
        if ($response == false) {
            die("curl_exec() failed. Error: " . curl_error($r));
        }
 
        //Parse JSON return object.
        return json_decode($response);
    }
 
    private function InitCurl($url) {
        $r = null;
 
		$r = curl_init($url);
       
        curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
 
        // Decode compressed responses.
        curl_setopt($r, CURLOPT_ENCODING, 1);
        curl_setopt($r, CURLOPT_SSL_VERIFYPEER, false);
 
        return($r);
    }
 
	// Generic function to execute a request
    public function ExecRequest($url, $access_token, $get_params) {
        // Create request string.
        $full_url = http_build_query($url, $get_params);
 
        $r = $this->InitCurl($url);
 
        curl_setopt($r, CURLOPT_HTTPHEADER, array (
            "Authorization: Basic " . base64_encode($access_token)
        ));
 
        $response = curl_exec($r);
        if ($response == false) {
            die("curl_exec() failed. Error: " . curl_error($r));
        }
 
        //Parse JSON return object.
        return json_decode($response);        
    }
}

?>