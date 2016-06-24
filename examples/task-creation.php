<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$workspaceId = 'XXXXXXXXXXXXXXXXXXX'; // The workspace where we want to create our task, take a look at getWorkspaces() method.

// First we create the task
$asana->createTask(array(
    'workspace' => $workspaceId, // Workspace ID
    'name'      => 'Hello World!', // Name of task
    'assignee'  => 'bigboss@bigcompany.com' // Assign task to...
));


// As Asana API documentation says, when a task is created, 201 response code is sent back so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$result = $asana->getData();

if (isset($result->id)) {
    echo $result->id; // Here we have the id of the task that have been created
}
