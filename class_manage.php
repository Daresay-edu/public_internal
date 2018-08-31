<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DareSay Education</title>
	<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/flowplayer-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.pack.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/fancyplayer.js"></script>
    <script type="text/javascript">

	     var videopath = "../teach_source/";
	     var swfplayer = videopath + "player/flowplayer-3.1.1.swf";

    </script>
    <style type="text/css">
    table
{
	width: 720px;
	margin: 0 auto;
	border-collapse:collapse;
	font-size: 15px;
}
table, tr, td
{
	border: 1px solid;
	text-align:center;
}
td
{
height: 30px;
}
</style>

</head>
<body>
<!-- Header -->
<?php
	include("header_manage.php");
?>
<!-- End Header -->

<!-- Container -->
<div id="container">
	<div class="shell">
		
		<!-- Small Nav -->
		<div class="small-nav">
			<a href="#">班级管理</a>
		</div>
		<!-- End Small Nav -->
		
		<!-- Message OK -->		
		
		<!-- End Message Error -->
		<br />
		<!-- Main -->
		<div id="main">
			<div class="cl">&nbsp;</div>
			
			<!-- Content -->
			<div id="content">
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left"></h2>
                    			</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<div class="vidoes">
                      			<!-- Add Videos -->
                      			<br/>
					<?php
					require_once("database_opt/db_opt.php");
					require_once("phpmail/sendmail_interface.php");
					$db_table="class";
						switch($_GET["action"]) {
							case "display":
								$classid=$_POST["classid"];
								$conn=db_conn("daresay_db");
								if ($classid=="All")
									$sql="SELECT * FROM $db_table";
								else 
									$sql="SELECT * FROM $db_table WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								echo "<table>";
								if(strcmp($classid,"All") == 0) {
										echo "<tr>";
										echo "<td>ID</td>";
										echo "<td>班级</td>";
										echo "<td>开班时间</td>";
										echo "<td>上课时间</td>";
										echo "<td>授课教师</td>";
										echo "<td>班级邮箱</td>";
										echo "<td>备注</td>";
										echo "</tr>";
										$i=1;
										while ($row = mysql_fetch_assoc($result)) {
											echo "<tr>";
												echo "<td>".$i++."</td>";
												echo "<td>".$row['classid']."</td>";
												echo "<td>".$row['open_time']."</td>";
												echo "<td>".$row['class_time']."</td>";
												echo "<td>".$row['teachers']."</td>";
												echo "<td>".$row['mail_address']."</td>";
												echo "<td>".$row['note']."</td>";
											echo "</tr>";
										}
										
								} else {
										$result=mysql_query($sql,$conn);
										if (!$result)
											die("SQL: {$sql}<br>Error:".mysql_error());						

										echo "<table border='0' width=500px  align='center'>";
										$row = mysql_fetch_assoc($result);
										echo "<tr>";
											echo "<td>班级</td>";
											echo "<td>".$row['classid']."</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td>开课时间</td>";
											echo "<td>".$row['open_time']."</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td>上课时间</td>";
											echo "<td>".$row['class_time']."</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td >授课教师</td>";
											echo "<td>".$row['teachers']."</td>";
										echo "</tr>";
											echo "<tr>";
											echo "<td >班级邮箱</td>";
											echo "<td>".$row['mail_address']."</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td >班级资源位置</td>";
											echo "<td>".$row['source1']."</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td >课后资源位置</td>";
											echo "<td>".$row['source2']."</td>";
										echo "</tr>";
										echo "<tr>";
											echo "<td>备注</td>";
											echo "<td>".$row['note']."</td>";
										echo "</tr>";
									
								}
								echo "</table>";
								echo "<br/><br/>";

							break;
							case "add":
								$classid=$_POST["classid"];
								$year=$_POST["year"];
								$month=$_POST["month"];
								$day=$_POST["day"];
								
								$fir_day=$_POST["fir_day"];
								$fir_day_hour=$_POST["fir_day_hour"];
								$fir_day_minute=$_POST["fir_day_minute"];
								$sec_day=$_POST["sec_day"];
								$sec_day_hour=$_POST["sec_day_hour"];
								$sec_day_minute=$_POST["sec_day_minute"];
								$teachers=$_POST["teachers"];
								$mail=$_POST["mail"];
								$source2=$_POST["source2"];
								$source1=$_POST["source1"];
								$note=$_POST["note"];		
								
								$open_time=$year."-".$month."-".$day;
								$fir_day=$fir_day.$fir_day_hour.":".$fir_day_minute;
								$sec_day=$sec_day.$sec_day_hour.":".$sec_day_minute;
								$class_time=$fir_day.",".$sec_day;
								$conn=db_conn("daresay_db");

								$result =mysql_fetch_row(mysql_query("SHOW TABLES LIKE '{$db_table}' "));
								if(!$result){
									//表不存在，创建表
									$sql="CREATE TABLE {$db_table} (id INT(20) not null AUTO_INCREMENT,classid varchar(32),open_time varchar(32),
									class_time varchar(32),teachers varchar(32), mail_address varchar(32),source1 varchar(1000),source2 varchar(1000),
									note varchar(1000),primary key(id))";
									$result=mysql_query($sql, $conn);
									if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
									}
								}
								
								//check if have the student in this class 
								$sql="SELECT * FROM {$db_table} WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo $classid."已经存在！";	
									mysql_close($conn);
									exit;

								}
								
								
								
								// insert into db
								$sql="INSERT INTO $db_table(classid, open_time, class_time, teachers, mail_address, source1, source2, note)
								      VALUES ('$classid', '$open_time', '$class_time', '$teachers', '$mail', '$source1', '$source2', '$note');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM $db_table WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td>班级</td>";
										echo "<td>".$row['classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>开课时间</td>";
										echo "<td>".$row['open_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>上课时间</td>";
										echo "<td>".$row['class_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td >授课教师</td>";
										echo "<td>".$row['teachers']."</td>";
									echo "</tr>";
										echo "<tr>";
										echo "<td >班级邮箱</td>";
										echo "<td>".$row['mail_address']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td >班级资源位置</td>";
										echo "<td>".$row['source1']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td >课后资源位置</td>";
										echo "<td>".$row['source2']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								
							break;
						
							case "delete":
								$classid=$_POST["classid"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM $db_table WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if (!$row) {
									echo "记录不存在!请重新输入!";
									mysql_close($conn);
									exit;

								}

									echo "<table border='0' width=500px  align='center'>";
									echo "<tr>";
										echo "<td>班级</td>";
										echo "<td>".$row['classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>开课时间</td>";
										echo "<td>".$row['open_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>上课时间</td>";
										echo "<td>".$row['class_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td >授课教师</td>";
										echo "<td>".$row['teachers']."</td>";
									echo "</tr>";
										echo "<tr>";
										echo "<td >班级邮箱</td>";
										echo "<td>".$row['mail_address']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td >班级资源位置</td>";
										echo "<td>".$row['source1']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td >课后资源位置</td>";
										echo "<td>".$row['source2']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";

								$sql="DELETE FROM $db_table WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								mysql_close($conn);
						
								echo "以上班级信息已经成功删除!";
								echo "<br/><br/>";
							break;
							case "modify":
								$classid=$_POST["classid"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM $db_table WHERE name='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								if ($row = mysql_fetch_assoc($result)) {
									$classid=$row['name'];
									$open_time=$row['open_time'];
									$class_time=$row['class_time'];
									$source=$row['source_addr'];
									$note=$row['note'];
								} else {
									echo "No record!";
									exit;
								}
								

								echo "<form action='class_manage.php?action=modify_do' method='post'>
								       <table border='0' align='center' width='800'>
									<tr>
									<td align='center' >班级名称</td>
									<td><input type='text' name='classid' value='$classid'/></td>
									</tr>
									<tr>
									<tr>
									<td align='center' >开班时间</td>
									<td><input type='text' name='open_time' value='$open_time'/></td>
									</tr>
									<tr>
									<td align='center' >上课时间</td>
								
									<td><input type='text' name='lesson_time' value='$class_time'/></td>
									</tr>
									<tr>
									<td align='center' >资源地址</td>
									<td><input type='text' name='source_addr' value='$source'/></td>
									</tr>
									<tr>
									<tr>
									<td align='center' >备注</td>
									<td><input type='text' name='note' value='$note'/></td>
									</tr>
									<tr>";
									
									echo "
										<tr>
										<td align='right'><input type='submit' name='add' value='修改'/></td>
										</tr>";
									echo "<tr>
										<td>
										<input type='hidden' name='classid_hide' value='$classid' />
										</td>
										</tr>";

									echo "</table></form>";


								mysql_close($conn);

							break;
							case "modify_do":
							
								$classid=$_POST["classid"];
								$open_time=$_POST["open_time"];
								$lesson_time=$_POST["lesson_time"];
								$source_addr=$_POST["source_addr"];
								$note=$_POST["note"];
								$classid_old=$_POST["classid_hide"];

								//check if have the same engname in db
								$conn=db_conn("daresay_db");

								$sql="DELETE FROM $db_table WHERE name='$classid_old'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								
								// insert into db
								$sql="INSERT INTO $db_table(name, open_time, class_time, source_addr, note)
								      VALUES ('$classid', '$open_time', '$lesson_time', '$source_addr','$note');";
									  
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM $db_table WHERE name='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td>班级</td>";
										echo "<td>".$row['name']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>开班时间</td>";
										echo "<td>".$row['open_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>上课时间</td>";
										echo "<td>".$row['class_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>资源位置</td>";
										echo "<td>".$row['source_addr']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								mysql_close($conn);
						}	
					?>
                          
					</div>
					<!-- Table -->
					
				</div>
				<!-- End Box -->
				
			</div>
			<!-- End Content -->
			
			<!-- Sidebar -->
			<div id="sidebar">
				
				<!-- Box -->
				<div class="box">
					
					<!-- Box Head -->
					<div class="box-head">
						<h2>Management</h2>
					</div>
					<!-- End Box Head-->
					<?php
						include "class_right.php";	
					?>

					
				</div>
				<!-- End Box -->
			</div>
			<!-- End Sidebar -->
			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->

<!-- Footer -->
<?php
	include("bottom.php");
?>
<!-- End Footer -->
	
</body>
</html>
