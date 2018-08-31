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
				<table border="0" width="700">
					<?php
					 require_once("database_opt/db_opt.php");
					 $conn=db_conn("daresay_db");
					 $table_name="absent";
					 //check table exsit or not, if not create it
					 $result =mysql_fetch_row(mysql_query("SHOW TABLES LIKE 'absent' "));
					if(!$result){
						//表不存在，创建表
						$sql="CREATE TABLE {$table_name} (id INT(20) not null AUTO_INCREMENT,classid varchar(32),engname varchar(32),ab_hour varchar(32),ab_date varchar(32),in_classid varchar(32),finish varchar(10),note varchar(1000),primary key(id))";
						$result=mysql_query($sql, $conn);
						if (!$result) {
							die("SQL: {$sql}<br>Error:".mysql_error());
						}
					}
					$sql="SELECT * FROM ".$table_name." order by id desc";
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
