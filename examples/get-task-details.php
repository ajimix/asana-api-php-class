<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('apiKey' => 'ki9hkSd.nFnGrx8mrXVgazKIQ7o4lb2I')); // Your API Key, you can get it in Asana

$taskId = 10924433056204;
$resultJson = $asana->getTask($taskId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($resultJson)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$task = json_decode($resultJson);
echo "Task details:" . PHP_EOL;
var_dump($task);

$resultJson = $asana->getTaskStories($taskId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($resultJson)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$stories = json_decode($resultJson);
echo "Task stories(comments):" . PHP_EOL;
var_dump($stories);