	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DareSay Education</title>
	<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/datedropper.css">
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/flowplayer-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.pack.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/fancyplayer.js"></script>
	
    <script type="text/javascript">

	     var videopath = "../teach_source/";
	     var swfplayer = videopath + "player/flowplayer-3.1.1.swf";

    </script>
	<script>
		function goo(obj)
	{
		obj.disabled =true;
		document.getElementById("form1").submit();
	}
	</script>
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
			<a href="#">教师打卡</a>
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
					<form action="teacher_salary_manage.php?action=add" method="post" id="form1">
					   <table border="0" align="center" width="800">
					   	<tr>
							<td align="center" >教师:</td>
							<td><select class='field' name='engname' id="engname">
								<option value="def">请选择</option>
								<?php
									require_once("database_opt/db_opt.php");
									$conn=db_conn("daresay_db");
									$sql="SELECT * FROM teachers";
									$result=mysql_query($sql,$conn);
									if (!$result)
										die("SQL: {$sql}<br>Error:".mysql_error());			
										while ($row = mysql_fetch_assoc($result)) {
											echo "<option value='{$row['engname']}'>{$row['engname']}</option>";
										}	
								?>
								</select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >上课班级:</td>
							<td><select class='field' name='classid' id="classid" onchange="getClassnum1(this.value)">
									<option value="def">请选择</option>
									<?php
								
										require_once("database_opt/public.php");
										$classes = get_running_class();
										echo $classes;
										for ($i=0;$i<count($classes);$i++) {
								            $tmp = $classes[$i];
											echo "<option value='$tmp'>".$tmp."</option>";	
										}					
										
							
									?>
							    </select>
						
							</td>
						</tr>
						<tr>
							<td align="center">课时:</td>
							<td><select class='field' name="begin_class" id="begin_class">
									<option value="null">null</option>
							    </select>
							</td>
						</tr>
						<tr>
							<td align="center" >授课角色:</td>
							<td><select class='field' name='character' id="character">
							    <option value="Chief">主教</option>;
							    <option value="Assistance">助教</option>;
							   </select>
							</td>
						</tr>
						<tr>
							<td align="center" >上课时间:</td>
							<td><select class='field' name="year">
							<?php
								$today=date("Y-n-j");								
								$arr=explode("-",$today);
								$year=$arr[0];
								$tmp_year="2014";
								$i=0;
								for ($i;$i<16;$i++) {
									if ($tmp_year==$year) {
										echo "<option value='{$tmp_year}' selected='selected'>{$tmp_year}</option>";
									}	else {
										echo "<option value='{$tmp_year}'>{$tmp_year}</option>";
									}
									$tmp_year++;
								}
							?>
								</select>
								<select class='field' name="month">
								<?php
								$today=date("Y-n-j");								
								$arr=explode("-",$today);
								$month=$arr[1];
								$i=1;
								for ($i;$i<13;$i++) {
									if ($i == $month)
										echo "<option value='{$i}' selected='selected'>{$i}</option>";
									else
										echo "<option value='{$i}'>{$i}</option>";
								}
								?>
								</select>
								<select class='field' name="day">
								<?php
								$today=date("Y-m-j");								
								$arr=explode("-",$today);
								$day=$arr[2];
								$i=1;
								for ($i;$i<32;$i++) {
									if ($i == $day)
										echo "<option value='{$i}' selected='selected'>{$i}</option>";
									else
										echo "<option value='{$i}'>{$i}</option>";
								}
								?>
								</select>
						  </td>
						</tr>
						<tr>
							<td align="center" >试听(人数):</td>
							<td><select class='field' name="listen">
								<?php
								$i=0;
								for ($i;$i<11;$i++) {
										echo "<option value='{$i}'>{$i}</option>";
								}
								?>
							</select>
							</td>
						</tr>
						<tr>
							<td align="center" >口令:</td>
							<td><input class='field' type="password" name="password"/></td>
						</tr>
					   	<tr>
							<td align="center" >备注:</td>
							<td><input class='field' type="text" name="note"/></td>
						</tr>
						<tr>
							<td align="right"><input class='field'  style="background-color:#F9EBAE" type="button" name="add" value="打卡" onclick="goo(this);"/></td>
						</tr>

                          
                    			   </table>
					   </form>
                     
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
					<?php include("teacher_salary_right.php");?>
					
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
