<?php

require_once('connection.php');

$alluser1 = $asana->getUsers();
$alluser = json_decode($alluser1);
//print_r($alluser);
	
?>
<table width="186" height="53" border="1">
<tr>
<th width="96" height="23">Project ID </th>
<th width="212">Project Name </th>
</tr>

<?php
foreach($alluser->data as $user){
//echo $user->id;
?>
<tr>
<td height="22"> <?php echo number_format( $user->id,0,null,''); ?> </td>
<td> <?php echo ($user->name); ?></td>
</tr>
<?php
}
?></table>
