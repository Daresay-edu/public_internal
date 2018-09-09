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
					switch($_GET["action"]) {
						case "see":
							$classid = $_POST["classid"];
							$password = $_POST["password"];
							
							$conn=db_conn("daresay_db");
							$table_name="teachers";
							//operator must be Edward
							$sql="SELECT * FROM {$table_name} WHERE engname='admin'";
							$result=mysql_query($sql,$conn);
							if (!$result) {
								die("SQL: {$sql}<br>Error:".mysql_error());
							}
							$row = mysql_fetch_assoc($result);
							if ($password != $row['password']) {
								echo "<script>alert('口令不对');window.history.go(-1);</script>";
								exit;
							}
							echo "<form name='remind' action='remind_action_makeup_finish.php' method='post' target='_blank'>";
							echo "<input type='hidden' name='classid' id='classid' value='def'/>
						<input type='hidden' name='engname' id='engname' value='def'/>
						<input type='hidden' name='toclassid' id='toclassid' value='def'/>
						<input type='hidden' name='ab_hour' id='ab_hour' value='def'/>";
							require_once("database_opt/public.php");
							if (strcmp($classid, "All")==0) {
								$table_name="class";
								$sql="SELECT * FROM {$table_name}";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());	
								while ($row = mysql_fetch_assoc($result)) {
									$classid=$row['classid'];
									print_remind_by_classid($classid);
										
								
								}
							} else {
								echo "<center>";
								$ret = print_remind_by_classid($classid);
								echo "</center>";
								if ($ret != 1)
									echo "班级类型不对！必须为K或者S班级。";
							}
							echo "</form>";
								break;
						case "makeup_finish":
								echo "wo";
								break;
					}

						?>
						
					
				
	
</body>
</html>
