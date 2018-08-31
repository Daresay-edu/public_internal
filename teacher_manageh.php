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
			<a href="#">教师管理</a>
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
						switch($_GET["action"]) {
							case "display":
								$engname=$_POST["engname"];
								$conn=db_conn("daresay_db");
								if(strcmp($engname,"All")==0) {
									$sql="SELECT * FROM teachers";
								}
								else
									$sql="SELECT * FROM teachers WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								echo "<table>";
								echo "<tr>";
								echo "<td>姓名</td>";
								echo "<td>英文名</td>";
								echo "<td>年龄</td>";
								echo "<td>电话</td>";
								echo "<td>入职日期</td>";
								echo "<td>主教课时费</td>";
								echo "<td>助教课时费</td>";
								echo "</tr>";
								$i=1;
								while ($row = mysql_fetch_assoc($result)) {
									echo "<tr>";
										echo "<td>".$row['name']."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['age']."</td>";
										echo "<td>".$row['phone']."</td>";
										echo "<td>".$row['join_date']."</td>";
										echo "<td>".$row['chief_salary']."</td>";
										echo "<td>".$row['assist_salary']."</td>";
									echo "</tr>";
								}
								echo "</table>";
								echo "<br/><br/>";

							break;
							case "add":
								$name=$_POST["name"];
								$engname=$_POST["engname"];
								$age=$_POST["age"];
								$sex=$_POST["sex"];
								$phone=$_POST["phone"];
								$chief_salary=$_POST["chief_salary"];
								$assist_salary=$_POST["assist_salary"];
								$note=$_POST["note"];
								$year=$_POST["year"];
								$month=$_POST["month"];
								$day=$_POST["day"];
								$password=$_POST["password"];
								

								$join_date=$year."-".$month."-".$day;
								//check if have the same engname in db
								$conn=db_conn("daresay_db");
								$table_name="teachers";
								//check table exsit or not, if not create it
								$result =mysql_fetch_row(mysql_query("SHOW TABLES LIKE 'teachers' "));
								if(!$result){
									//表不存在，创建表
									$sql="CREATE TABLE {$table_name} (id INT(20) not null AUTO_INCREMENT,name varchar(32),engname varchar(32),
									age varchar(32),sex varchar(32), phone varchar(32),join_date varchar(32),chief_salary varchar(32),
									assist_salary varchar(32), password varchar(32), note varchar(1000),primary key(id))";
									$result=mysql_query($sql, $conn);
									if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
									}
								}
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo "已经存在英文名字为".$engname."的老师!请重新输入!";	
									mysql_close($conn);
									exit;

								}
								// insert into db
								$sql="INSERT INTO {$table_name} (name, engname, age, sex, phone, join_date, chief_salary, 
									assist_salary, password, note)
								      VALUES ('$name', '$engname', '$age', '$sex', '$phone', '$join_date', '$chief_salary',
								      '$assist_salary','$password','$note');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td align='center'>名字</td>";
										echo "<td>".$row['name']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>英文名字</td>";
										echo "<td>".$row['engname']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>年龄</td>";
										echo "<td>".$row['age']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>电话</td>";
										echo "<td>".$row['phone']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>入职日期</td>";
										echo "<td>".$row['join_date']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>主课时费</td>";
										echo "<td>".$row['chief_salary']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>助课时费</td>";
										echo "<td>".$row['assist_salary']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>口令</td>";
										echo "<td>".$row['password']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								mysql_close($conn);

							break;
						
							case "delete":
								$engname=$_POST["engname"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM teachers WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								
								echo "<table>";
								echo "<tr>";
								echo "<td>姓名</td>";
								echo "<td>英文名</td>";
								echo "<td>年龄</td>";
								echo "<td>电话</td>";
								echo "<td>入职日期</td>";
								echo "<td>主教课时费</td>";
								echo "<td>助教课时费</td>";
								echo "</tr>";
								$i=1;
								while ($row = mysql_fetch_assoc($result)) {
									echo "<tr>";
										echo "<td>".$row['name']."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['age']."</td>";
										echo "<td>".$row['phone']."</td>";
										echo "<td>".$row['join_date']."</td>";
										echo "<td>".$row['chief_salary']."</td>";
										echo "<td>".$row['assist_salary']."</td>";
									echo "</tr>";
								}
								$sql="DELETE FROM teachers WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								mysql_close($conn);

								echo "</table>";
								echo "<br/><br/>";
								echo "以上教师信息已经成功删除!";
								echo "<br/><br/>";
							break;
							case "modify":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM students WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								$row = mysql_fetch_assoc($result);
								if (!$row) {
									echo $classid."班不存在学生".$engname."!请重新输入!";
									mysql_close($conn);
									exit;

								}

								$name=$row['name'];
								$engname=$row['engname'];
								$age=$row['age'];
								$phone=$row['phone'];
								$school=$row['school'];
								$classid=$row['classid'];
								$pay_time=$row['pay_time'];
								$charge=$row['charge'];
								$hour=$row['hour'];
								$note=$row['note'];
								$sex=$row['sex'];


								echo "<form action='students_manage.php?action=modify_do' method='post'>
								       <table border='0' align='center' width='800'>
									<tr>
									<td align='center' >姓名:</td>
									<td><input type='text' name='name' value='$name'/></td>
									</tr>
									<tr>
									<td align='center' >英文名:</td>
									<td><input type='text' name='engname' value='$engname'/></td>
									</tr>
									<tr>
									<td align='center' >年龄:</td>
									<td><input type='text' name='age' value='$age'/></td>
									</tr>
									<tr>
									           <td align='center' >性别:</td>
										   <td><input type='text' name='sex' value='$sex'/></td>
									</tr>

									<tr>
									<td align='center' >电话:</td>
									<td><input type='text' name='phone' value='$phone'/></td>
									</tr>
									<tr>
									<td align='center' >所在学校:</td>
									<td><input type='text' name='school' value='$school'/></td>
									</tr>

									<tr>
									<td align='center' >班级</td>
									<td><select name='classid'>";
									include('attendance/attendance_array.php');
									foreach($class_list as $K=>$V) {
										if ($V==$classid)
											echo "<option value='{$V}' selected='selected'>{$V}</option>";
										else 
											echo "<option value='{$V}'>{$V}</option>";
									}
									echo "</td>
										</tr>
										<tr>
										<td align='center' >缴费日期:</td>
										<td><input type='text' name='pay_time' value='$pay_time'/></td>
										</tr>
										<tr>
										<td align='center' >缴费金额:</td>
										<td><input type='text' name='charge' value='$charge'/></td>
										</tr>
										<tr>
										<td align='center' >缴费至课时:</td>
										 <td><select name='hour'>";
											$fir_tmp=2;
											$i=0;
											for ($i;$i<96;$i++) {
												if ($fir_tmp == $hour)
													echo "<option value='{$fir_tmp}' 
														selected='selected'>{$fir_tmp}</option>";
												else 
													echo "<option value='{$fir_tmp}'>{$fir_tmp}</option>";
													
												$fir_tmp=$fir_tmp+2;
											}


										echo "</select>
										</td>
										</tr>
										<tr>
										<td align='center' >备注:</td>
										<td><input type='text' name='note' value='$note'/></td>
										</tr>
										<tr>
										<td align='right'><input type='submit' name='add' value='修改'/></td>
										</tr>";
										echo "<tr>
											<td>
											<input type='hidden' name='engname_hide' value='$engname' />
											</td>
											<td>
											<input type='hidden' name='classid_hide' value='$classid' />
											</td>
											</tr>";


									echo "</table></form>";


								mysql_close($conn);

							break;
							case "modify_do":
								$name=$_POST["name"];
								$engname=$_POST["engname"];
								$age=$_POST["age"];
								$phone=$_POST["phone"];
								$school=$_POST["school"];
								$classid=$_POST["classid"];
								$pay_time=$_POST["pay_time"];
								$charge=$_POST["charge"];
								$hour=$_POST["hour"];
								$note=$_POST["note"];
								$sex=$_POST["sex"];
								$engname_hide=$_POST["engname_hide"];
								$classid_hide=$_POST["classid_hide"];


								//check if have the same engname in db
								$conn=db_conn("daresay_db");

								$sql="DELETE FROM students WHERE engname='$engname_hide' and classid='$classid_hide'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$sql="SELECT * FROM students WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo $classid."班已经存在英文名字为".$engname."的学生!请重新输入!";	
									mysql_close($conn);
									exit;

								}
								// insert into db
								$sql="INSERT INTO students (name, engname, classid, age, phone,school, pay_time, 
									charge,  hour, 	note, sex)
								      VALUES ('$name', '$engname', '$classid', '$age', '$phone', '$school', '$pay_time',
								      '$charge','$hour', '$note', '$sex');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM students WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td align='center'>名字</td>";
										echo "<td>".$row['name']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>英文名字</td>";
										echo "<td>".$row['engname']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>年龄</td>";
										echo "<td>".$row['age']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>电话</td>";
										echo "<td>".$row['phone']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>所在学校</td>";
										echo "<td>".$row['school']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>班级</td>";
										echo "<td>".$row['classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>缴费时间</td>";
										echo "<td>".$row['pay_time']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>缴费金额</td>";
										echo "<td>".$row['charge']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>课时数</td>";
										echo "<td>".$row['hour']."</td>";
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
						include "teacher_righth.php";	
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
