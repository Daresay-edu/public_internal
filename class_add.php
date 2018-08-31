<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DareSay Education</title>
	<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/daresay.js"></script>
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
			<a href="#">添加班级</a>
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
					<form action="class_manage.php?action=add" method="post">
					   <table border="0" align="center" width="800">
					   	<tr>
							<td align="center" >班级</td>
							<td><input class='field' type="text" name="classid" value="K"/></td>
						</tr>
						
							
						<tr>
							<td align="center" >开班时间:</td>
							<td><select class='year' name="year">
							<?php
								$today=date("Y-n-j");								
								$arr=explode("-",$today);
								$year=$arr[0];
								$i=0;
								$tmp_year="2014";
								for ($i;$i<8;$i++) {
									if ($year == $tmp_year) 
										echo "<option value='{$tmp_year}' selected='selected'>{$tmp_year}</option>";
									else 
										echo "<option value='{$tmp_year}'>{$tmp_year}</option>";
									$tmp_year++;
								}
							?>
								</select>
								<select class='month' name="month">
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
								<select class='day' name="day">
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
							<td align="center">上课时间一:</td>
							<td><select class='field' name="fir_day" id="fir_day">
									<option value="周一">周一</option>
									<option value="周二">周二</option>
									<option value="周三">周三</option>
									<option value="周四">周四</option>
									<option value="周五">周五</option>
									<option value="周六">周六</option>
									<option value="周日">周日</option>
							    </select>
							
								<select class='field' name="fir_day_hour" id="fir_day_hour">
								<?php
									$i = 1;
									for($i=1;$i<=24;$i++) {
										if ($i < 10)
											$i="0".$i;
										echo "<option value='$i'>".$i."点</option>";
										
									}
								?>
									
							    </select>
								<select class='field' name="fir_day_minute" id="fir_day_minute">
								<?php
									$i = 0;
									for($i;$i<=60;$i++) {
										if ($i < 10)
											$i="0".$i;
										echo "<option value='$i'>".$i."分</option>";
										
									}
								?>
									
							    </select>
							</td>
						</tr>
						<tr>
							<td align="center">上课时间二:</td>
							<td><select class='field' name="sec_day" id="sec_day">
									<option value="周一">周一</option>
									<option value="周二">周二</option>
									<option value="周三">周三</option>
									<option value="周四">周四</option>
									<option value="周五">周五</option>
									<option value="周六">周六</option>
									<option value="周日">周日</option>
							    </select>
							
								<select class='field' name="sec_day_hour" id="sec_day_hour">
								<?php
									$i = 1;
									for($i=1;$i<=24;$i++) {
										if ($i < 10)
											$i="0".$i;
										echo "<option value='$i'>".$i."点</option>";
										
									}
								?>
									
							    </select>
								<select class='field' name="sec_day_minute" id="sec_day_minute">
								<?php
									$i = 0;
									for($i;$i<=60;$i++) {
										if ($i < 10)
											$i="0".$i;
										echo "<option value='$i'>".$i."分</option>";
										
									}
								?>
									
							    </select>
							</td>
						</tr>
						<tr>
							<td align="center" >授课教师:</td>
							<td><input class='field' type="text" name="teachers"/></td>
						</tr>
						<tr>
							<td align="center" >班级邮箱:</td>
							<td><input class='field' type="text" name="mail"/></td>
						</tr>
						<tr>
							<td align="center" >班级资源位置:</td>
							<td><input class='field' type="text" name="source1"/></td>
						</tr>
						
						<tr>
							<td align="center" >课后资源位置:</td>
							<td><input class='field' type="text" name="source2"/></td>
						</tr>
						
					   	<tr>
							<td align="center" >备注:</td>
							<td><input class='field' type="text" name="note"/></td>
						</tr>
						<tr>
							<td align="right"><input class='submit' type="submit" name="add" value="添加"/></td>
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
					<?php include("class_right.php");?>
					
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
