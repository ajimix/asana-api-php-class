<?php
require_once("asana.php");

// See class comments and Asana API for full info

$asana = new Asana("xxxxxxxxxxxxxxxxxxxxx"); // Your API Key, you can get it in Asana

// Get all workspaces
$workspaces = $asana->getWorkspaces();

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if($asana->responseCode == "200" && !is_null($workspaces)){
	$workspacesJson = json_decode($workspaces);

	foreach ($workspacesJson->data as $workspace){
		echo "<h3>*** " . $workspace->name . " (id " . $workspace->id . ")" . " ***</h3><br />";
		
		// Get all projects in the current workspace (all non-archived projects)
		$projects = $asana->getProjectsInWorkspace($workspace->id, $archived = false);
		
		// As Asana API documentation says, when response is successful, we receive a 200 in response so...
		if($asana->responseCode == "200" && !is_null($projects)){
			$projectsJson = json_decode($projects);

			foreach ($projectsJson->data as $project){
				echo "<strong>[ " . $project->name . " (id " . $project->id . ")" . " ]</strong><br>";
				
				// Get all tasks in the current project
				$tasks = $asana->getProjectTasks($project->id);
				$tasksJson = json_decode($tasks);
				if($asana->responseCode == "200" && !is_null($tasks)){
					foreach ($tasksJson->data as $task){
						echo "+ " . $task->name . " (id " . $task->id . ")" . " ]<br>";
					}
				} else {
					echo "Error while trying to connect to Asana, response code: {$asana->responseCode}";
				}
				
			}
			
		} else {
			echo "Error while trying to connect to Asana, response code: {$asana->responseCode}";
		}
		
	}	

} else {
	echo "Error while trying to connect to Asana, response code: {$asana->responseCode}";
}