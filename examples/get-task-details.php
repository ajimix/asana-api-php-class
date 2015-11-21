<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('apiKey' => 'XXXXXXX.XXXXXXXXXXXXXXXXXXXXXXXX')); // Your API Key, you can get it in Asana

$taskId = 10924433056204;
$asana->getTask($taskId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

echo "Task details:" . PHP_EOL;
var_dump($asana->getData());

$asana->getTaskStories($taskId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

echo "Task stories(comments):" . PHP_EOL;
var_dump($asana->getData());