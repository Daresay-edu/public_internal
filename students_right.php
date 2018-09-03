<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>DareSay Education</title>
<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/daresay.js"></script>
<script>
    function delete_stu(){
        if(confirm("确认删除吗？")){
            form1.action='students_manage.php?action=delete';
	    form1.submit();
	}
        return false;
        
    }
</script>
</head>
<body>

<div class='box-content'>
<a href='student_add.php' class='add-button'><span>Add new student</span></a>
<div class='cl'>&nbsp;</div>

<form action="students_manage.php?action=display" method="post">
<div class='sort'>
<label>Classid</label>
<select class='field' name='classid'>
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
<br/>
<input class='field'  style="background-color:#F9EBAE" type='submit' value='Display students'/><span></span>
<div class='cl'>&nbsp;</div>
</div>

</form>

<form name="form1" method="post" action="">
<div class='sort'>
<label>Classid</label>
<select class='field' name='classid' id="classid" onchange="getClassMem(this.value)">
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
<br/>
<label>English Name</label>
<select class='field' name='engname' id="engname">
<option value="null">null</option>
</select>
<br/>
<input class='field'  style="background-color:#F9EBAE" type="button" onclick="form1.action='students_manage.php?action=modify';form1.submit();" value="Modify"/><span></span>
<input class='field'  style="background-color:#F9EBAE" type="button" onclick="form1.action='students_manage.php?action=copy';form1.submit();" value="Copy"/><span></span>
<input class='field'  style="background-color:#F9EBAE" type="button" onclick="return delete_stu();" value="Delete"/><span></span>
<div class='cl'>&nbsp;</div>
</div>
</form>

</div>
</body>
</html>

