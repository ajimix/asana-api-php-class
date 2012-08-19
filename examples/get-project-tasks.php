<?php
require_once("asana.php");

// See class comments and Asana API for full info

$asana = new Asana("XXXXXXXXXXXXXXXXXXX"); // Your API Key, you can get it in Asana
$projectId = 'XXXXXXXXXXXXXXXXXXX'; // Your Project ID Key, you can get it in Asana

$result = $asana->getProjectTasks($projectId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if($asana->responseCode == "200" && !is_null($result)){
	$resultJson = json_decode($result);

	var_dump($resultJson);

} else {
	echo "Error while trying to connect to Asana, response code: {$asana->responseCode}";
}