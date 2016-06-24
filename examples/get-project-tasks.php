<?php
require_once('../asana.php');

// See class comments and Asana API for full info
$asana = new Asana(array('personalAccessToken' => 'xxxxxxxxxxxxxxxxxxxxx')); // Create a personal access token in Asana or use OAuth

$projectId = 'XXXXXXXXXXXXXXXXXXX'; // Your Project ID Key, you can get it in Asana

$asana->getProjectTasks($projectId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->hasError()) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}

echo '<pre>';
var_dump($asana->getData());
echo '</pre>';
