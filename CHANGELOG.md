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
