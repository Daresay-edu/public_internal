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
			<a href="#">收入计算</a>
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
								/*分如下步骤：
								1. 判断输入密码是否为Edward
								2. 根据输入的classid从class表中获取相应班级
								3. 根据输入的起始和结束日期从各个对应的class_info_record中找到对应的起始和结束课时
								4. 根据起始和结束课时同班级每位学生的缴费课时起始和结束做比较，
								   获取在此时间范围内学生学了多少课时，用每个学生的课时数乘以每课时的钱数即为当前时间范围内赚取到该学生的学费
								5. 把所有学生的课时费加总即获取指定时间的总收入
								*/
								$classid=$_POST["classid"];
								$yearfrom=$_POST["yearfrom"];
								$monthfrom=$_POST["monthfrom"];
								$dayfrom=$_POST["dayfrom"];
								$yearend=$_POST["yearend"];
								$monthend=$_POST["monthend"];
								$dayend=$_POST["dayend"];
								$password=$_POST["password"];
								$type=$_POST["type"];
								
								$datefrom=$yearfrom."-".$monthfrom."-".$dayfrom;
								$dateend=$yearend."-".$monthend."-".$dayend;
								$total_income=0;
								
								$conn=db_conn("daresay_db");
								
								$table_name="teachers";
								$sql="SELECT * FROM {$table_name} WHERE engname='Edward'";
								$result=mysql_query($sql,$conn);
								if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								$row = mysql_fetch_assoc($result);
								if ($password != $row['password']) {
										echo "<script>alert('口令不对');window.history.go(-1);</script>";
										exit;
								}
								if (strtotime($dateend) < strtotime($datefrom)) {
									echo "<script>alert('终止时间不能小于起始时间！');window.history.go(-1);</script>";
									exit;
								}
								
								$class_arr=array();
								$i=0;
								if (strcmp($classid,"All") == 0) {
									$table_name="class";
									$sql="SELECT * FROM {$table_name}";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());
									while ($row = mysql_fetch_assoc($result)) {
										$class_arr[$i]=$row['classid'];
										$i++;
									}
								} else {
									$class_arr[$i]=$classid;
								}
								if (strcmp($type, "income") == 0 ) {
									echo "<h2>".$datefrom."至".$dateend."的收入总计: </h2>";
								} else if (strcmp($type, "all") == 0) {
									echo "<h2>从".$datefrom."至现在总共收取: </h2>";
								}
								echo "<br/><br/>";
								echo "<table>";
								echo "<tr>";
								echo "<td>班级</td>";
								echo "<td>英文名</td>";
								echo "<td>缴费课时</td>";
								echo "<td>计入课时</td>";
								echo "<td>课时费</td>";
								echo "</tr>";
								foreach ($class_arr as $classid_tmp) {
									$find=0;
									$table_name="class_info_record";
									$sql="SELECT * FROM {$table_name} where classid='$classid_tmp'";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());
									$hour_begin=0;
									$hour_end=0;
									$small_date=strtotime($dateend);
									$big_date=strtotime($datefrom);
									//根据日期找到班级对应的课时范围
									while ($row = mysql_fetch_assoc($result)) {
										$tmp_date=explode("(",$row['date']);
										$tmp_date=$tmp_date[0];
										
										if (strtotime($tmp_date) < strtotime($datefrom) || strtotime($tmp_date) > strtotime($dateend))
											continue;
										if ($small_date >= strtotime($tmp_date)){
											$small_date = strtotime($tmp_date);
											$hour_begin= explode("-",$row['hour']);
											$hour_begin = $hour_begin[1];
											$hour_begin = ($hour_begin == 2 ? 0 : $hour_begin - 2);
										}
										if ($big_date <= strtotime($tmp_date)) {
											$big_date = strtotime($tmp_date);
											$hour_end = explode("-",$row['hour']);
											$hour_end = $hour_end[1];
										}
										$find=1;
									}
									if ($find==0)
										continue;
									//根据课时范围到students中找各个学生的课时
									$table_name="students";
									$sql="SELECT * FROM {$table_name} where classid='$classid_tmp'";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());
									while ($row = mysql_fetch_assoc($result)) {
										if ($row['hour_end'] == 0)
											continue;
										$tmp_hour_begin=0;
										$tmp_hour_end=0;
										if ($row['hour_begin'] > $hour_end || $row['hour_end'] < $hour_begin)
											continue;
										// 获取每课时学费
										$charge_each_hour = $row['charge']/($row['hour_end']-$row['hour_begin']);
										
										if ($row['hour_begin'] <= $hour_begin)
											$tmp_hour_begin = $hour_begin;
										else 
											$tmp_hour_begin = $row['hour_begin'];
										//如果是计算收入则按照以上课时为准，如果是计算收取则终止课时按学员缴费截止课时为准
										if (strcmp($type, "income") == 0 ) {
											$tmp_hour_end=($row['hour_end'] >= $hour_end ? $hour_end : $row['hour_end']);
										} else if (strcmp($type, "all") == 0) {
											$tmp_hour_end = $row['hour_end'];
										}
										$earned=$charge_each_hour*($tmp_hour_end-$tmp_hour_begin);
										echo "<tr>";
										echo "<td>".$row['classid']."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['hour_begin']."-".$row['hour_end']."</td>";
										echo "<td>".$tmp_hour_begin."-".$tmp_hour_end."</td>";
										
										echo "<td>".$earned."</td>";
										echo "</tr>";
										$total_income +=$earned;
											
									}
								}
								
								echo "</table>";
								echo "<br/><br/>";
								
								echo "<h2 style='color:orange'>总收入：".$total_income."元.</h2><br/>";
								echo "<h2>收入还不错哦，继续加油！</h2>";
								echo "<br/><br/>";

							break;
							case "add":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$character=$_POST["character"];
								$year=$_POST["year"];
								$month=$_POST["month"];
								$day=$_POST["day"];
								$listen=$_POST["listen"];
								$password=$_POST["password"];
								$note=$_POST["note"];
								$record_date=$year."-".$month."-".$day;
								
								if (strcmp($engname,"def")==0 || strcmp($classid,"def")==0) {
									echo $engname;
									echo "<script>alert('请选择教师和班级！');window.history.go(-1);</script>";
									exit;
								}
								$conn=db_conn("daresay_db");
								
								//check the password
								$table_name="teachers";
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								$row = mysql_fetch_assoc($result);
								if ($password != $row['password']) {
									echo "<script>alert('口令不对');window.history.go(-1);</script>";
									exit;
								}
								//get the salary of teaher
								$chief_salary=$row['chief_salary'];
								$assist_salary=$row['assist_salary'];
								if (strcmp($character,"Chief")==0) 
									$salary=$chief_salary;
								else 
									$salary=$assist_salary;
								
								//get the students number of the class
								$table_name="students";
								$sql="SELECT * FROM {$table_name} WHERE classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								$stu_cnt = 0;
								while ($row = mysql_fetch_assoc($result)) {
									$stu_cnt++;
								}
								$salary = str_replace('N', $stu_cnt, $salary);
								eval("\$salary=$salary;");
								
								$table_name="teacher_salary";
								
								//check table exsit or not, if not create it
								$result =mysql_fetch_row(mysql_query("SHOW TABLES LIKE '{$table_name}' "));
								if(!$result){
									//表不存在，创建表
									$sql="CREATE TABLE {$table_name} (id INT(20) not null AUTO_INCREMENT,engname varchar(32),classid varchar(32),character1 varchar(32), date varchar(32), salary varchar(32), listen varchar(32), note varchar(1000),primary key(id))";
									$result=mysql_query($sql, $conn);
									if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
									}
								}
								mysql_query('BEGIN',$conn);
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname' and classid='$classid' and date='$record_date' FOR UPDATE";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo "您已经打过卡!请重新输入!";	
									mysql_close($conn);
									exit;

								}
								
								//是否两个人同时选择了主教或者助教？
								$sql="SELECT * FROM {$table_name} WHERE classid='$classid' and date='$record_date' and character1='$character'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo "<script>alert('{$row['engname']}已经打卡，且授课角色选择了{$character}!请确认您是否选错了授课角色！');window.history.go(-1);</script>";
									exit;

								}
								
								// insert into db
								$sql="INSERT INTO {$table_name} (engname, classid, character1, date, salary, listen, note)
								      VALUES ('$engname', '$classid', '$character', '$record_date', '$salary','$listen', '$note');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname' and classid='$classid' and date='$record_date'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								mysql_query('COMMIT',$conn);
								
								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td>教师</td>";
										echo "<td>".$row['engname']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>上课班级</td>";
										echo "<td>".$row['classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>授课角色</td>";
										echo "<td>".$row['character1']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>日期</td>";
										echo "<td>".$row['date']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>试听人数</td>";
										echo "<td>".$row['listen']."</td>";
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
								$engname=$_POST["engnamedel"];
								$classid=$_POST["classiddel"];
								$year=$_POST["yeardel"];
								$month=$_POST["monthdel"];
								$day=$_POST["daydel"];
								$password=$_POST["passworddel"];
								$date=$year."-".$month."-".$day;
								
								$conn=db_conn("daresay_db");
								$table_name="teachers";
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname'";
								$result=mysql_query($sql,$conn);
								if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
								}
								$row = mysql_fetch_assoc($result);
								if ($password != $row['password']) {
									$sql="SELECT * FROM {$table_name} WHERE engname='Edward'";
									$result=mysql_query($sql,$conn);
									if (!$result) {
										die("SQL: {$sql}<br>Error:".mysql_error());
									}
									$row = mysql_fetch_assoc($result);
									if ($password != $row['password']) {
									
										echo "<script>alert('口令不对');window.history.go(-1);</script>";
										exit;
									}
								}
								$table_name="teacher_salary";
								$sql="SELECT * FROM {$table_name} WHERE engname='$engname' and classid='$classid' and date='$date'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								$num=mysql_num_rows($result);
								if ($num==0) {
									echo "<script>alert('没有找到对应的信息！');window.history.go(-1);</script>";
									exit;
								}
								echo "<table>";
								echo "<tr>";
								echo "<td>英文名</td>";
								echo "<td>班级</td>";
								echo "<td>上课日期</td>";
								echo "<td>授课角色</td>";
								echo "<td>试听人数</td>";
								echo "<td>备注</td>";
								echo "</tr>";
								while ($row = mysql_fetch_assoc($result)) {
									echo "<tr>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['classid']."</td>";
										echo "<td>".$row['date']."</td>";
										echo "<td>".$row['character1']."</td>";
										echo "<td>".$row['listen']."</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								}
								
								$sql="DELETE FROM {$table_name} WHERE engname='$engname' and classid='$classid' and date='$date'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								mysql_close($conn);

								echo "</table>";
								echo "<br/><br/>";
								echo "以上打卡信息已经成功删除!";
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
						include "income_right.php";	
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
