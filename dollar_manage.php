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
			<a href="#">Dollar记录</a>
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
					$db_table="dollar";
						switch($_GET["action"]) {
							case "display":
								$classid=$_POST["classid"];
								$engname=$_POST["engname"];
								$yearfrom=$_POST["yearfrom"];
								$monthfrom=$_POST["monthfrom"];
								$dayfrom=$_POST["dayfrom"];
								$yearend=$_POST["yearto"];
								$monthend=$_POST["monthto"];
								$dayend=$_POST["dayto"];
								
								$datefrom=$yearfrom."-".$monthfrom."-".$dayfrom;
								$dateend=$yearend."-".$monthend."-".$dayend;
								
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM $db_table WHERE classid='$classid' and engname='$engname' order by id desc";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());	
                                echo "<form action='dollar_manage.php?action=take_out' method='post'>";								
								echo "<table>";
								echo "<tr>";
								echo "<td>ID</td>";
								echo "<td>班级</td>";
								echo "<td>英文名</td>";
								echo "<td>课时</td>";
								echo "<td>日期</td>";
								echo "<td>Dollar</td>";
								echo "<td>备注</td>";
								echo "</tr>";
								$i=1;
								$j=0;
								while ($row = mysql_fetch_assoc($result)) {
									$tmp_date = $row['date'];
									if (strtotime($tmp_date) < strtotime($datefrom) || strtotime($tmp_date) > strtotime($dateend))
										continue;
									echo "<tr>";
										echo "<td>".$i++."</td>";
										echo "<td>".$row['classid']."</td>";
										echo "<td>".$row['engname']."</td>";
										echo "<td>".$row['hour']."</td>";
										echo "<td>".$row['date']."</td>";
										echo "<td>".$row['dollar_num']."</td>";
										echo "<td>".$row['note']."</td>";
									echo "</tr>";
									$j+=$row['dollar_num'];
								}
								if ($j-8 < 0) {
									$j = 3;
								} else {
									$j = $j-8+3;
					
								}
								echo "<tr>";
								//echo "<th  colspan='7'>本次发$j$</th>";
								
								echo "</tr>";
								echo "<tr style=\"display:none\">
											<td>
											<input type='hidden' name='engname_hide' value='$engname' />
											</td>
											<td>
											<input type='hidden' name='classid_hide' value='$classid' />
											</td>
											<td>
											<input type='hidden' name='datefrom' value='$datefrom' />
											</td>
											<td>
											<input type='hidden' name='dateend' value='$dateend' />
											</td>
											</tr>";
	
								echo "<br/><br/><tr style='border:0'><td><B>本次发$j$</B></td><td><input class='field'  style=\"background-color:#F9EBAE\" type='submit' value='取出'/></td></tr>";
								echo "</table></form>";
								echo "<br/><br/>";

							break;
							case "add":
								$engname=$_POST["engname"];
								$classid=$_POST["classid"];
								$hour = $_POST["begin_class"];
								$year=$_POST["year"];
								$month=$_POST["month"];
								$day=$_POST["day"];
								$dollar_num=$_POST["dollar_num"];
								$note=$_POST["note"];								
								$record_date=$year."-".$month."-".$day;
								$conn=db_conn("daresay_db");
							    
                                //update first
                                $sql = "SELECT * FROM dollar WHERE classid='$classid' and engname='$engname' and hour='$hour'";
		                        $result=mysql_query($sql,$conn);
	                            if (!$result)
		                            die("SQL: {$sql}<br>Error:".mysql_error());
		                        $row = mysql_fetch_assoc($result);
	                            if ($row) {
									$dollar = $dollar_num + $row['dollar_num'];
                                    $sql="UPDATE dollar SET dollar_num='$dollar' WHERE classid='$classid' AND engname='$engname' AND hour='$hour'";
									$result=mysql_query($sql,$conn);
								    if (!$result)
									    die("SQL: {$sql}<br>Error:".mysql_error());
		                        } else {								
								    // insert into db
								    $sql="INSERT INTO $db_table(engname, classid, hour, date, dollar_num, note)
								      VALUES ('$engname', '$classid', '$hour', '$record_date', '$dollar_num','$note');";
								    $result=mysql_query($sql,$conn);
								    if (!$result)
									    die("SQL: {$sql}<br>Error:".mysql_error());
								   					
                                }  
								$sql="SELECT * FROM $db_table WHERE engname='$engname' and classid='$classid' and hour='$hour'";
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
										echo "<td>课时</td>";
										echo "<td>".$row['hour']."</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td>Dollar</td>";
										echo "<td>".$row['dollar_num']."</td>";
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
						
							case "take_out":
								$engname=$_POST["engname_hide"];
								$classid=$_POST["classid_hide"];
								$datefrom=$_POST["datefrom"];
								$dateend=$_POST["dateend"];
								print $engname;
								print $classid;
								print $datefrom;
								print $dateend;
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM $db_table WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						
                                $date_arr = array();
	                            $i = 0;
                                while ($row = mysql_fetch_assoc($result)) {
									$tmp_date = $row['date'];
									if (strtotime($tmp_date) < strtotime($datefrom) || strtotime($tmp_date) > strtotime($dateend))
										continue;
									$date_arr[$i] = $row['date'];
		                            $i++;
								}
						        print $tmp_date;
								for ($i=0;$i<count($date_arr);$i++){
		                            $tmp_date = $date_arr[$i];
									print $tmp_date;
		                            $sql="DELETE FROM $db_table WHERE engname='$engname' and classid='$classid' and date='$tmp_date'";
									$result=mysql_query($sql,$conn);
								    if (!$result)
									    die("SQL: {$sql}<br>Error:".mysql_error());
	                            }
								echo "Dollar信息已经成功删除!";
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
						include "dollar_right.php";	
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
