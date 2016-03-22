<center><h2> Welcome To Asana Webservice Main page.</h2>
<script src="jquery.js"> </script>

<?php
require_once('connection.php');


echo"<h3>"."You have All available Workspace Are:"."</h3>";

$allworkspace = $asana->getWorkspaces();

$convertjson = json_decode($allworkspace);
?>
<table width="324" height="84" border="1">
<tr>
<th width="151">Workspace ID </th>
<th width="157">Workspace Name </th>
</tr>

<?php
foreach($convertjson->data as $alljson){	
?>
<tr>
<td> <?php echo number_format($alljson->id,0,null,''); ?> </td>
<td> <?php echo ($alljson->name); ?></td>
</tr>
<?php
}
?>
</table>
<br /><br />


<br /><br />
<div>
    <div style="float:left; background-color:#E4E4F1" >
    <form method="post" action="">
    <table width="254" height="118">
    <tr>
      <th width="220" height="55">Search Project In Workspace By Id</th>
      </tr>
    <tr>
    <th height="55">
      <input type="text" name="get_project" id="get_project" placeholder="copy paste workspace id here" required/>
      <input type="button" name="click_project" id="click_project" value="search" />    </th>
    </tr>
    </table>
    </form>
    <div id="prolist"> </div>
    </div>
    
    
    
  <div style="float:left;background-color:#EAEAEA" >
    <form method="post" action="">
    <table width="228" height="118">
    <tr>
      <th height="55">Search Task In Project By Id</th>
      </tr>
    <tr>
    <th height="55">
      <input type="text" name="get_task" id="get_task" placeholder="copy paste task id here" required/>
      <input type="button" name="click_task" id="click_task" value="search" />    </th>
    </tr>
    </table>
    </form>
    <div id="tasklist"> </div>
    </div>

  <div style="float:left;background-color:#EDE7FE" >
    <form method="post" action="">
    <table width="175" height="118">
    <tr>
      <th height="55">Search All user</th>
      </tr>
    <tr>
    <th height="55">
      
      <input type="button" name="click_user" id="click_user" value="search uers" />    </th>
    </tr>
    </table>
    </form>
    <div id="userlist"> </div>
    </div>

  <div style="float:left;background-color:#FEF4E2" >
    <form method="post" action="">
    <table width="182" height="118">
    <tr>
      <th height="55">USerinfo by ID</th>
      </tr>
    <tr>
    <th height="55">
      <input type="text" name="get_userinfo" id="get_userinfo" placeholder="copy paste task id here" required/>
      <input type="button" name="getinfouser" id="getinfouser" value="search" />    </th>
    </tr>
    </table>
    </form>
    <div id="userinfo"> </div>
    </div>
</div>



<script>
$(document).ready(function(){
	
	$("#click_project").click(function(){
		var workspaceid = document.getElementById('get_project').value;
		//alert(workspaceid);
		$.ajax({
			type:'POST',
			url:'get_project_by_workspaceID.php',
			data:{
				val:workspaceid
				},
			success:function(responce){
				$("#prolist").html(responce);
				},
			error:function(error,xhr,status){
				alert(status);
				}
			});

		});
		
		
	$("#click_task").click(function(){
	var taskid = document.getElementById('get_task').value;
		//alert(workspaceid);
		$.ajax({
			type:'POST',
			url:'get_task_by_project_id.php',
			data:{
				val1:taskid
				},
			success:function(responce){
				$("#tasklist").html(responce);
				},
			error:function(error,xhr,status){
				alert(status);
				}
			});

		});
	
	$("#click_user").click(function(){
		$.ajax({
			type:'post',
			url:'get_all_user_name.php',
			success:function(responce){
				$("#userlist").html(responce);
				},
			error:function(error,xhr,status){
				alert(status);
				}
			
			});
	});
	
	$("#getinfouser").click(function(){
		
		var userid = document.getElementById('get_userinfo').value;
		$.ajax({
			type:'POST',
			url:'get_user_info_byID.php',
			data:{
				val2:userid
				},
			success:function(responce){
				$('#userinfo').html(responce);
				},
			error:function(error,xhr,responce){
				alert(responce);
			}
			});
		});

});

</script>