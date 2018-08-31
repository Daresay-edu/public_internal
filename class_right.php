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
<a href='class_add.php' class='add-button'><span>Add new class</span></a>
<div class='cl'>&nbsp;</div>



<form name="form1" method="post" action="">
<div class='sort'>
<label>Classid</label>
<select class='field' name='classid'>

<?php
require_once("database_opt/db_opt.php");
	$conn=db_conn("daresay_db");
	$sql="SELECT * FROM class";							
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());	
    echo "<option value='All'>All</option>";	
	while ($row = mysql_fetch_assoc($result)) {
		$tmp=$row['classid'];
		echo "<option value='$tmp'>".$tmp."</option>";	
	}					
	mysql_close($conn);

?>
</select>

<br/>
<input class='submit' type="button" onclick="form1.action='class_manage.php?action=display';form1.submit();" value="Display"/><span></span>

<input class='submit' type="button" onclick="form1.action='class_manage.php?action=delete';form1.submit();" value="Delete"/><span></span>

<div class='cl'>&nbsp;</div>
</div>
</form>

</div>
</body>
</html>

