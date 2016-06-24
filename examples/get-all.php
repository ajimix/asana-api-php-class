<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

// Get all workspaces
$asana->getWorkspaces();

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

foreach ($asana->getData() as $workspace) {
    echo '<h3>*** ' . $workspace->name . ' (id ' . $workspace->id . ')' . ' ***</h3><br />' . PHP_EOL;

    // Get all projects in the current workspace (all non-archived projects)
    $asana->getProjectsInWorkspace($workspace->id, $archived = false);

    // As Asana API documentation says, when response is successful, we receive a 200 in response so...
    if ($asana->hasError()) {
        echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
        continue;
    }

    foreach ($asana->getData() as $project) {
        echo '<strong>[ ' . $project->name . ' (id ' . $project->id . ')' . ' ]</strong><br>' . PHP_EOL;

        // Get all tasks in the current project
        $asana->getProjectTasks($project->id);

        if ($asana->hasError()) {
            echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
            continue;
        }

        foreach ($asana->getData() as $task) {
            echo '+ ' . $task->name . ' (id ' . $task->id . ')' . ' ]<br>' . PHP_EOL;
        }
    }
}
