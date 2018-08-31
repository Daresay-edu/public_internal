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
			<a href="#">学生管理</a>
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
					header("Content-type: text/html;charset=utf-8");
					require_once("phpmail/sendmail_interface.php");
					require_once("database_opt/db_opt.php");
						switch($_GET["action"]) {
							case "display":
								$classid=$_POST["classid"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM students WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								echo "<table>";
								echo "<tr>";
								echo "<td>ID</td>";
								echo "<td>姓名</td>";
								echo "<td>英文姓名</td>";
								echo "<td>年龄</td>";
								echo "<td>电话</td>";
								echo "<td>所在学校</td>";
								echo "<td>班级</td>";
								echo "<td>缴费课时</td>";
								echo "<td>金额</td>";
								echo "<td>积分</td>";
								echo "</tr>";
								$i=1;
								while ($row = mysql_fetch_assoc($result)) {
									echo "<tr>";
										echo "<td>".$i++."</td>";
										echo "<td>".$row['name']."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['age']."</td>";
										echo "<td>".$row['phone']."</td>";
										echo "<td>".$row['school']."</td>";
										echo "<td>".$row['classid']."</td>";
										echo "<td>".$row['hour_begin']."至".$row['hour_end']."</td>";
										echo "<td>".$row['charge']."</td>";
										echo "<td>".$row['credit']."</td>";
									echo "</tr>";
								}
								echo "</table>";
								echo "<br/><br/>";

							break;
							case "add":
								$name=$_POST["name"];
								$engname=$_POST["engname"];
								$age=$_POST["age"];
								$phone=$_POST["phone"];
								$school=$_POST["school"];
								$classid=$_POST["classid"];
								$charge=$_POST["charge"];
								$hour_begin=$_POST["hour_begin"];
								$hour_end=$_POST["hour_end"];
								$note=$_POST["note"];
								$year=$_POST["year"];
								$month=$_POST["month"];
								$day=$_POST["day"];
								$sex=$_POST["sex"];
								$credit=$_POST["credit"];
								$online=$_POST["online"];

								$pay_time=$year."-".$month."-".$day;
								//check if have the same engname in db
								$conn=db_conn("daresay_db");
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
								// insert into students table
								$sql="INSERT INTO students (name, engname, classid, age, phone,school, pay_time, 
									charge,  hour_begin, hour_end, note, sex, credit)
								      VALUES ('$name', '$engname', '$classid', '$age', '$phone', '$school', '$pay_time',
								      '$charge','$hour_begin', '$hour_end','$note', '$sex', '$credit');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								
								// insert into online_user table
								if ($online == 1) {
									$lastday=0;
									//get passwd
									$tmp_ascii="";
									for($i=0;$i<strlen($engname);$i++){
										$tmp_ascii=$tmp_ascii.ord($engname[$i]);
										//echo ord($engname[$i]);
									}
									$tmp_ascii=substr($tmp_ascii,1,4);
									$hour_begin = 0;
									$sql="INSERT INTO online_user (name, engname, classid, passwd, hour_begin, hour_end, lastday, note, access_times)
										  VALUES ('$name', '$engname', '$classid','$tmp_ascii', '$hour_begin', '$hour_end','$lastday', '$note', '0');";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								
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
										echo "<td>课时</td>";
										echo "<td>".$row['hour_begin']."至".$row['hour_end']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>积分</td>";
										echo "<td>".$row['credit']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								mysql_close($conn);
								$where = "1";
                                send_mail("18020023616@163.com", "New Student From ".$where, $name."-".$age."岁-".$school."-".$phone);
							break;
						
							case "delete":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM students WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$num = mysql_num_rows($result);
								if (!$num) {
									echo $classid."班不存在学生".$engname."!请重新输入!";
									mysql_close($conn);
									exit;

								}
								echo "<table>";
								echo "<tr>";
								echo "<td>姓名</td>";
								echo "<td>英文姓名</td>";
								echo "<td>年龄</td>";
								echo "<td>电话</td>";
								echo "<td>所在学校</td>";
								echo "<td>班级</td>";
								echo "<td>缴费课时</td>";
								echo "</tr>";
								while ($row = mysql_fetch_assoc($result)) {
									
									echo "<tr>";
										echo "<td>".$row['name']."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['age']."</td>";
										echo "<td>".$row['phone']."</td>";
										echo "<td>".$row['school']."</td>";
										echo "<td>".$row['classid']."</td>";
										echo "<td>".$row['hour_begin']."至".$row['hour_end']."</td>";
									echo "</tr>";
								}
								$sql="DELETE FROM students WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());	

								$sql="DELETE FROM online_user WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());									
								mysql_close($conn);

								echo "</table>";
								echo "<br/><br/>";
								echo "以上学生信息已经成功删除!";
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
								$hour_begin=$row['hour_begin'];
								$hour_end=$row['hour_end'];
								$note=$row['note'];
								$sex=$row['sex'];
								$credit=$row['credit'];


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
										require_once("database_opt/db_opt.php");
										
										$sql="SELECT * FROM class";							
										$result=mysql_query($sql,$conn);
										if (!$result)
											die("SQL: {$sql}<br>Error:".mysql_error());	
										while ($row = mysql_fetch_assoc($result)) {
											$tmp=$row['classid'];
											if (strcmp($tmp, $classid)==0)
													echo "<option value='{$classid}' 
														selected='selected'>{$classid}</option>";
											else 
												echo "<option value='$tmp'>".$tmp."</option>";	
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
										<td align='center' >缴费课时:</td>
										 <td><select name='hour_begin'>";
											$fir_tmp=0;
											$i=0;
											for ($i;$i<97;$i++) {
												if ($fir_tmp == $hour_begin)
													echo "<option value='{$fir_tmp}' 
														selected='selected'>{$fir_tmp}</option>";
												else 
													echo "<option value='{$fir_tmp}'>{$fir_tmp}</option>";
													
												$fir_tmp=$fir_tmp+2;
											}
										echo "</select>";
										echo "至";
										echo "<select name='hour_end'>";	
										$fir_tmp=0;
											$i=0;
											for ($i;$i<97;$i++) {
												if ($fir_tmp == $hour_end)
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
										<td align='center' >积分:</td>
										<td><input type='text' name='credit' value='$credit'/></td>
										</tr>
										<tr>
											<td align='center' >修改Online</td>
											<td><select class='field' name='online'>
												<option value='1'>是</option>;
												<option value='0'>否</option>;
												</select>
											</td>
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
							case "copy":
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
								$hour_begin=$row['hour_begin'];
								$hour_end=$row['hour_end'];
								$note=$row['note'];
								$sex=$row['sex'];
								$credit=$row['credit'];


								echo "<form action='students_manage.php?action=copy_do' method='post'>
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
										require_once("database_opt/db_opt.php");
										
										$sql="SELECT * FROM class";							
										$result=mysql_query($sql,$conn);
										if (!$result)
											die("SQL: {$sql}<br>Error:".mysql_error());	
										while ($row = mysql_fetch_assoc($result)) {
											$tmp=$row['classid'];
											if (strcmp($tmp, $classid)==0)
													echo "<option value='{$classid}' 
														selected='selected'>{$classid}</option>";
											else 
												echo "<option value='$tmp'>".$tmp."</option>";	
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
										<td align='center' >缴费课时:</td>
										 <td><select name='hour_begin'>";
											$fir_tmp=0;
											$i=0;
											for ($i;$i<97;$i++) {
												if ($fir_tmp == $hour_begin)
													echo "<option value='{$fir_tmp}' 
														selected='selected'>{$fir_tmp}</option>";
												else 
													echo "<option value='{$fir_tmp}'>{$fir_tmp}</option>";
													
												$fir_tmp=$fir_tmp+2;
											}
										echo "</select>";
										echo "至";
										echo "<select name='hour_end'>";	
										$fir_tmp=0;
											$i=0;
											for ($i;$i<97;$i++) {
												if ($fir_tmp == $hour_end)
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
										<td align='center' >积分:</td>
										<td><input type='text' name='credit' value='$credit'/></td>
										</tr>
										<tr>
											<td align='center' >修改Online</td>
											<td><select class='field' name='online'>
												<option value='1'>是</option>;
												<option value='0'>否</option>;
												</select>
											</td>
										</tr>
										<tr>
										<td align='right'><input type='submit' name='add' value='Copy'/></td>
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
							case "copy_do":
								$name=$_POST["name"];
								$engname=$_POST["engname"];
								$age=$_POST["age"];
								$phone=$_POST["phone"];
								$school=$_POST["school"];
								$classid=$_POST["classid"];
								$charge=$_POST["charge"];
								$hour_begin=$_POST["hour_begin"];
								$hour_end=$_POST["hour_end"];
								$note=$_POST["note"];
								$pay_time=$_POST["pay_time"];
								$sex=$_POST["sex"];
								$credit=$_POST["credit"];
								$online=$_POST["online"];

								
								//check if have the same engname in db
								$conn=db_conn("daresay_db");
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
								// insert into students table
								$sql="INSERT INTO students (name, engname, classid, age, phone,school, pay_time, 
									charge,  hour_begin, hour_end, note, sex, credit)
								      VALUES ('$name', '$engname', '$classid', '$age', '$phone', '$school', '$pay_time',
								      '$charge','$hour_begin', '$hour_end','$note', '$sex', '$credit');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								
								// insert into online_user table
								if ($online == 1) {
									$lastday=0;
									//get passwd
									$tmp_ascii="";
									for($i=0;$i<strlen($engname);$i++){
										$tmp_ascii=$tmp_ascii.ord($engname[$i]);
										//echo ord($engname[$i]);
									}
									$tmp_ascii=substr($tmp_ascii,1,4);
									$hour_begin = 0;
									$sql="INSERT INTO online_user (name, engname, classid, passwd, hour_begin, hour_end, lastday, note, access_times)
										  VALUES ('$name', '$engname', '$classid','$tmp_ascii', '$hour_begin', '$hour_end','$lastday', '$note', '0');";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								
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
										echo "<td>课时</td>";
										echo "<td>".$row['hour_begin']."至".$row['hour_end']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>积分</td>";
										echo "<td>".$row['credit']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								mysql_close($conn);
								$where = "888";
                                send_mail("18020023616@163.com", "New Student From ".$where, $name."-".$age."岁-".$school."-".$phone);
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
								$hour_begin=$_POST["hour_begin"];
								$hour_end=$_POST["hour_end"];
								$note=$_POST["note"];
								$sex=$_POST["sex"];
								$online=$_POST["online"];
								$credit=$_POST["credit"];
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
								$hour_begin = 0;
								$sql="INSERT INTO students (name, engname, classid, age, phone,school, pay_time, 
									charge,  hour_begin,hour_end, 	note, sex, credit)
								      VALUES ('$name', '$engname', '$classid', '$age', '$phone', '$school', '$pay_time',
								      '$charge','$hour_begin','$hour_end', '$note', '$sex', '$credit');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								
								if ($online == 1) {
									//update online_user
									$lastday=0;
									//get passwd
									$tmp_ascii="";
									for($i=0;$i<strlen($engname);$i++){
										$tmp_ascii=$tmp_ascii.ord($engname[$i]);
										//echo ord($engname[$i]);
									}
									$tmp_ascii=substr($tmp_ascii,1,4);
									
									$sql="UPDATE online_user SET name='$name', engname='$engname', classid='$classid', passwd='$tmp_ascii', 
										 hour_begin='$hour_begin', hour_end='$hour_end', lastday='$lastday',
										 note='$note' WHERE classid='$classid_hide' AND engname='$engname_hide'";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								
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
										echo "<td>".$row['hour_begin']."至".$row['hour_end']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>积分</td>";
										echo "<td>".$row['credit']."</td>";
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
						include "students_right.php";	
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
