5.0.0, 2017-03-02
-----------------
- Drop support for PHP 5.3, minimum requirement now is PHP 5.4
- Adds custom fields support (only available for Asana premium accounts)
- getProjects now can receive an array of options
- removeProjectToTask deprecated, please use removeProjectFromTask

4.3.0, 2017-02-10
-----------------
- getData now converts floats to strings inside the array, so ID's are returned as a proper string

4.2.0, 2016-11-16
-----------------
- Adds fast API open beta option
- $timeout, $debug and $advDebug are now public properties so they can be changed without the need to edit class code

4.1.0, 2016-09-05
-----------------
- Adds method to return current user teams: getMyTeams

4.0.0, 2016-06-24
-----------------
- Deprecates API Key
- Adds Personal Access Tokens support

3.1.0, 2016-06-03
-----------------
- Adds methods for adding and removing followers from a task
- Adds methods for managing Asana webhooks

3.0.1, 2016-06-03
-----------------
- Fix bug when using oauth and attaching files

3.0.0, 2015-11-23
-----------------
- Now return type can be set to ASANA_RETURN_TYPE_OBJECT, ASANA_RETURN_TYPE_JSON or ASANA_RETURN_TYPE_ARRAY
- New method to get the latest returned data getData()
- New method to check if there were errors hasError()

2.14.0, 2015-07-21
------------------
- getWorkspaceTypeahead method added.

2.13.0, 2015-06-13
------------------
- getUsers now accepts array of options

2.12.0, 2015-05-20
------------------
- Added method createTag to create a tag in a workspace or organization.

2.11.0, 2015-05-20
------------------
- getWorkspaces now accepts an array of options.

2.10.0, 2015-05-07
------------------
- New method for getting projects in a team.

2.9.0, 2015-05-02
-----------------
- Added support for working with sections.
- Now you can pass options when adding a project to a task so section, insert_before, or insert_after can be specified.
- Updated the links in the documentation to point to the right ones.

2.8.2, 2015-04-07
-----------------
- The standard PHP PSR-2-code applied.
- Fix error when debugging the response.

2.8.1, 2014-09-22
-----------------
- Fix typo in add attachment function.
- Improved debug output.

2.8.0, 2014-09-19
-----------------
- Added a method for getting attachment information.
- Added a method for getting all the attachments from a task.

2.7.1, 2014-09-16
-----------------
- Fix json header was not being sent properly.

2.7.0, 2014-09-02
-----------------
- Constant definitions are now outside of the class constructor.

2.6.0, 2014-09-01
-----------------
- Added a method for creating a subtask.
- Added a method to change the parent of a task.
- Now addTask accepts options.

2.5.0, 2014-08-23
-----------------
- Added a method to retrieve the tags from a task getTaskTags.

2.4.3, 2014-07-25
-----------------
- Bugfix release.

2.4.2, 2014-07-25
-----------------
- Added support for attaching files prior to PHP 5.5.

2.4.1, 2014-07-10
-----------------
- Added extra debugging information.
- Added autoload to composer file.

2.4.0, 2014-07-02
-----------------
- Added a method to add attachments to a task.

2.3.0, 2014-06-07
-----------------
- Added a method to delete a task.
- Added a method to delete a project.

2.2.0, 2014-05-28
-----------------
- Added a method to move tasks inside the project moveTaskWithinProject.

2.1.0, 2014-04-09
-----------------
- Added teams functions. createTeam and getTeamsInOrganization.

2.0.0, 2014-03-19
-----------------
- Added OAuth support with AsanaAuth class.
- Improved class readability.
- Improved performance.
- Added options to getTasksByFilter.

1.0.0, 2012-04-24
-----------------
- Initial release.
