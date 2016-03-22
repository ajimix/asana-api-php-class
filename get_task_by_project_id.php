<?php

require_once('connection.php');
	$project_id = $_REQUEST['val1'];
	//echo $workspace_id;
	$taskbyid = $asana->getProjectTasks($project_id);
	$taskdata = json_decode($taskbyid);
	//print_r($taskdata );
	
?>
<table width="232" height="53" border="1">
<tr>
<th width="60" height="23">Task ID </th>
<th width="131">Task Name </th>
</tr>
<?php
foreach($taskdata->data as $alltask){	
?>
<tr>
<td height="22"> <?php echo number_format($alltask->id,0,null,''); ?> </td>
<td> <?php echo ($alltask->name); ?></td>
</tr>
<?php
}

?>
</table>
