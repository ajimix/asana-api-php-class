<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$asana->getProjects();

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

// $asana->getData() contains an object in json with all projects
foreach ($asana->getData() as $project) {
    echo 'Project ID: ' . $project->id . ' is ' . $project->name . '<br>' . PHP_EOL;
}
