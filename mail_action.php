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
table, tr, td
{
font-size: 12px;
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
			<a href="#">备课</a>
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
                      		
					<?php
					require_once("database_opt/db_opt.php");
					switch($_GET["action"]) {
						case "see":
							$classid = $_POST["classid"];
							$class_num = $_POST["begin_class"];
							$note = $_POST["note"];
                            
							if (strcmp($classid, 'def')==0 || strcmp($class_num, 'null') == 0) {
								echo "<script>alert('请指定班级和课时！');window.history.go(-1);</script>";
								exit;
							}
							
							$conn=db_conn("daresay_db");
							$table_name="class";
							$sql="SELECT * FROM {$table_name} WHERE classid='$classid'";
							$result=mysql_query($sql,$conn);
							if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());	
							$row = mysql_fetch_assoc($result);
							
							$mail=$row['mail_address'];
							$class_source=$row['source1'];
							$public_source=$row['source2'];
							
							$mailcontent = "Dear Parents:"."<br>"."<br>";

							/* get content */

							$cb = substr($classid,0,2);
							$filename = $cb."_class_content.txt";
							$filename = "class_content/".$filename;
							$myfile = fopen("$filename", "r") or die("Unable to open file!");
							//echo fread($myfile,filesize("$filename"));
							$find_begin=0;
							while(!feof($myfile)) {
								$read_line = fgets($myfile);
								if ($class_num == "1-192") {
									$mailcontent .=  $read_line."<br>";
								} else {
									if ($find_begin == 0 && strncmp("$read_line", "$class_num", strlen("$class_num"))==0) {
										$find_begin = 1;

									}
									if ($find_begin == 1) {
										if (strstr($read_line,"@@@")) {
											break;
										}
										$mailcontent .=  $read_line."<br>";
									}
								}

							}
							fclose($myfile);
							
							//video and pic path on 360yun
							$mailcontent .= "<br>"."班级视频及照片地址: ".$class_source."<br>"."课后学习资源地址: ".$public_source."<br>";

							$mailcontent.="<br>"."<br>"."Thank you for your understanding and support!"."<br>"."Daresay Education"."<br>";
		
							echo "<form action='phpmail/sendmail.php?action=send' method='post'>";
							echo "<table>";
							echo "<tr>";
								echo "<td>";
								echo "上课班级: ".$classid.'<br/>';
								echo "课时: ".$class_num.'<br/>';
								echo "课程内容如下: ".'<br/><br/>';
								echo $mailcontent;
							//echo iconv('GB2312', 'UTF-8', $mailcontent);
							echo "<br/><br/>";
							echo "<input type='hidden' name='classid' value='$classid'/>";
							echo "<input type='hidden' name='begin_class' value='$class_num'/>";
							echo "<input type='hidden' name='class_source' value='$class_source'/>";
							echo "<input type='hidden' name='public_source' value='$public_source'/>";
							echo "<input type='hidden' name='mail_address' value='$mail'/>";
							echo "<input type='hidden' name='note' value='$note'/>";
							echo "<input class='submit' type='submit' name='send' value='发送课程内容'/>";
								echo "</td>";
								echo "</tr>";
							echo "</table>";
							echo "</form>";
							//show audio of this class
							$audio_dir="class_content/".$cb." audio/$class_num";
							echo "<br/>";
							
							if (is_dir($audio_dir)) {
									$filesnames = scandir($audio_dir);
									if ($filesnames != false) {
										//print_r($filesnames);
										foreach ($filesnames as $filename) {
											if ($filename != "." && $filename != "..") { 
												$filename=$audio_dir."/".$filename;
												echo "&nbsp";
												echo "<audio controls='controls' playcount='10'>";
												echo "<source src='$filename' />"; 
												echo "</audio>";
											}
										}
									}
								}
							
							
							echo "<br/><br/>";
							break;
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
