<?php
require_once("asana.php");

// See class comments and Asana API for full info

$asana = new Asana("XXXXXXXXXXXXXXXXXXX"); // Your API Key, you can get it in Asana

$workspaceId = "32479823642379"; // The workspace where we want to create our task
$projectId = "1231354653425"; // The project where we want to save our task

// First we create the task
$result = $asana->createTask(array(
    "workspace" => $workspaceId, // Workspace ID
    "name" => "Hello World!", // Name of task
    "assignee" => "bigboss@bigcompany.com", // Assign task to...
    "followers" => array("3714136", "5900783") // We add some followers to the task... (this time by ID)
));


// As Asana API documentation says, when a task is created, 201 response code is sent back so...
if($asana->responseCode == "201" && !is_null($result)){
	$resultJson = json_decode($result);

	$taskId = $resultJson->data->id; // Here we have the id of the task that have been created

	// Now we do another request to add the task to a project
	$result = $asana->addProjectToTask($taskId, $projectId);

	if($asana->responseCode != "200"){
		echo "Error while assigning project to task: {$asana->responseCode}";
	}

} else {
	echo "Error while trying to connect to Asana, response code: {$asana->responseCode}";
}