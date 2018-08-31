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
<a href='school_add.php' class='add-button'><span>Add new school</span></a>
<div class='cl'>&nbsp;</div>

<form action="school_manage.php?action=display" method="post">
<div class='sort'>
<label>School ID</label>
<select class='field' name='schoolid' id="schoolid">
<option value="All">All</option>
<?php
	require_once("database_opt/db_opt.php");
	$conn=db_conn("daresay_db");
	$sql="SELECT * FROM school";
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());			
	while ($row = mysql_fetch_assoc($result)) {
		echo "<option value='{$row['schoolid']}'>{$row['schoolid']}</option>";
	}
?>

</select>
<br/>
<input type='submit' class='submit' value='Display School'/><span></span>
<div class='cl'>&nbsp;</div>
</div>

</form>

<form name="form1" method="post" action="">
<div class='sort'>
<label>School ID</label>
<select class='field' name='schoolid1' id="schoolid1">
<?php
	require_once("database_opt/db_opt.php");
	$conn=db_conn("daresay_db");
	$sql="SELECT * FROM school";
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());			
	while ($row = mysql_fetch_assoc($result)) {
		echo "<option value='{$row['schoolid']}'>{$row['schoolid']}</option>";
	}
?>

</select>
<br/>
<input type="button" class='submit' onclick="form1.action='school_manage.php?action=delete';form1.submit();" value="Delete"/><span></span>
<div class='cl'>&nbsp;</div>
</div>
</form>

</div>
</body>
</html>

