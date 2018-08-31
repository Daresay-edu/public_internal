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
			<a href="#">缺勤管理</a>
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
					require_once("dollar.php");
					require_once("phpmail/sendmail_interface.php");
					$db_table="absent";
						switch($_GET["action"]) {
							case "display":
								$classid=$_POST["classid"];
								$engname=$_POST["engname"];
								$conn=db_conn("daresay_db");
								if ($engname=="All")
									$sql="SELECT * FROM $db_table WHERE classid='$classid' order by id desc";
								else 
									$sql="SELECT * FROM $db_table WHERE classid='$classid' and engname='$engname' order by id desc";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								echo "<table>";
								echo "<tr>";
								echo "<td>ID</td>";
								echo "<td>英文名</td>";
								echo "<td>班级</td>";
								echo "<td>缺勤课时</td>";
								echo "<td>缺勤日期</td>";
								echo "<td>补课班级</td>";
								echo "<td>已补完</td>";
								echo "<td>备注</td>";
								echo "</tr>";
								$i=1;
								while ($row = mysql_fetch_assoc($result)) {
									echo "<tr>";
										echo "<td>".$i++."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['classid']."</td>";
										echo "<td>".$row['ab_hour']."</td>";
										echo "<td>".$row['ab_date']."</td>";
										echo "<td>".$row['in_classid']."</td>";
										echo "<td>".$row['finish']."</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								}
								echo "</table>";
								echo "<br/><br/>";

							break;
							case "add":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$ab_hour=$_POST["begin_class"];
								
								$ab_year=$_POST["ab_year"];
								$ab_month=$_POST["ab_month"];
								$ab_day=$_POST["ab_day"];
								$inclassid=$_POST["inclassid"];
								$finish=$_POST["stat"];
								$note=$_POST["note"];								
								$ab_date=$ab_year."-".$ab_month."-".$ab_day;
								$conn=db_conn("daresay_db");

								//check if have the student in this class 
								$sql="SELECT * FROM students WHERE engname='$engname' 
									and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if (!$row) {
									echo $classid."班不存在学生".$engname."!请重新输入!";	
									mysql_close($conn);
									exit;

								}

								//check if already have the same record
								$sql="SELECT * FROM $db_table WHERE engname='$engname' 
									and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo "记录已经存在，请重新输入!";	
									mysql_close($conn);
									exit;

								}
								/*
								//include("attendance/attendance_array.php");
								//$cb=substr($classid,0,2);
								//$class_content=$cb."_class_content";
								//list($tmp_fir,$tmp_sec) = explode("-",$ab_hour);
								//foreach(${$class_content} as $K=>$V) {
									//list($tmp_a,$tmp_b) = explode("-",$K);
									//if ($tmp_a <= $tmp_fir && $tmp_sec <= $tmp_b) {
										//if (strncmp($V,"Math",4) == 0 || strncmp($V,"Science",7)==0) {
											//$tmp=$V;
												//break;
										}

										$l_num=($tmp_fir-$tmp_a)/2+1;
										$tmp=$V." Lesson ".$l_num;
										break;
									} 
								}
								
								$note=$tmp." ".$note;
								*/
								// insert into db
								$sql="INSERT INTO $db_table(engname, classid, ab_hour, ab_date, in_classid, finish, note)
								      VALUES ('$engname', '$classid', '$ab_hour', '$ab_date', '$inclassid', '$finish','$note');";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM $db_table WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td>英文名</td>";
										echo "<td>".$row['engname']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>班级</td>";
										echo "<td>".$row['classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>缺勤课时</td>";
										echo "<td>".$row['ab_hour']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>缺勤日期</td>";
										echo "<td>".$row['ab_date']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>补课班级</td>";
										echo "<td>".$row['in_classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>已补完</td>";
										echo "<td>".$row['finish']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								//add this absent to kxxx_class_info_record DB table
								$table_name="class_info_record";
								$class_info=$ab_hour;
								$sql="SELECT * FROM {$table_name} WHERE hour='$class_info' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$row = mysql_fetch_assoc($result);
								$absent_new=$row['absent']." ".$engname;
								$sql="UPDATE {$table_name} SET absent='$absent_new' WHERE hour='$class_info' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								mysql_close($conn);
								absent_student_reduce_dollar($classid, $engname, $ab_hour);
								//send mail to 15302130568@163.com
								//$title="ADD ABSENT: ".$classid." ".$engname." absent hour ".$ab_hour;
								//send_mail("18612187698@163.com",$title,$title);
										
							break;
						
							case "delete":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$ab_hour=$_POST["ab_hour"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM $db_table WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if (!$row) {
									echo "记录不存在!请重新输入!";
									mysql_close($conn);
									exit;

								}

								echo "<table>";
								echo "<tr>";
								echo "<td>英文姓名</td>";
								echo "<td>班级</td>";
								echo "<td>缺勤课时</td>";
								echo "<td>缺勤时间</td>";
								echo "<td>补课班级</td>";
								echo "<td>已补完</td>";
								echo "<td>备注</td>";
								echo "</tr>";

								echo "<tr>";
								echo "<td>".$row['engname']."</td>";
								echo "<td>".$row['classid']."</td>";
								echo "<td>".$row['ab_hour']."</td>";
								echo "<td>".$row['ab_date']."</td>";
								echo "<td>".$row['in_classid']."</td>";
								echo "<td>".$row['finish']."</td>";
								echo "<td>".$row['note']."</td>";
								echo "</tr>";

								$sql="DELETE FROM $db_table WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
								mysql_close($conn);
								//send mail to 18612187698@163
								//$title="DEL ABSENT: ".$classid." ".$engname." absent hour ".$ab_hour;
								//send_mail("18612187698@163.com",$title,$title);
								
								echo "</table>";
								echo "<br/><br/>";
								echo "以上学生缺勤信息已经成功删除!";
								echo "<br/><br/>";
							break;
							case "modify":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$ab_hour=$_POST["ab_hour"];
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM $db_table WHERE engname='$engname' 
									and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								if ($row = mysql_fetch_assoc($result)) {
									$engname=$row['engname'];
									$classid=$row['classid'];
									$ab_hour=$row['ab_hour'];
									$ab_date=$row['ab_date'];
									$in_classid=$row['in_classid'];
									$finish=$row['finish'];
									$note=$row['note'];
								} else {
									echo "No record!";
									exit;
								}
								list($fir_hour,$sec_hour)=explode("-",$ab_hour);


								echo "<form action='absent_manage.php?action=modify_do' method='post'>
								       <table border='0' align='center' width='800'>
									<tr>
									<td align='center' >英文名:</td>
									<td><input class='field' type='text' name='engname' value='$engname'/></td>
									</tr>
									<tr>
									<td align='center' >班级</td>
									<td><select class='field' name='classid'>";
									
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
									<td align='center' >缺勤课时:</td>
									<td><select class='field' name='fir_class'/>";
										$fir_tmp=1;
										$i=0;
										for ($i;$i<96;$i++) {
											if ($fir_hour == $fir_tmp)
												echo "<option value='{$fir_tmp}' selected='selected'>{$fir_tmp}</option>";
											else
												echo "<option value='{$fir_tmp}'>{$fir_tmp}</option>";
											$fir_tmp=$fir_tmp+2;
										}


										echo	"</select>";
										echo "至";
										echo "<select class='field' name='sec_class'>";
										$sec_tmp=2;
										$i=0;
										for ($i;$i<96;$i++) {
											if ($sec_hour == $sec_tmp)
												echo "<option value='{$sec_tmp}' selected='selected'>{$sec_tmp}</option>";
											else
												echo "<option value='{$sec_tmp}'>{$sec_tmp}</option>";
											$sec_tmp=$sec_tmp+2;
										}
										echo "</select>";

									echo "</td>
									</tr>

									<tr>
									<td align='center' >缺勤日期:</td>
									<td><input class='field' type='text' name='ab_date' value='$ab_date'/></td>
									</tr>
									<tr>
									<td align='center' >已补完:</td>
									<td><select class='field' name='finish'/>";
										echo "<option value='$finish' selected='selected'>$finish</option>";
										if ($finish=="no")
											echo "<option value='yes'>yes</option>";
										else 
											echo "<option value='no'>no</option>";
									echo "</td>
									</tr>

									<tr>
									<td align='center' >补课班级</td>
									<td><select class='field' name='in_classid'>";
										$sql="SELECT * FROM class";							
										$result=mysql_query($sql,$conn);
										if (!$result)
											die("SQL: {$sql}<br>Error:".mysql_error());	
										while ($row = mysql_fetch_assoc($result)) {
											$tmp=$row['classid'];
											if (strcmp($tmp, $in_classid)==0)
													echo "<option value='{$in_classid}' 
														selected='selected'>{$in_classid}</option>";
											else 
												echo "<option value='$tmp'>".$tmp."</option>";		
										}			
									echo "</td>
										</tr>
										<tr>
										<td align='center' >备注:</td>
										<td><input class='field' type='text' name='note' value='$note'/></td>
										</tr>
										<tr>
										<td align='right'><input type='submit' name='add' value='修改'/></td>
										</tr>";
									echo "<tr>
										<td>
										<input type='hidden' name='ab_hour_hide' value='$ab_hour' />
										</td>
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
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$fir_hour=$_POST["fir_class"];
								$sec_hour=$_POST["sec_class"];
								$ab_date=$_POST["ab_date"];
								$in_classid=$_POST["in_classid"];
								$finish=$_POST["finish"];
								$note=$_POST["note"];
								$ab_hour_hide=$_POST["ab_hour_hide"];
								$engname_hide=$_POST["engname_hide"];
								$classid_hide=$_POST["classid_hide"];

								//the fir_class must smaller than sec_class
								if ($fir_hour >= $sec_hour) {
									echo "起始课时(".$fir_hour.")不能大于终止课时(".$sec_hour.")";
									exit;
								}

								$ab_hour=$fir_hour."-".$sec_hour;

								//check if have the same engname in db
								$conn=db_conn("daresay_db");

								//check if have the student in this class 
								$sql="SELECT * FROM students WHERE engname='$engname' 
									and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if (!$row) {
									echo $classid."班不存在学生".$engname."!请重新输入!";	
									mysql_close($conn);
									exit;

								}


								$sql="DELETE FROM $db_table WHERE engname='$engname_hide' and classid='$classid_hide' 
									and ab_hour='$ab_hour_hide'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						


								$sql="SELECT * FROM $db_table WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo "记录已经存在，请重新输入!";	
									mysql_close($conn);
									exit;

								}
								// insert into db
								$sql="INSERT INTO $db_table(engname, classid, ab_hour, ab_date, in_classid, finish, note)
								      VALUES ('$engname', '$classid', '$ab_hour', '$ab_date', '$in_classid', '$finish','$note');";
									  
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());
								$sql="SELECT * FROM $db_table WHERE engname='$engname' and classid='$classid' and ab_hour='$ab_hour'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								echo "<table border='0' width=500px  align='center'>";
								$row = mysql_fetch_assoc($result);
									echo "<tr>";
										echo "<td>英文名</td>";
										echo "<td>".$row['engname']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>班级</td>";
										echo "<td>".$row['classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>缺勤课时</td>";
										echo "<td>".$row['ab_hour']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>缺勤日期</td>";
										echo "<td>".$row['ab_date']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>补课班级</td>";
										echo "<td>".$row['in_classid']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>已补完</td>";
										echo "<td>".$row['finish']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>备注</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
								echo "</table>";
								echo '<br/>';
								echo "Success!";
								mysql_close($conn);
								
								//send mail to 15302130568@163
								//$title="MODIFY ABSENT: ".$classid." ".$engname." absent hour ".$fir_hour."-".$sec_hour;
								//$content="Modify the message to ".$classid." ".$engname." absent hour ".$ab_hour." on ".$ab_date." makeup class is ".$in_classid." makeup state is ".$finish." note is ".$note;
								//send_mail("18612187698@163.com",$title,$content);
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
						include "absent_right.php";	
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
