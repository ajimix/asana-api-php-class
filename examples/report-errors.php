<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$taskId = 5555555555;  // Something invalid to provoke an error
$asana->getTask($taskId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Asana responded with HTTP error: ' . $asana->responseCode . "<br />";
    $errors = $asana->getErrors();
    foreach ($errors as $key => $error) {
        $key++;
        echo "Error $key: " . $error->message . '<br />'; // The error details, such as "task: Not a recognized ID: 5555555555"
        echo "Details: " . $error->help . '<br />'; // Details, which seems to just link to the getting-started/errors documentation
    }
    return;
}

echo "Task details:" . PHP_EOL;
var_dump($asana->getData());
