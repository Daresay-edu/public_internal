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
			<a href="#">出勤表管理</a>
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
					<form action="attendance/attendance_action.php?action=add" method="post">
					   <table border="0" width="700">
					   	<tr>
							<td align="center" >班级:</td>
							<td><select name="classid">
								<?php
									include("attendance/attendance_array.php");
									foreach($class_list as $K=>$V) {
										echo "<option value='{$V}'>{$V}</option>";
									}
								?>
							    </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >起始日期:</td>
							<td><select name="begin_year">
								<?php
									$year=2015;
									$i=0;
									for ($i;$i<8;$i++) {
										echo "<option value='{$year}'>{$year}</option>";
										$year++;
									}
								?>
							    </select>
							<select name="begin_month">
								<?php
									$month=1;
									$i=0;
									for ($i;$i<12;$i++) {
										echo "<option value='{$month}'>{$month}</option>";
										$month++;
									}
								?>
							    </select>
							<select name="begin_day">
								<?php
									$day=1;
									$i=0;
									for ($i;$i<31;$i++) {
										echo "<option value='{$day}'>{$day}</option>";
										$day++;
									}
								?>
							    </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >起始课时:</td>
							<td><select name="begin_class">
								<?php
									$class=1;
									$i=0;
									for ($i;$i<96;$i++) {
										$class1=$class+1;
										echo "<option value='{$class}-{$class1}'>{$class}-{$class1}</option>";
										$class=$class+2;
									}
								?>
							    </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >天数:</td>
							<td><input type="text" name="days"/></td>
						</tr>
					   	<tr>
							<td align="center" >出勤表所占月份:</td>
							<td><input type="text" name="months"/></td>
						</tr>
					   	<tr>
							<td align="right"><input type="submit" name="提交"/></td>
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
					
					<div class="box-content">
						<a href="#" class="add-button"><span>Add new Article</span></a>
						<div class="cl">&nbsp;</div>
						
						<p class="select-all"><input type="checkbox" class="checkbox" /><label>select all</label></p>
						<p><a href="#">Delete Selected</a></p>
						
						<!-- Sort -->
						<div class="sort">
							<label>Sort by</label>
							<select class="field">
								<option value="">Title</option>
							</select>
							<select class="field">
								<option value="">Date</option>
							</select>
							<select class="field">
								<option value="">Author</option>
							</select>
						</div>
						<!-- End Sort -->
						
					</div>
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
