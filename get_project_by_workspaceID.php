<?php

require_once('connection.php');
/*
$workspace_id = $_REQUEST['val'];

echo $workspace_id ;
*/


$workspace_id = $_REQUEST['val'];
//	$workspace_id = '99915435644125';
	//echo $workspace_id;
	$projectbyid = $asana->getProjectsInWorkspace($workspace_id);
	$projectdata = json_decode($projectbyid);
	//print_r($projectbyid );
	
?>
<table width="228" height="97" border="1">
<tr>
<th width="116">Project ID </th>
<th width="192">Project Name </th>
</tr>
<?php
//print_r($projectdata);
foreach($projectdata->data as $allproject){	

?>
<tr>
<td height="47"> <?php echo number_format($allproject->id,0,null,''); ?> </td>
<td> <?php echo ($allproject->name); ?></td>
<td> <a href="updateproject.php?p_id=<?php echo number_format($allproject->id,0,null,'');?> " > <input type="button" value="update" /></a> </td>
</tr>
<?php
}
?>
</table>
<script>
/*$(".updateproj").click(function(){
	$.ajax({
		Type:'POST',
		url:'updateproject.php',
		data:{
			datv:$(this).attr('id')		
			}
		});
		
	
	
	});
*/

</script>