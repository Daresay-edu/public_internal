<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>DareSay Education</title>
<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/daresay.js"></script>
</head>
<body>

<div class='box-content'>
<div class='cl'>&nbsp;</div>



<form name="form1" method="post" action="">
<div class='sort'>
<label>Classid</label>
<select class='field' name='classid'>

<?php
require_once("database_opt/db_opt.php");
	$conn=db_conn("daresay_db");
	$sql="SELECT * FROM class";							
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());	
    echo "<option value='All'>All</option>";	
	while ($row = mysql_fetch_assoc($result)) {
		$tmp=$row['classid'];
		echo "<option value='$tmp'>".$tmp."</option>";	
	}					
	mysql_close($conn);

?>
</select>
<br/>
<label>Case</label>
<p>From:</p>
	<select class='year' name="yearfrom">
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
								<select class='month' name="monthfrom">
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
								<select class='day' name="dayfrom">
								<?php
								$today=date("Y-m-j");								
								$arr=explode("-",$today);
								$day=$arr[2];
								$i=1;
								for ($i;$i<32;$i++) {
										echo "<option value='{$i}'>{$i}</option>";
								}
								?>
								</select>
<p>To:</p>
	<select class='year' name="yearend">
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
								<select class='month' name="monthend">
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
								<select class='day' name="dayend">
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
<br/><br/>
<label>Type</label>
<select class='field' name="type">
	<option value="income">已赚</option>
	<option value="all">收取</option>
</select>
<br/><br/>
<label>Password</label>
<input class='field' type='password' name='password'/>
<br/>
<input class='submit' type="button" onclick="form1.action='income_manage.php?action=display';form1.submit();" value="Count"/><span></span>

<div class='cl'>&nbsp;</div>
</div>
</form>

</div>
</body>
</html>

