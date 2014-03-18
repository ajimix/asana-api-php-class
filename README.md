Asana API PHP class
===================

A PHP class that acts as wrapper for Asana API.
Lets make things easy! :)

It is licensed under the Apache 2 license and is Copyrighted 2012 Ajimix


Working with the class
----------------------

First declare the asana class

    $asana = new Asana("YOUR_COOL_API_KEY", "YOUR_OAUTH_TOKEN");

YOUR_OAUTH_TOKEN is an optional parameter that can be retrieved using the below instructions. It allows you to improve usability flows by not requiring the user to look up their API key on asana.com.

Creating a task

    $asana->createTask(array(
       "workspace" => "176825", // Workspace ID
       "name" => "Hello World!", // Name of task
       "assignee" => "bigboss@bigcompany.com", // Assign task to...
       "followers" => array("3714136", "5900783") // We add some followers to the task... (this time by ID)
    ));

Adding task to project

	$asana->addProjectToTask("THIS_TASK_ID_PLEASE", "TO_THIS_COOL_PROJECT_ID");

Commenting on a task

    $asana->commentOnTask("MY_BEAUTIFUL_TASK_ID", "Please please! Don't assign me this task!");

Getting projects in all workspaces

	$asana->getProjects();

Updating project info

    $asana->updateProject("COOL_PROJECT_ID", array(
    	"name" => "This is a new cool project!",
    	"notes" => "At first, it wasn't cool, but after this name change, it is!"
    ));

etc.

Read comments on class for class magic and read [Asana API documentation](http://developer.asana.com/documentation/) if you want to be a master :D

Enjoy ;D

Using Asana oAuth tokens
------------------------

To use this API you can also create an App on Asana, in order to get an oAuth access token that gives you the same access as with an API key. Include the class:

	require_once('asana_oauth.php');

Declare the oAuth class as:

	$asana_auth = new AsanaAuth();
	$url = $asana_auth->RequestAccessCode("YOUR_APP_ID", "CALLBACK_URL");

where YOUR_APP_ID you get from your App's details on Asana. Now, redirect the browser to the result held by $url. The user will be asked to login & accept your app, after which the browser will be returned to the CALLBACK_URL, which should process the result:

	$code = $_GET["code"];
	$asana_auth = new AsanaAuth();
	$json = $asana_auth->GetAccessToken("YOUR_APP_ID", "YOUR_APP_SECRET", $code, "CALLBACK_URL");

YOUR_APP_SECRET you also get from your App's details. Now $json contains this:

	["access_token"]=> string(34) "0/39bd9b07b864acad1bbfdhfghsfy5" 
	["token_type"]=> string(6) "bearer" 
	["expires_in"]=> int(3600) 
	["data"]=> object(stdClass)#3 (3) { 
		["id"]=> int(5436345634567) 
		["name"]=> string(11) "Steve Jobs" 
		["email"]=> string(17) "steve@apple.com" } 
	["refresh_token"]=> string(34) "0/16c6799312b280fdghs8dugsd890fh"

Check Asana's docs on using the refresh token to get a new access token without requiring the user to login, as the default duration of a token is one hour.

Author
------

**Twitter:** [@ajimix](http://twitter.com/ajimix)

**GitHub:** [github.com/ajimix](https://github.com/ajimix)


Copyright and license
---------------------

Copyright 2012 Ajimix

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this work except in compliance with the License.
You may obtain a copy of the License in the LICENSE file, or at:

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.