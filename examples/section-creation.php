<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$workspaceId = 'XXXXXXXXXXXXXXXXXXX'; // The workspace where we want to create our task, take a look at getWorkspaces() method.
$projectId = 'XXXXXXXXXXXXXXXXXXX'; // the project id where we want to add our section, take a look at getProjects() method.

// A section is a subdivision of a project that groups tasks together.
// It is also just a task with a name that ends with a colon.
// These are two ways to create a section, shown below.
//
// More about sections: https://asana.com/developers/api-reference/sections

//
// One method to create a section is to create a task with specific properties.
// We've added a colon to the end of the task name and added a project to it's membership properties.
$asana->createTask(array(
    'workspace' => $workspaceId, // Workspace ID
    'name'      => 'Section created by createTask:', // Name of task
    'assignee'  => 'bigboss@bigcompany.com', // Assign task to...
    "memberships" => [
		[
			"project" => $projectId
		]
	]
));

/*

// Alternatively, we can use the createSection() method.
// We identify the project as the first parameter and the data for the section in an array for the second parameter.
//
// Note: The section name does not need to include a colon, Asana will add this when the section is created.
$asana->createSection($projectId, array(
    'workspace' => $workspaceId, // Workspace ID
    'name'      => 'Section created by createSection', // Name of section
    'assignee'  => 'bigboss@bigcompany.com' // Assign task to...
));

*/


// As Asana API documentation says, when a task is created, 201 response code is sent back so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

$result = $asana->getData();

if (isset($result->id)) {
    echo $result->id; // Here we have the id of the task/section that have been created
}
