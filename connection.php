<?php
require 'vendor/autoload.php';
require_once('asana.php');

$asana = new Asana(array(
    'apiKey' => '*******************',
	'client_id' => '***********************',
    'client_secret' => '************************',
    'redirect_uri' => '*******************************'
));