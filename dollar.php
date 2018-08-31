<?php

require_once("database_opt/db_opt.php");

function everybody_get_dollar($classid, $hour){
    $conn=db_conn("daresay_db");
	$sql="SELECT * FROM students WHERE classid='$classid'";
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());	
    $time = time();
    $date = date("Y-m-d",$time);
	$dollar_num = 1;
	$engname_arr = array();
	$i = 0;
    while ($row = mysql_fetch_assoc($result)) {
		$engname_arr[$i] = $row['engname'];
		$i++;
		
	}	
	for ($i=0;$i<count($engname_arr);$i++){
		$engname = $engname_arr[$i];
		$sql = "SELECT * FROM dollar WHERE classid='$classid' and engname='$engname' and hour='$hour'";
		$result=mysql_query($sql,$conn);
	    if (!$result)
		    die("SQL: {$sql}<br>Error:".mysql_error());
		$row = mysql_fetch_assoc($result);
	    if ($row) {
            break;
		}
		$sql="INSERT INTO dollar(engname, classid, hour, date, dollar_num, note)
			  VALUES ('$engname', '$classid', '$hour', '$date', '$dollar_num','$note');";
		$result=mysql_query($sql,$conn);
	    if (!$result)
		    die("SQL: {$sql}<br>Error:".mysql_error());	
	}
	mysql_close($conn);
}	
function absent_student_reduce_dollar ($classid, $engname, $hour) {
	$conn=db_conn("daresay_db");
	$sql="DELETE FROM dollar WHERE classid='$classid' and engname='$engname' and hour='$hour'";
	$result=mysql_query($sql,$conn);
	if (!$result)
		die("SQL: {$sql}<br>Error:".mysql_error());	
	
	mysql_close($conn);
} 

?>