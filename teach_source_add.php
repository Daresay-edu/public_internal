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
<div id="header">
	<div class="shell">
		<!-- Logo + Top Nav -->
		<div id="top">
		<div id="top-dx">
		<img src="images/dx.png" height="70px" width="150px"/>
		</div>
			<div id="top-navigation">
				Welcome <a href="#"><strong>Administrator</strong></a>
				<span>|</span>
				<a href="#">Help</a>
				<span>|</span>
				<a href="#">Profile Settings</a>
				<span>|</span>
				<a href="#">Log out</a>
			</div>
		</div>
		<!-- End Logo + Top Nav -->
		
		<!-- Main Nav -->
		<div id="navigation">
			<?php include("menu.php"); ?>
		</div>
		<!-- End Main Nav -->
	</div>
</div>
<!-- End Header -->

<!-- Container -->
<div id="container">
	<div class="shell">
		
		<!-- Small Nav -->
		<div class="small-nav">
			<a href="#">添加教学资源</a>
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
					<form action="source_opt_action.php?action=add" method="post">
					   <table border="0" align="center" width="800">
					   	<tr>
							<td align="center" >阶段:</td>
							<td><select name="level">
							    <option value='K1'>K1</option>;
							    <option value='K2'>K2</option>;
							    </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >单元:</td>
							<td><select name="unit">
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
							<td align="center" >资源类型:</td>
							<td><select name="title">
							    <option value='video'>Video</option>;
							    <option value='game'>Game</option>;
							    </select>
							</td>
						</tr>
					   	<tr>
							<td align="center" >标题:</td>
							<td><input type="text" name="title"/></td>
						</tr>
					   	<tr>
							<td align="center" >图片文件:</td>
							<td><input type="file" name="pic"/></td>
						</tr>
					   	<tr>
							<td align="center" >资源文件:</td>
							<td><input type="file" name="source"/></td>
						</tr>
					   	<tr>
							<td align="center" >说明:</td>
							<td><input type="text" name="note"/></td>
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
					<?php include("teach_right.php");?>
					
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
<div id="footer">
	<div class="shell">
		<span class="left">&copy; 2015 - Daresay</span>
		<span class="right">
			Design by Edward
		</span>
	</div>
</div>
<!-- End Footer -->
	
</body>
</html>
