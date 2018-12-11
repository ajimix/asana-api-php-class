<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$workspaceId = 0; // The workspace to query by

// Get all users in the specified workspace
$asana->getUsersInWorkspace($workspaceId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    exit;
}


$users = $asana->getData();

foreach ($users as $user) {
    echo 'Id: ' . $user->id;
    echo 'Name: ' . $user->name . PHP_EOL;
}

echo "All as JSON:\n";
echo json_encode($users);
