Asana API PHP class
===================

A PHP class that acts as wrapper for Asana API.
Lets make things easy! :)

It is licensed under the Apache 2 license and is Copyrighted 2012 Ajimix


Working with the class
----------------------

First declare the asana class

    $asana = new Asana("YOUR_COOL_API_KEY");

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