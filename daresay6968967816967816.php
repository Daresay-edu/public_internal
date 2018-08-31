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
			<?php include("menu_manage_hide.php"); ?>
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
			<a href="#">学生信息</a>
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
				<table border="0" width="700">
				<?php
				 require_once("database_opt/db_opt.php");
				 $conn=db_conn("daresay_db");
				$sql="SELECT * FROM students";
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
	echo "<td>缴费至课时</td>";
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
		echo "<td>".$row['hour_begin']."-".$row['hour_end']."</td>";
		echo "</tr>";
	}
echo "</table>";
echo "<br/><br/>";

?>
                    			   </table>

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
