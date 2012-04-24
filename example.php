<?php
require_once("asana.php");

// See class comments and Asana API for full info

$asana = new Asana("XXXXXXXXXXXXXXXXX"); // Your API Key, you can get it in Asana

// Example creating a task
$result = $asana->createTask(array(
   "workspace" => "176825", // Workspace ID
   "name" => "Hello World!", // Name of task
   "assignee" => "bigboss@bigcompany.com", // Assign task to...
   "followers" => array("3714136", "5900783") // We add some followers to the task... (this time by ID)
));

// We transform the string to json
if(!is_null($result)){
	$resultJson = json_decode($result);
	echo "The id of the task created is: {$resultJson->data->id}";
} else {
	echo "Error while trying to connect to Asana";
}