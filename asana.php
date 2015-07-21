<?php
/**
 * A PHP class that acts as wrapper for Asana API. Lets make things easy! :)
 *
 * Read Asana API documentation for fully use this class https://asana.com/developers/api-reference/
 *
 * Copyright 2015 Ajimix
 * Licensed under the Apache License 2.0
 *
 * Author: Ajimix [github.com/ajimix] and the contributors [github.com/ajimix/asana-api-php-class/contributors]
 * Version: 2.14.0
 */

// Define some constants for later usage.
define('ASANA_METHOD_POST', 1);
define('ASANA_METHOD_PUT', 2);
define('ASANA_METHOD_GET', 3);
define('ASANA_METHOD_DELETE', 4);

class Asana
{
    private $timeout = 10;
    private $debug = false;
    private $advDebug = false; // Note that enabling advanced debug will include debugging information in the response possibly breaking up your code
    private $asanaApiVersion = '1.0';

    public $responseCode;

    private $endPointUrl;
    private $apiKey;
    private $accessToken;
    private $taskUrl;
    private $userUrl;
    private $projectsUrl;
    private $workspaceUrl;
    private $teamsUrl;
    private $storiesUrl;
    private $tagsUrl;
    private $organizationsUrl;
    private $attachmentsUrl;

    /**
     * Class constructor.
     *
     * @param array $options Array of options containing an apiKey OR and accessToken, not both.
     *                       Can be also an string if you want to use an apiKey.
     */
    public function __construct($options)
    {
        // For retro-compatibility purposes check if $options is a string,
        // so if a user passes a string we use it as the app key.
        if (is_string($options)) {
            $this->apiKey = $options;
        } elseif (is_array($options) && !empty($options['apiKey'])) {
            $this->apiKey = $options['apiKey'];
        } elseif (is_array($options) && !empty($options['accessToken'])) {
            $this->accessToken = $options['accessToken'];
        } else {
            throw new Exception('You need to specify an API key or token');
        }

        // If the API key is not ended by ":", we append it.
        if (!empty($this->apiKey) && substr($this->apiKey, -1) !== ':') {
            $this->apiKey .= ':';
        }

        $this->endPointUrl = 'https://app.asana.com/api/' . $this->asanaApiVersion . '/';
        $this->taskUrl = $this->endPointUrl . 'tasks';
        $this->userUrl = $this->endPointUrl . 'users';
        $this->projectsUrl = $this->endPointUrl . 'projects';
        $this->workspaceUrl = $this->endPointUrl . 'workspaces';
        $this->teamsUrl = $this->endPointUrl . 'teams';
        $this->storiesUrl = $this->endPointUrl . 'stories';
        $this->tagsUrl = $this->endPointUrl . 'tags';
        $this->organizationsUrl = $this->endPointUrl . 'organizations';
        $this->attachmentsUrl = $this->endPointUrl . 'attachments';
    }


    /**
     * **********************************
     * User functions
     * **********************************
     */

    /**
     * Returns the full user record for a single user.
     * Call it without parameters to get the users info of the owner of the API key.
     *
     * @param string $userId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getUserInfo($userId = null, array $opts = array())
    {
        $options = http_build_query($opts);

        if (is_null($userId)) {
            $userId = 'me';
        }

        return $this->askAsana($this->userUrl . '/' . $userId . '?' . $options);
    }

    /**
     * Returns the user records for all users in all workspaces you have access.
     *
     * @param array $opts Array of options to pass to the API
     *                    (@see https://asana.com/developers/api-reference/users)
     *
     *                    Example: Returning additional fields with 'opt_fields'
     *                    getUsers(['opt_fields' => 'name,email,photo,workspaces'])
     *
     * @return string JSON or null
     */
    public function getUsers(array $opts = array())
    {
        return $this->askAsana($this->userUrl . '?' . http_build_query($opts));
    }


    /**
     * **********************************
     * Task functions
     * **********************************
     */

    /**
     * Creates a task.
     * For assign or remove the task to a project, use the addProjectToTask and removeProjectToTask.
     *
     * @param array $data Array of data for the task following the Asana API documentation.
     * Example:
     *
     * array(
     *     "workspace" => "1768",
     *     "name" => "Hello World!",
     *     "notes" => "This is a task for testing the Asana API :)",
     *     "assignee" => "176822166183",
     *     "followers" => array(
     *         "37136",
     *         "59083"
     *     )
     * )
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function createTask($data, array $opts = array())
    {
        $data = array('data' => $data);
        $data = json_encode($data);
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '?' . $options, $data, ASANA_METHOD_POST);
    }

    /**
     * Returns task information
     *
     * @param string $taskId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getTask($taskId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '?' . $options);
    }

    /**
     * Creates a subtask in the parent task ID
     *
     * @param string $parentId The id of the parent task.
     * @param array $data Array of data for the task following the Asana API documentation.
     * Example:
     *
     * array(
     *     "name" => "Hello World!",
     *     "notes" => "This is a task for testing the Asana API :)",
     *     "assignee" => "176822166183",
     *     "followers" => array(
     *         "37136",
     *         "59083"
     *     )
     * )
     *
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function createSubTask($parentId, $data, array $opts = array())
    {
        $data = array('data' => $data);
        $data = json_encode($data);
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $parentId . '/subtasks?' . $options, $data, ASANA_METHOD_POST);
    }

    /**
     * Returns sub-task information
     *
     * @param string $taskId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getSubTasks($taskId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/subtasks?' . $options);
    }

    /**
     * Updated the parent from a task.
     *
     * @param string $taskId The task to update
     * @param string $parentId The id of the new parent task.
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function updateTaskParent($taskId, $parentId, array $opts = array())
    {
        $data = array('data' => array(
            'parent' => $parentId
        ));
        $data = json_encode($data);
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/setParent?' . $options, $data, ASANA_METHOD_POST);
    }

    /**
     * Updates a task
     *
     * @param string $taskId
     * @param array $data See, createTask function comments for proper parameter info.
     * @return string JSON or null
     */
    public function updateTask($taskId, $data)
    {
        $data = array('data' => $data);
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskId, $data, ASANA_METHOD_PUT);
    }

    /**
     * Deletes a task.
     *
     * @param string $taskId
     * @return string Empty if success
     */
    public function deleteTask($taskId)
    {
        return $this->askAsana($this->taskUrl . '/' . $taskId, null, ASANA_METHOD_DELETE);
    }

    /**
     * Moves a task within a project relative to another task.  This should let you take a task and move it below or
     * above another task as long as they are within the same project.
     *
     * @param string $projectId the project $taskReference is in and optionally $taskToMove is already in ($taskToMove will be
     *  added to the project if it's not already there)
     * @param string $taskToMove the task that will be moved (and possibly added to $projectId
     * @param string $taskReference the task that indicates a position for $taskToMove
     * @param bool $insertAfter true to insert after $taskReference, false to insert before
     * @return string JSON or null
     */
    public function moveTaskWithinProject($projectId, $taskToMove, $taskReference, $insertAfter = true)
    {
        $data = array('data' => array('project' => $projectId));
        if ($insertAfter) {
            $data['data']['insert_after'] = $taskReference;
        } else {
            $data['data']['insert_before'] = $taskReference;
        }
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskToMove . '/addProject', $data, ASANA_METHOD_POST);
    }

    /**
     * Returns the projects associated to the task.
     *
     * @param string $taskId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getProjectsForTask($taskId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/projects?' . $options);
    }

    /**
     * Adds a project to task. If successful, will return success and an empty data block.
     *
     * @param string $taskId
     * @param string $projectId
     * @param array $opt Array of options to pass (insert_after, insert_before, section)
     *                   (@see https://asana.com/developers/api-reference/tasks#projects)
     * @return string JSON or null
     */
    public function addProjectToTask($taskId, $projectId, array $opts = array())
    {
        $data = array('data' => array_merge($opts, array('project' => $projectId)));
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/addProject', $data, ASANA_METHOD_POST);
    }

    /**
     * Removes project from task. If successful, will return success and an empty data block.
     *
     * @param string $taskId
     * @param string $projectId
     * @return string JSON or null
     */
    public function removeProjectToTask($taskId, $projectId)
    {
        $data = array('data' => array('project' => $projectId));
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/removeProject', $data, ASANA_METHOD_POST);
    }

    /**
     * Returns task by a given filter.
     * For now (limited by Asana API), you may limit your query either to a specific project or to an assignee and workspace
     *
     * NOTE: As Asana API says, if you filter by assignee, you MUST specify a workspaceId and viceversa.
     *
     * @param array $filter The filter with optional values.
     *
     * array(
     *     "assignee" => "",
     *     "project" => 0,
     *     "workspace" => 0
     * )
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function getTasksByFilter($filter = array('assignee' => '', 'project' => '', 'workspace' => ''), array $opts = array())
    {
        $url = '';
        $filter = array_merge(array('assignee' => '', 'project' => '', 'workspace' => ''), $filter);

        $url .= $filter['assignee'] !== '' ? '&assignee=' . $filter['assignee'] : '';
        $url .= $filter['project'] !== '' ? '&project=' . $filter['project'] : '';
        $url .= $filter['workspace'] !== '' ? '&workspace=' . $filter['workspace'] : '';

        if (count($opts) > 0) {
            $url .= '&' . http_build_query($opts);
        }
        if (strlen($url) > 0) {
            $url = '?' . substr($url, 1);
        }

        return $this->askAsana($this->taskUrl . $url);
    }

    /**
     * Returns the list of stories associated with the object.
     * As usual with queries, stories are returned in compact form.
     * However, the compact form for stories contains more information by default than just the ID.
     * There is presently no way to get a filtered set of stories.
     *
     * @param string $taskId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getTaskStories($taskId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/stories?' . $options);
    }

    /**
     * Returns a compact list of tags associated with the object.
     *
     * @param string $taskId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getTaskTags($taskId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/tags?' . $options);
    }

    /**
     * Adds a comment to a task.
     * The comment will be authored by the authorized user, and timestamped when the server receives the request.
     *
     * @param string $taskId
     * @param string $text
     * @return string JSON or null
     */
    public function commentOnTask($taskId, $text = '')
    {
        $data = array(
            'data' => array(
                'text' => $text
            )
        );
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/stories', $data, ASANA_METHOD_POST);
    }

    /**
     * Adds a tag to a task. If successful, will return success and an empty data block.
     *
     * @param string $taskId
     * @param string $tagId
     * @return string JSON or null
     */
    public function addTagToTask($taskId, $tagId)
    {
        $data = array('data' => array('tag' => $tagId));
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/addTag', $data, ASANA_METHOD_POST);
    }

    /**
     * Removes a tag from a task. If successful, will return success and an empty data block.
     *
     * @param string $taskId
     * @param string $tagId
     * @return string JSON or null
     */
    public function removeTagFromTask($taskId, $tagId)
    {
        $data = array('data' => array('tag' => $tagId));
        $data = json_encode($data);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/removeTag', $data, ASANA_METHOD_POST);
    }

    /**
     * Returns single attachment information
     *
     * @param string $attachmentId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getAttachment($attachmentId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->attachmentsUrl . '/' . $attachmentId . '?' . $options);
    }

    /**
     * Add attachment to a task
     *
     * @param string $taskId
     * @param array $data (src of file, mymetype, finalFilename) See, Uploading an attachment to a task function comments for proper parameter info.
     * @return string JSON or null
     */
     public function addAttachmentToTask($taskId, array $data = array())
     {
         $mimeType = array_key_exists('mimeType', $data) ? $data['mimeType'] : null;
         $finalFilename = array_key_exists('finalFilename', $data) ? $data["finalFilename"] : null;

         if (class_exists('CURLFile', false)) {
             $data['file'] = new CURLFile($data['file'], $data['mimeType'], $data['finalFilename']);
         } else {
             $data['file'] = "@{$data['file']}";

             if (!is_null($finalFilename)) {
                 $data['file'] .= ';filename=' . $finalFilename;
             }
             if (!is_null($mimeType)) {
                 $data['file'] .= ';type=' . $mimeType;
             }
         }

         return $this->askAsana($this->taskUrl . '/' . $taskId . '/attachments', $data, ASANA_METHOD_POST);
     }

    /**
     * Returns task attachments information
     *
     * @param string $taskId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getTaskAttachments($taskId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '/' . $taskId . '/attachments?' . $options);
    }

    /**
     * **********************************
     * Projects functions
     * **********************************
     */

    /**
     * Function to create a project.
     *
     * @param array $data Array of data for the project following the Asana API documentation.
     * Example:
     *
     * array(
     *     "workspace" => "1768",
     *     "name" => "Foo Project!",
     *     "notes" => "This is a test project"
     * )
     *
     * @return string JSON or null
     */
    public function createProject($data)
    {
        $data = array('data' => $data);
        $data = json_encode($data);

        return $this->askAsana($this->projectsUrl, $data, ASANA_METHOD_POST);
    }

    /**
     * Returns the full record for a single project.
     *
     * @param string $projectId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getProject($projectId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->projectsUrl . '/' . $projectId . '?' . $options);
    }

    /**
     * Returns the projects in all workspaces containing archived ones or not.
     *
     * @param boolean $archived Return archived projects or not
     * @param string  $opt_fields Return results with optional parameters
     */
    public function getProjects($archived = false, $opt_fields = '')
    {
        $archived = $archived ? 'true' : 'false';
        $opt_fields = $opt_fields !== '' ? '&opt_fields=' . $opt_fields : '';

        return $this->askAsana($this->projectsUrl . '?archived=' . $archived . $opt_fields);
    }

    /**
     * Returns the projects in provided workspace containing archived ones or not.
     *
     * @param string $workspaceId
     * @param boolean $archived Return archived projects or not
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getProjectsInWorkspace($workspaceId, $archived = false, array $opts = array())
    {
        $archived = $archived ? 'true' : 'false';
        $options = http_build_query($opts);

        return $this->askAsana($this->projectsUrl . '?archived=' . $archived . '&workspace=' . $workspaceId . '&' . $options);
    }

    /**
     * Returns the projects in provided workspace containing archived ones or not.
     *
     * @param string $teamId
     * @param boolean $archived Return archived projects or not
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getProjectsInTeam($teamId, $archived = false, array $opts = array())
    {
        $archived = $archived ? 'true' : 'false';
        $options = http_build_query($opts);

        return $this->askAsana($this->teamsUrl . '/' . $teamId . '/projects?archived=' . $archived . '&' . $options);
    }

    /**
     * This method modifies the fields of a project provided in the request, then returns the full updated record.
     *
     * @param string $projectId
     * @param array $data An array containing fields to update, see Asana API if needed.
     * Example: array("name" => "Test", "notes" => "It's a test project");
     *
     * @return string JSON or null
     */
    public function updateProject($projectId, $data)
    {
        $data = array('data' => $data);
        $data = json_encode($data);

        return $this->askAsana($this->projectsUrl . '/' . $projectId, $data, ASANA_METHOD_PUT);
    }

    /**
     * Deletes a project.
     *
     * @param string $projectId
     * @return string Empty if success
     */
    public function deleteProject($projectId)
    {
        return $this->askAsana($this->projectsUrl . '/' . $projectId, null, ASANA_METHOD_DELETE);
    }

    /**
     * Returns all unarchived tasks of a given project
     *
     * @param string $projectId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function getProjectTasks($projectId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '?project=' . $projectId . '&' . $options);
    }

    /**
     * Returns the list of stories associated with the project.
     * As usual with queries, stories are returned in compact form.
     * However, the compact form for stories contains more
     * information by default than just the ID.
     * There is presently no way to get a filtered set of stories.
     *
     * @param string $projectId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getProjectStories($projectId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->projectsUrl . '/' . $projectId . '/stories?' . $options);
    }

    /**
     * Returns the list of sections associated with the project.
     * Sections are tasks whose names end with a colon character : .
     * For instance sections will be included in query results for tasks and
     * be represented with the same fields.
     * The memberships property of a task contains the project/section
     * pairs a task belongs to when applicable.
     *
     * @param string $projectId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getProjectSections($projectId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->projectsUrl . '/' . $projectId . '/sections?' . $options);
    }

    /**
     * Adds a comment to a project
     * The comment will be authored by the authorized user, and timestamped when the server receives the request.
     *
     * @param string $projectId
     * @param string $text
     * @return string JSON or null
     */
    public function commentOnProject($projectId, $text = '')
    {
        $data = array(
            'data' => array(
                'text' => $text
            )
        );
        $data = json_encode($data);

        return $this->askAsana($this->projectsUrl . '/' . $projectId . '/stories', $data, ASANA_METHOD_POST);
    }


    /**
     * **********************************
     * Tags functions
     * **********************************
     */

    /**
     * Returns the full record for a single tag.
     *
     * @param string $tagId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getTag($tagId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->tagsUrl . '/' . $tagId . '?' . $options);
    }

    /**
     * Returns the full record for all tags in all workspaces.
     *
     * @return string JSON or null
     */
    public function getTags()
    {
        return $this->askAsana($this->tagsUrl);
    }

    /**
     * Modifies the fields of a tag provided in the request, then returns the full updated record.
     *
     * @param string $tagId
     * @param array $data An array containing fields to update, see Asana API if needed.
     * Example: array("name" => "Test", "notes" => "It's a test tag");
     *
     * @return string JSON or null
     */
    public function updateTag($tagId, $data)
    {
        $data = array('data' => $data);
        $data = json_encode($data);

        return $this->askAsana($this->tagsUrl . '/' . $tagId, $data, ASANA_METHOD_PUT);
    }

    /**
     * This method creates a new tag and returns its full record.
     *
     * @param string $name Tag name
     * @param array $data An array containing either workspace or organization and the id.
     * Example: array("workspace" => "3242349871");
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function createTag($name, $data, array $opts = array())
    {
        $data = array('data' => $data);
        $data['data']['name'] = $name;
        $data = json_encode($data);
        $options = http_build_query($opts);

        return $this->askAsana($this->tagsUrl . '?' . $options, $data, ASANA_METHOD_POST);
    }

    /**
     * Returns the list of all tasks with this tag. Tasks can have more than one tag at a time.
     *
     * @param string $tagId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getTasksWithTag($tagId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->tagsUrl . '/' . $tagId . '/tasks?' . $options);
    }


    /**
     * **********************************
     * Stories and comments functions
     * **********************************
     */

    /**
     * Returns the full record for a single story.
     *
     * @param string $storyId
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     * @return string JSON or null
     */
    public function getSingleStory($storyId, array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->storiesUrl . '/' . $storyId . '?' . $options);
    }


    /**
     * **********************************
     * Organizations functions
     * **********************************
     */

    /**
     * Returns all teams in an Organization.
     *
     * @param string $organizationId
     * @return string JSON or null
     */
    public function getTeamsInOrganization($organizationId)
    {
        return $this->askAsana($this->organizationsUrl . '/' . $organizationId . '/teams');
    }


    /**
     * Function to create a team in an Organization.
     *
     * @param string $organizationId
     * @param array $data Array of data for the task following the Asana API documentation.
     * Example: array("name" => "Team Name")
     *
     * @return string JSON or null
     */
    public function createTeam($organizationId, $data)
    {
        $data = array('data' => $data);
        $data = json_encode($data);

        return $this->askAsana($this->organizationsUrl . '/' . $organizationId . '/teams', $data, ASANA_METHOD_POST);
    }


    /**
     * **********************************
     * Workspaces functions
     * **********************************
     */

    /**
     * Returns all the workspaces.
     *
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function getWorkspaces(array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->workspaceUrl . '?' . $options);
    }

    /**
     * Currently the only field that can be modified for a workspace is its name (as Asana API says).
     * This method returns the complete updated workspace record.
     *
     * @param array $data
     * Example: array("name" => "Test");
     *
     * @return string JSON or null
     */
    public function updateWorkspace($workspaceId, $data = array('name' => ''))
    {
        $data = array('data' => $data);
        $data = json_encode($data);

        return $this->askAsana($this->workspaceUrl . '/' . $workspaceId, $data, ASANA_METHOD_PUT);
    }

    /**
     * Returns tasks of all workspace assigned to someone.
     * Note: As Asana API says, you must specify an assignee when querying for workspace tasks.
     *
     * @param string $workspaceId The id of the workspace
     * @param string $assignee Can be "me" or user ID
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function getWorkspaceTasks($workspaceId, $assignee = 'me', array $opts = array())
    {
        $options = http_build_query($opts);

        return $this->askAsana($this->taskUrl . '?workspace=' . $workspaceId . '&assignee=' . $assignee . '&' . $options);
    }

    /**
     * Returns tags of all workspace.
     *
     * @param string $workspaceId The id of the workspace
     * @return string JSON or null
     */
    public function getWorkspaceTags($workspaceId)
    {
        return $this->askAsana($this->workspaceUrl . '/' . $workspaceId . '/tags');
    }

    /**
     * Returns users of all workspace.
     *
     * @param string $workspaceId The id of the workspace
     * @return string JSON or null
     */
    public function getWorkspaceUsers($workspaceId)
    {
        return $this->askAsana($this->workspaceUrl . '/' . $workspaceId . '/users');
    }

    /**
     * Returns search for objects from a single workspace.
     *
     * @param string $workspaceId The id of the workspace
     * @param string $type The type of object to look up. You can choose from one of the following: project, user, task, and tag.
     *                     Note that unlike other endpoints, the types listed here are in singular form.
     *                     Using multiple types is not yet supported.
     * @param string $query The value to look up
     * @param string $count The number of results to return with a minimum of 1 and a maximum of 100.
     *                      The default is 1 if this parameter is omitted.
     *                      If there are fewer results found than requested, all will be returned
     * @param array $opt Array of options to pass
     *                   (@see https://asana.com/developers/documentation/getting-started/input-output-options)
     *
     * @return string JSON or null
     */
    public function getWorkspaceTypeahead($workspaceId, $type, $query, $count = 1, array $opts = array())
    {
        $opts = array_merge($opts, array(
            'type' => $type,
            'query' => $query,
            'count' => $count
        ));
        $options = http_build_query($opts);
        return $this->askAsana($this->workspaceUrl . '/' . $workspaceId . '/typeahead?' . $options);
    }

    /**
     * This function communicates with Asana REST API.
     * You don't need to call this function directly. It's only for inner class working.
     *
     * @param string $url
     * @param string $data Must be a json string
     * @param int $method See constants defined at the beginning of the class
     * @return string JSON or null
     */
    private function askAsana($url, $data = null, $method = ASANA_METHOD_GET)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Don't print the result
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Don't verify SSL connection
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); //         ""           ""

        if (!empty($this->apiKey)) {
            // Send with API key.
            curl_setopt($curl, CURLOPT_USERPWD, $this->apiKey);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // Don't send as json when attaching files to tasks.
            if (is_string($data) || empty($data['file'])) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Send as JSON
            }
        } elseif (!empty($this->accessToken)) {
            // Send with auth token.
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->accessToken
            ));
        }

        if ($this->advDebug) {
            curl_setopt($curl, CURLOPT_HEADER, true); // Display headers
            curl_setopt($curl, CURLINFO_HEADER_OUT, true); // Display output headers
            curl_setopt($curl, CURLOPT_VERBOSE, true); // Display communication with server
        }

        if ($method == ASANA_METHOD_POST) {
            curl_setopt($curl, CURLOPT_POST, true);
        } elseif ($method == ASANA_METHOD_PUT) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        } elseif ($method == ASANA_METHOD_DELETE) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        if (!is_null($data) && ($method == ASANA_METHOD_POST || $method == ASANA_METHOD_PUT)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        try {
            $return = curl_exec($curl);
            $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($this->debug || $this->advDebug) {
                $info = curl_getinfo($curl);
                echo '<pre>';
                print_r($info);
                echo '</pre>';
                if ($info['http_code'] == 0) {
                    echo '<br>cURL error num: ' . curl_errno($curl);
                    echo '<br>cURL error: ' . curl_error($curl);
                }
                echo '<br>Sent info:<br><pre>';
                print_r($data);
                echo '</pre>';
            }
        } catch (Exception $ex) {
            if ($this->debug || $this->advDebug) {
                echo '<br>cURL error num: ' . curl_errno($curl);
                echo '<br>cURL error: ' . curl_error($curl);
            }
            echo 'Error on cURL';
            $return = null;
        }

        curl_close($curl);

        return $return;
    }
}
