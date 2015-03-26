<?php
require_once('../asana.php');

// See class comments and Asana API for full info

$asana = new Asana(array('apiKey' => 'XXXXXXXXXXXXXXXXXXX')); // Your API Key, you can get it in Asana

$workspaceId = 'XXXXXXXXXXXXXXXXXXX'; // The workspace where we want to create our task, take a look at getWorkspaces() method.

// First we create the task
$result = $asana->createTask(array(
    'workspace' => $workspaceId, // Workspace ID
    'name' => 'Hello World!', // Name of task
    'assignee' => 'bigboss@bigcompany.com' // Assign task to...
));


// As Asana API documentation says, when a task is created, 201 response code is sent back so...
if ($asana->responseCode != '201' || is_null($result)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$resultJson = json_decode($result);

$taskId = $resultJson->data->id; // Here we have the id of the task that have been created
