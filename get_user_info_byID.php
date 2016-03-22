<?php
require_once('connection.php');

$userid1 = $_REQUEST['val2'];
$uuserdata = $asana->getUserInfo($userid1);


$userid = json_decode($uuserdata);

//echo"<pre>";
//print_r($userid);
?>
<table width="240" height="239" border="1">

<?php
foreach($userid as $uerda){

?>
<tr>
<th width="80" height="36">User ID </th>
<td width="231"> <?php echo number_format($uerda->id,0,null,''); ?> </td>
</tr>

<tr>
<th width="80" height="36">User Name </th>
<td> <?php echo $uerda->name; ?> </td>
</tr>

<tr>
<th width="80" height="36">User Email </th>
<td> <?php echo $uerda->email; ?> </td>
</tr>

<tr>
<th width="80" height="23">USer Photo </th>
<td> <?php echo $uerda->photo; ?> </td>
</tr>

<tr>
<th width="80" height="36">Workspace Info </th>
<td>
	<?php
    foreach ($uerda->workspaces as $sam){
        //print_r($sam);
    ?>
    <table width="146" border="1"> 
    <tr>
    <td width="55"> ID </td>
    <td width="75"> <?php echo number_format($sam->id,0,null,''); ?> </td>
    </tr>
     <tr>
    <td> Name </td>
    <td> <?php echo $sam->name; ?> </td>
    </tr>
    </table>
    
    
    
    <?php 	}  ?>
    </td>
</tr>
<?php
}
?>
</table>