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
<a href='dollar_add.php' class='add-button'><span>Add new dollar</span></a>
<div class='cl'>&nbsp;</div>

<form action="dollar_manage.php?action=display" method="post">
<div class='sort'>
<label>Classid</label>
<select class='field' name='classid' id="dis_classid" onchange="dis_ab_getClassMem(this.value)">
<option value="def">请选择</option>
	<?php
								
		require_once("database_opt/public.php");
										$classes = get_normal_class();
										echo $classes;
										for ($i=0;$i<count($classes);$i++) {
								            $tmp = $classes[$i];
											echo "<option value='$tmp'>".$tmp."</option>";	
										}	
							
	?>

</select>
<br/>
<label>English Name</label>
<select class='field' name="engname" id="dis_engname">
<option value="null">null</option>
</select>
</select><br/>
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
	<select class='year' name="yearto">
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
								<select class='month' name="monthto">
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
								<select class='day' name="dayto">
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
<input class='field'  style="background-color:#F9EBAE" type='submit' value='Display'/><span></span>
<div class='cl'>&nbsp;</div>
</div>
</form>
</div>
</body>
</html>

