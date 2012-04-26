<?php
/**
*
* A PHP class that acts as wrapper for Asana API. Lets make things easy! :)
*
* Read Asana API documentation for fully use this class http://developer.asana.com/documentation/
* 
* Copyright 2012 Ajimix
* Licensed under the Apache License 2.0
*
* Author: Ajimix [github.com/ajimix]
* Version: 1.0
*
*/
class Asana {

    private $timeout = 10;
    private $debug = false;
    private $asanaApiVersion = "1.0";

    public $responseCode;

    private $endPointUrl;    
    private $apiKey;
    private $taskUrl;
    private $userUrl;
    private $projectsUrl;
    private $workspaceUrl;
    private $storiesUrl;

    public function __construct($apiKey){
        $this->apiKey = $apiKey;
        
        $this->endPointUrl = "https://app.asana.com/api/{$this->asanaApiVersion}/";
        $this->taskUrl = $this->endPointUrl."tasks";
        $this->userUrl = $this->endPointUrl."users";
        $this->projectsUrl = $this->endPointUrl."projects";
        $this->workspaceUrl = $this->endPointUrl."workspaces";
        $this->storiesUrl = $this->endPointUrl."stories";

        define("METHOD_POST", 1);
        define("METHOD_PUT", 2);
        define("METHOD_GET", 3);
    }
    

    /**
     * **********************************
     * User functions 
     * **********************************
     */
    
    /**
     * This method returns the full user record for a single user.
     * Call it without parameters to get the users info of the owner of the API key.
     * 
     * @param string $userId
     * @return boolean 
     */
    public function getUserInfo($userId = null){
        if(is_null($userId)) $userId = "me";
        return $this->askAsana($this->userUrl."/{$userId}");
    }
    
    /**
     * This method returns the user records, for all users in all workspaces you may access.
     * 
     * @return type 
     */
    public function getUsers(){
        return $this->askAsana($this->userUrl);
    }
    
    
    /**
     * **********************************
     * Task functions
     * **********************************
     */
    
    /**
     * Function to create a task.
     * For assigning or removing the task to a project, use the addProjectToTask and removeProjectToTask.
     * 
     * 
     * @param array $data Array of data for the task following the API documentation.
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
     * 
     * @return string JSON or null
     */
    public function createTask($data){
        $data = array("data" => $data);
        $data = json_encode($data);
        return $this->askAsana($this->taskUrl, $data, METHOD_POST);
    }

    /**
     * Returns task information
     * 
     * @param string $taskId
     * @return string JSON or null
     */
    public function getTask($taskId){
        return $this->askAsana($this->taskUrl."/{$taskId}");
    }
    
    /**
     * Updates a task
     * 
     * @param string $taskId
     * @param array $data See, createTask comments for proper parameter info.
     * @return string JSON or null
     */
    public function updateTask($taskId, $data){
        $data = array("data" => $data);
        $data = json_encode($data);
        return $this->askAsana($this->taskUrl."/{$taskId}", $data, METHOD_PUT);
    }
    
    /**
     * Returns the projects associated to the task.
     * 
     * @param string $taskId
     * @return string JSON or null
     */
    public function getProjectsForTask($taskId){
        return $this->askAsana($this->taskUrl."/{$taskId}/projects");
    }
    
    /**
     * Adds a project to task. If successful, will return success and an empty data block.
     * 
     * @param string $taskId
     * @param string $projectId
     * @return string JSON or null
     */
    public function addProjectToTask($taskId, $projectId){
        $data = array("data" => array("project" => $projectId));
        $data = json_encode($data);
        return $this->askAsana($this->taskUrl."/{$taskId}/addProject", $data, METHOD_POST);
    }
    
    /**
     * Removes project from task. If successful, will return success and an empty data block.
     * 
     * @param string $taskId
     * @param string $projectId
     * @return string JSON or null
     */
    public function removeProjectToTask($taskId, $projectId){
        $data = array("data" => array("project" => $projectId));
        $data = json_encode($data);
        return $this->askAsana($this->taskUrl."/{$taskId}/removeProject", $data, METHOD_POST);
    }
    
    /**
     * Returns task by a given filter.
     * 
     * @param array $filter The filter with optional values
     * 
     * array(
     *     "assignee" => "",
     *     "project" => 0,
     *     "workspace" => 0
     * )
     * 
     * @return string JSON or null
     */
    public function getTasksByFilter($filter = array("assignee" => "", "project" => "", "workspace" => "")){
        $url = "";
        $url .= $filter["assignee"] != ""?"&assignee={$filter["assignee"]}":"";
        $url .= $filter["project"] != ""?"&project={$filter["project"]}":"";
        $url .= $filter["workspace"] != ""?"&workspace={$filter["workspace"]}":"";
        if(strlen($url) > 0) $url = "?".substr($url, 1);
        
        return $this->askAsana($this->taskUrl.$url);
    }
    
    /**
     * Returns the list of stories associated with the object.
     * As usual with queries, stories are returned in compact form.
     * However, the compact form for stories contains more information by default than just the ID.
     * There is presently no way to get a filtered set of stories.
     * 
     * @param string $taskId
     * @return string JSON or null
     */
    public function getTaskStories($taskId){
        return $this->askAsana($this->taskUrl."/{$taskId}/stories");
    }
    
    /**
     * Adds a comment to an object.
     * The comment will be authored by the authorized user, and timestamped when the server receives the request.
     * 
     * @param string $taskId
     * @param string $text
     * @return string JSON or null
     */
    public function commentOnTask($taskId, $text = ""){
        $data = array(
            "data" => array(
                "text" => $text
            )
        );
        $data = json_encode($data);
        return $this->askAsana($this->taskUrl."/{$taskId}/stories", $data, METHOD_POST);
    }
    
    
     /**
     * **********************************
     * Projects functions 
     * **********************************
     */
    
    /**
     * This method returns the full record for a single project.
     * 
     * @param string $projectId
     * @return string JSON or null
     */
    public function getProject($projectId){
        return $this->askAsana($this->projectsUrl."/{$projectId}");
    }
    
    /**
     * This method returns the projects, according to the filter criteria provided.
     * 
     * @param boolean $archived Return archived projects or not
     */
    public function getProjects($archived = false){
        $archived = $archived?"true":"false";
        return $this->askAsana($this->projectsUrl."?archived={$archived}");
    }
    
    /**
     * This method returns the projects, according to the filter criteria provided.
     * 
     * @param string $workspaceId
     * @param boolean $archived Return archived projects or not
     */
    public function getProjectsInWorkspace($workspaceId, $archived = false){
        $archived = $archived?"true":"false";
        return $this->askAsana($this->projectsUrl."?archived={$archived}&workspace={$workspaceId}");
    }
    
    /**
     * This method modifies the fields of a project provided in the request, then returns the full updated record.
     * 
     * @param string $projectId
     * @param array $data
     * Example: array("name" => "Test", "notes" => "It's a test project");
     * 
     * @return string JSON or null
     */
    public function updateProject($projectId, $data){
        $data = array("data" => $data);
        $data = json_encode($data);
        return $this->askAsana($this->projectsUrl, $data, METHOD_PUT);
    }
    
    
    /**
     * **********************************
     * Stories and comments functions 
     * **********************************
     */
    
    /**
     * This method returns the full record for a single story.
     * 
     * @param type $storyId
     * @return string JSON or null
     */
    public function getSingleStory($storyId){
        return $this->askAsana($this->storiesUrl."/{$storyId}");
    }
    
    
    /**
     * **********************************
     * Workspaces functions
     * **********************************
     */
    
    /**
     * This method returns the workspace records.
     * 
     * @return string JSON or null
     */
    public function getWorkspaces(){
        return $this->askAsana($this->workspaceUrl);
    }
    
    /**
     * Currently the only field that can be modified for a workspace is its name.
     * This method returns the complete updated workspace record.
     * 
     * @param array $data
     * Example: array("name" => "Test");
     * 
     * @return string JSON or null
     */
    public function updateWorkspace($workspaceId, $data = array("name" => "")){
        $data = array("data" => $data);
        $data = json_encode($data);
        return $this->askAsana($this->workspaceUrl."/{$workspaceId}", $data, METHOD_PUT);
    }
    

    /**
     * This function communicates with asana REST API
     * 
     * @param string $url
     * @param string $data Must be a json string
     * @param int $method See constants defined
     * @return string JSON or null
     */
    private function askAsana($url, $data = null, $method = METHOD_GET){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Don't print the result
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Don't verify SSL connection
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); //         ""           ""
        curl_setopt($curl, CURLOPT_USERPWD, $this->apiKey);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); // Send as JSON ;D
        if($this->debug){
            curl_setopt($curl, CURLOPT_HEADER, true); // Display headers
            curl_setopt($curl, CURLOPT_VERBOSE, true); // Display communication with server
        }
        if($method == METHOD_POST){
            curl_setopt($curl, CURLOPT_POST, true);
        } else if($method == METHOD_PUT){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        }
        if(!is_null($data) && ($method == METHOD_POST || $method == METHOD_PUT)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        try {
            $return = curl_exec($curl);
            $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if($this->debug){ echo "<pre>"; print_r(curl_getinfo($curl)); echo "<pre>"; }  // Testing purposes
        } catch(Exception $ex){
            if($this->debug){
                echo "<br>cURL error num: ".curl_errno($curl); // Testing purposes
                echo "<br>cURL error: ".curl_error($curl);  // Testing purposes
            }
            e("Error on cURL");
            $return = null;
        }

        curl_close($curl);

        return $return;
    }
}