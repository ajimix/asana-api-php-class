<?php

/**
 * AsanaAuth class is used for easy Oauth authentication.
 * The use of this class is totally optional and you can use any
 * other oauth implementation if prefered.
 *
 * Copyright 2016 Ajimix
 * Licensed under the Apache License 2.0
 *
 * Authors: Ajimix [github.com/ajimix], Puchol [https://github.com/puchol]
 * Version: 2.0.0
 */
class AsanaAuth
{
    private $timeout = 10;
    private $debug = false;
    private $advDebug = false; // Note that enabling advanced debug will include debugging information in the response possibly breaking up your code.

    private $response;
    public $responseCode;

    private $asanaAuthorizeUrl = 'https://app.asana.com/-/oauth_authorize'; // You shouldn't change this url.
    private $asanaAccessTokenUrl = 'https://app.asana.com/-/oauth_token'; // You shouldn't change this url.
    private $clientId;
    private $clientSecret;
    private $redirectUrl;

    /**
     * Class constructor.
     * @param string $clientId Client ID given by asana app creator.
     * @param string $clientSecret Client secret given by asana app creator.
     * @param string $redirectUrl Redirect url, must match the one given in asana app creator.
     */
    public function __construct($clientId, $clientSecret, $redirectUrl)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Returns the url for the authorization.
     *
     * Use this url to redirect the user, let the user authorize your application,
     * and then come back to your application with the token.
     * @return string The authorization url.
     */
    public function getAuthorizeUrl()
    {
        return $this->asanaAuthorizeUrl . '?client_id=' . $this->clientId . '&response_type=code&redirect_uri=' . $this->redirectUrl;
    }

    /**
     * Converts an authorization code into an access token via a call to the asana servers.
     *
     * @param  string $authCode The authorization code provided via asana after the proper authorization.
     * @return string JSON or null.
     */
    public function getAccessToken($authCode)
    {
        return $this->askAsana('get', $authCode);
    }

    /**
     * Ask asana to refresh the token with a new one.
     *
     * @param  string $refreshToken The refresh token provided by asana on getting the access token.
     * @return string JSON or null.
     */
    public function refreshAccessToken($refreshToken)
    {
        return $this->askAsana('refresh', $refreshToken);
    }

    /**
     * This function communicates with Asana REST API.
     * You don't need to call this function directly. It's only for inner class working.
     *
     * @param string $action Must be get or refresh.
     * @param string $token The token to send.
     * @return string JSON or null
     */
    private function askAsana($action, $token)
    {
        $curl = curl_init($this->asanaAccessTokenUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Don't print the result
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);

        // Decode compressed responses.
        curl_setopt($curl, CURLOPT_ENCODING, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // Add client ID and client secret to the headers.
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
        ));

        // Assemble POST parameters for the request.
        if ($action === 'get') {
            $postFields = 'code=' . urlencode($token) . '&grant_type=authorization_code&redirect_uri=' . $this->redirectUrl . '&client_id=' . $this->clientId . '&client_secret=' . $this->clientSecret;
        } elseif ($action === 'refresh') {
            $postFields = 'refresh_token=' . urlencode($token) . '&grant_type=refresh_token&redirect_uri=' . $this->redirectUrl . '&client_id=' . $this->clientId . '&client_secret=' . $this->clientSecret;
        }

        // Obtain and return the access token from the response.
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);

        try {
            $this->response = curl_exec($curl);
            $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($this->debug || $this->advDebug) {
                echo '<pre>';
                print_r(curl_getinfo($curl));
                echo '</pre>';
            }
        } catch (Exception $ex) {
            if ($this->debug || $this->advDebug) {
                echo '<br>cURL error num: ' . curl_errno($curl);
                echo '<br>cURL error: ' . curl_error($curl);
            }
            echo 'Error on cURL';
            $this->response = null;
        }

        curl_close($curl);

        return $this->response;
    }

    /**
     * Checks for errors in the response.
     *
     * @return boolean
     */
    public function hasError()
    {
        return $this->responseCode != 200 || is_null($this->response);
    }

    /**
     * Decodes the response and returns as an object.
     *
     * @return object or null
     */
    public function getData()
    {
        if (!$this->hasError()){
            return json_decode($this->response);
        }

        return null;
    }
}
