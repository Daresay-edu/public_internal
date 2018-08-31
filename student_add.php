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
	<script>
function CheckForm()
{

		var name=document.getElementById("name").value;
		var engname=document.getElementById("engname").value;
		var age=document.getElementById("age").value;
		var charge=document.getElementById("charge").value;
		var school=document.getElementById("school").value;
		if (name.length == 0 || 
		    engname.length == 0 || 
			age.length == 0 || 
			charge.length == 0 ||
			school.length == 0) {
			alert("请输入中文名、英文名、年龄、学校、缴费金额，若没有英文名请输入中文名全拼！");
			return false;
		}
        var phone=document.getElementById("phone").value;
		if (phone.length != 11) {
			alert("为了方便同家长联系，请输入11位电话号码！");
			return false;
		}
		var classid=document.getElementById("classid").value;
		if (classid == "def") {
			alert("请选择班级！");
			return false;
		}
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
			<a href="#">添加学生</a>
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
					<form action="students_manage.php?action=add" method="post" onsubmit="return CheckForm()">
					   <table border="0" align="center" width="800">
					   	<tr>
							<td align="center" >姓名:</td>
							<td><input class='field' type="text" name="name" id="name"/></td>
						</tr>
					   	<tr>
							<td align="center" >英文名:</td>
							<td><input class='field' type="text" name="engname" id="engname"/></td>
						</tr>
					   	<tr>
							<td align="center" >年龄:</td>
							<td><select class='field' name="age" id="age">
							    <?php
									$i=0;
									$year=2;
									for ($i;$i<19;$i++) {
									echo "<option value='{$year}'>{$year}</option>";
									$year++;
								}
								?>
							   </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >性别:</td>
							<td><select class='field' name="sex">
							    <option value="男">男</option>;
							    <option value="女">女</option>;
							   </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >电话:</td>
							<td><input class='field' type="text" name="phone" id="phone"/></td>
						</tr>
					   	<tr>
							<td align="center" >所在学校:</td>
							<td><input class='field' type="text" name="school" id="school"/></td>
						</tr>
					   	<tr>
							<td align="center" >班级</td>
							<td><select class='field' name="classid" id="classid">
								<option value="def">请选择</option>
							<?php
								
										require_once("database_opt/public.php");
										$classes = get_all_class();
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
						<td align="center" >缴费日期:</td>
						<td><select class='field' name="year">
							<?php
								$today=date("Y-n-j");								
								$arr=explode("-",$today);
								$year=$arr[0];
								$i=0;
								for ($i;$i<8;$i++) {
									echo "<option value='{$year}'>{$year}</option>";
									$year++;
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
							<td align="center" >缴费金额:</td>
							<td><input class='field' type="text" name="charge" id="charge"/></td>
						</tr>
					   	<tr>
							<td align="center" >课时:</td>
							<td><select class='field' name='hour_begin'/>;
							<?php
								$fir_tmp=0;
								$i=0;
								for ($i;$i<97;$i++) {
									echo "<option value='{$fir_tmp}'>{$fir_tmp}</option>";
									$fir_tmp=$fir_tmp+2;
								}
							
							?>
							</select>
							<?php
								echo "至";
							?>
							<select class='field' name='hour_end'/>;
							<?php
								$fir_tmp=0;
								$i=0;
								for ($i;$i<97;$i++) {
									if ($fir_tmp==48) 
										echo "<option value='{$fir_tmp}' selected='selectd'>{$fir_tmp}</option>";
									else
										echo "<option value='{$fir_tmp}'>{$fir_tmp}</option>";
									$fir_tmp=$fir_tmp+2;
								}
							?>
							</select>
							</td>

						</tr>
					   	<tr>
							<td align="center" >备注:</td>
							<td><input class='field' type="text" name="note"/></td>
						</tr>
						<tr>
							<td align="right"><input class='field'  style="background-color:#F9EBAE" type="submit" name="add" value="添加"/></td>
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
					<?php include("students_right.php");?>
					
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
