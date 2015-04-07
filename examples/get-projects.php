<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('apiKey' => 'XXXXXXXXXXXXXXXXXXX')); // Your API Key, you can get it in Asana

$result = $asana->getProjects();

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($result)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$resultJson = json_decode($result);

// $resultJson contains an object in json with all projects
foreach ($resultJson->data as $project) {
    echo 'Project ID: ' . $project->id . ' is ' . $project->name . '<br>' . PHP_EOL;
}
