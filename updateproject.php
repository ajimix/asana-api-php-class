<center><h1> Welcome to project update </h1>
<h3> You can only update project name and notes.</h3>
<?php
require_once('connection.php');

$proid = $_REQUEST['p_id'];
//$proid	='99922212768833';

$getprojdata = $asana->getProject($proid);
$prohecjson = json_decode($getprojdata);
?>
<form method="post">
<table width="435">
<tr> 
<td width="95"> Project ID</td>
<?php
foreach($prohecjson as $prodata){
	//print_r($prodata);
?>
<td width="328"> :- <label><b> <?php echo number_format($prodata->id,0,null,''); ?> </b></label></td>
</tr>
<tr>
<td> Name</td>
<td>:-
  <input type="text" name="proname" id="proname"  placeholder="<?php echo $prodata->name;?>"  size="35"/> </td>
</tr>

<tr >
<td> Notes</td>
<td valign="top"> :-
  <textarea name="pronotes" placeholder="<?php echo $prodata->notes;?>"  rows="4" cols="30"></textarea></td>
</tr>
<?php
}
?>

<tr align="center">
<td colspan="2"> <input type="submit" value="update"  name="update" /></td>
</tr>
</table>
</form>
</center>
<?php
if(isset($_POST['update'])){
	$proidnew = number_format($prodata->id,0,null,'');
	$newna = $_POST['proname'];
	$newnote = $_POST['pronotes'];
	
	$updata = $asana->updateProject($proidnew, array(
    'name' => $newna,
    'notes' => $newnote
	));
	
	if ($asana->hasError()) {
			echo 'Error while assigning project to task: ' . $asana->responseCode;
		} else {
			echo 'Success to add the task to a project.';
			echo "<script type='text/javascript'>"."alert('Success to add the task to a project.'); location.reload;"."</script>";
			
		}


	}
?>


<h4>This block contain mor details of this project..</h4>
<?php 
echo "<pre>";
print_r(json_decode($getprojdata));