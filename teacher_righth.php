<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>DareSay Education</title>
<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/daresay.js"></script>
</head>
<body>

<div class='box-content'>
<a href='teacher_addh.php' class='add-button'><span>Add new teacher</span></a>
<div class='cl'>&nbsp;</div>

<form action="teacher_manageh.php?action=display" method="post">
<div class='sort'>
<label>English Name</label>
<select class='field' name='engname' id="engname">
<option value="All">All</option>
<?php
	require_once("database_opt/db_opt.php");
	$conn=db_conn("daresay_db");
	$sql="SELECT * FROM teachers";
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());			
	while ($row = mysql_fetch_assoc($result)) {
		echo "<option value='{$row['engname']}'>{$row['engname']}</option>";
	}
?>

</select>
<br/>
<input type='submit' class= 'submit'style="background-color:#F9EBAE" value='Display Teacher'/><span></span>
<div class='cl'>&nbsp;</div>
</div>

</form>

<form name="form1" method="post" action="">
<div class='sort'>
<label>English Name</label>
<select class='field' name='engname' id="engname">
<option value="All">All</option>
<?php
	require_once("database_opt/db_opt.php");
	$conn=db_conn("daresay_db");
	$sql="SELECT * FROM teachers";
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());			
	while ($row = mysql_fetch_assoc($result)) {
		echo "<option value='{$row['engname']}'>{$row['engname']}</option>";
	}
?>
</select>
<br/>
<input type="button" class= 'submit'style="background-color:#F9EBAE" onclick="form1.action='teacher_manageh.php?action=delete';form1.submit();" value="Delete"/><span></span>
<div class='cl'>&nbsp;</div>
</div>
</form>

</div>
</body>
</html>

