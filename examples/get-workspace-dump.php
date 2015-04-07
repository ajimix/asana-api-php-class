<?php

require_once('../asana.php');

// See class comments and Asana API for full info

$asana = new Asana(array('apiKey' => 'XXXXXXXXXXXXX')); // Your API Key, you can get it in Asana

$workspaceId = 42; // The workspace to dump to JSON

// Get all projects in the current workspace (all non-archived projects)
$projectsJson = $asana->getProjectsInWorkspace($workspaceId, $archived = false);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($projectsJson)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    exit;
}

$projects = json_decode($projectsJson);

foreach ($projects->data as $project) {
    echo '<strong>[ ' . $project->name . ' (id ' . $project->id . ')' . ' ]</strong><br>' . PHP_EOL;
    //if ($project->id != 42) { // Quickly filter on a project
    //  continue;
    //}

    // Get all tasks in the current project
    $tasks = $asana->getProjectTasks($project->id);
    $tasksJson = json_decode($tasks);
    if ($asana->responseCode != '200' || is_null($tasks)) {
        echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
        continue;
    }
    $project->tasks = $tasksJson;
    foreach ($tasksJson->data as $task) {
        echo '+ ' . $task->name . ' (id ' . $task->id . ')' . ' ]<br>' . PHP_EOL;
        $taskdata = $asana->getTask($task->id);
        $taskdataJson = json_decode($taskdata);
        $task->details = $taskdataJson;
        //var_dump($taskdataJson);
        $stories = json_decode($asana->getTaskStories($task->id));
        $task->stories = $stories;
        //var_dump($stories);
    }
}

//var_dump($projects);

echo "All as JSON:\n";
echo json_encode($projects);
