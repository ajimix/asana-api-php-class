<?php
/**
 * This is just a simple example of a webhook target that you must implement in order to be able to create it properly with the API.
 * The url should respond to https POST requests and has to be accessible by ASANA.
 *
 * For more information please read the following resources:
 * https://asana.com/developers/api-reference/webhooks
 * http://resthooks.org/docs/security/
 */
header('x-hook-secret: ' . $_SERVER['HTTP_X_HOOK_SECRET']);
echo '200 OK';
