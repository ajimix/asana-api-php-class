<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$workspaceId = 'XXXXXXXXXXXXXXXXXXX'; // The workspace where we want to create our task
$projectId   = 'XXXXXXXXXXXXXXXXXXX'; // The project where we want to save our task

// First we create the task
$result = $asana->createTask(array(
    'workspace' => $workspaceId, // Workspace ID
    'name'      => 'Hello World!', // Name of task
    'assignee'  => 'bigboss@bigcompany.com', // Assign task to...
    'followers' => array('XXXXX', 'XXXXXXXX') // We add some followers to the task... (this time by ID), this is totally optional
));

// As Asana API documentation says, when a task is created, 201 response code is sent back so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$taskId = $asana->getData()->id; // Here we have the id of the task that have been created

// Now we do another request to add the task to a project
$asana->addProjectToTask($taskId, $projectId);

if ($asana->hasError()) {
    echo 'Error while assigning project to task: ' . $asana->responseCode;
} else {
    echo 'Success to add the task to a project.';
}
