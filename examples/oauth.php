<?php
require_once('../asana.php');
require_once('../asana-oauth.php');

// See class comments and Asana API for extra info

$asanaAuth = new AsanaAuth('CLIENT_ID', 'CLIENT_SECRET', 'REDIRECT_URL');

if (!isset($_GET['code'])) {
    // We don't have the code so we need to authorize our app.

    // Get the url.
    $url = $asanaAuth->getAuthorizeUrl();

    // Redirect the user to asana authorization url.
    header('Location:' . $url);

    // Now the user will authorize the app and this page will load again having the ?code parameter that we can use.
} else {
    // We have authorization from the user.
    // We have to get the access token.
    $result = $asanaAuth->getAccessToken($_GET['code']);

    // As Asana API documentation says, when response is successful, we receive a 200 in response so...
    if ($asanaAuth->responseCode != '200' || is_null($result)) {
        echo 'Error while trying to connect to Asana to get the access token, response code: ' . $asanaAuth->responseCode;
        return;
    }

    $resultJson = json_decode($result);

    // Now we can create a normal asana object with the access token.
    $asana = new Asana(array('accessToken' => $resultJson->access_token));
    $result = $asana->getProjects();

    // As Asana API documentation says, when response is successful, we receive a 200 in response so...
    if ($asana->responseCode != '200' && is_null($result)) {
        echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
        return;
    }

    $resultJson = json_decode($result);

    // $resultJson contains an object in json with all projects
    foreach ($resultJson->data as $project) {
        echo 'Project ID: ' . $project->id . ' is ' . $project->name . '<br>' . PHP_EOL;
    }
}
