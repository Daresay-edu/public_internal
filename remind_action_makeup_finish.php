<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DareSay Education</title>
	<script type="text/javascript" src="js/daresay.js"></script>
    <style type="text/css">
 table
{
	border-collapse:collapse;
	font-size:20px;
}
 table, tr, td
{
border: 1px solid;
}
td 
{
	cellpadding:4;
	
}
.title td
{
	text-align:center;
	width:340px;
	
}
.content td
{
	text-align:center;
	width:140px;
	height:57px;
}
</style>
</head>
<body>
					
                   		
					<?php
						require_once("database_opt/db_opt.php");
						$engname=$_POST["engname"];
						$classid=$_POST["classid"];
						$ab_hour=$_POST["ab_hour"];
						$toclassid=$_POST["toclassid"];
						$conn=db_conn("daresay_db");
						$sql="SELECT * FROM absent WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
						$result=mysql_query($sql,$conn);
						if (!$result)
							die("SQL: {$sql}<br>Error:".mysql_error());	
						$row = mysql_fetch_assoc($result);
						$current_time=date('Y-m-d',time());
						$sql="UPDATE absent SET finish='yes',note='$current_time',in_classid='$toclassid' WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
						$result=mysql_query($sql,$conn);
						if (!$result)
							die("SQL: {$sql}<br>Error:".mysql_error());	
						$sql="SELECT * FROM absent WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
						$result=mysql_query($sql,$conn);
						if (!$result)
							die("SQL: {$sql}<br>Error:".mysql_error());
						$row = mysql_fetch_assoc($result);
						if (!$row) {
									mysql_close($conn);
									exit;

						}
						echo $row['classid']." ".$row['engname']." ".$row['ab_hour']." ".$row['finish']." ".$row['note'];
						echo "<br/>";
						echo "Success! Already copy the makeup info to Clipper!";
						mysql_close($conn);
					?>
						
					
				
	
</body>
</html>
