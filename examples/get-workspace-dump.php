<?php

require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$workspaceId = 42; // The workspace to dump to JSON

// Get all projects in the current workspace (all non-archived projects)
$asana->getProjectsInWorkspace($workspaceId, $archived = false);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    exit;
}

$projects = $asana->getData();

foreach ($projects as $project) {
    echo '<strong>[ ' . $project->name . ' (id ' . $project->id . ')' . ' ]</strong><br>' . PHP_EOL;
    //if ($project->id != 42) { // Quickly filter on a project
    //  continue;
    //}

    // Get all tasks in the current project
    $asana->getProjectTasks($project->id);
    if ($asana->hasError()) {
        echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
        continue;
    }
    foreach ($asana->getData() as $task) {
        echo '+ ' . $task->name . ' (id ' . $task->id . ')' . ' ]<br>' . PHP_EOL;

        $asana->getTask($task->id);
        if(!$asana->hasError()){
            $task->details = $asana->getData();
            //var_dump($task->details);
        }

        $asana->getTaskStories($task->id);
        if(!$asana->hasError()){
            $task->stories = $asana->getData();
            //var_dump($task->stories);
        }
    }
}

//var_dump($projects);

echo "All as JSON:\n";
echo json_encode($projects);
