<?php

require_once("db_opt.php");
function get_current_hour($classid){
	require_once("db_opt.php");
	$conn=db_conn("daresay_db");
	//read the class record info and get the hour
	$table_name="class_info_record";
	$sql="SELECT * FROM {$table_name} where classid='$classid'";
	$result=mysql_query($sql,$conn);
	$big_hour=0;
	$record_hour=0;
	while ($row = mysql_fetch_assoc($result)) {
		$tmp_hour=$row['hour'];
		$tmp_date=$row['date'];
		list($fir_hour,$sec_hour)=explode("-",$tmp_hour);
		if ($big_hour < $fir_hour) {
			$big_hour=$fir_hour;	
			$record_hour=$tmp_hour."&".$tmp_date;
		}
	}
	mysql_close($conn);
	return $record_hour;
}	
function who_need_pay($classid){
	require_once("db_opt.php");
	$conn=db_conn("daresay_db");
	$needpay_students=array();
	$i=0;

	$sql="SELECT * FROM students where classid='$classid'";
	$result=mysql_query($sql,$conn);
	while ($row = mysql_fetch_assoc($result)) {
		$need_pay=$row['hour_end'];
		$engname=$row['engname'];
		list($fir_class,$sec_class) = explode("-",$class_num);
		if ($need_pay - $sec_class <= 10) {
			$needpay_students[$i]=$row["engname"];
			$i++;
		}
	}
	mysql_close($conn);
	return $needpay_students;
}	
function is_normal_class($classid) {
		$ret=0;
		$char=substr($classid, 0, 1);
		if ($char == "K" || 
			$char == "S" || 
			$char == "k" || 
			$char == "s") {
			$ret=1;
		}
		return $ret;
			
}
function get_running_class() {
	require_once("db_opt.php");
	$conn=db_conn("daresay_db");
	$running_class =array();
	$i=0;

	$sql="SELECT * FROM class";
	$result=mysql_query($sql,$conn);
	while ($row = mysql_fetch_assoc($result)) {
		$tmp=$row['classid'];
		if (!is_normal_class($tmp)) 
			continue;
		$sql="SELECT * FROM class_info_record WHERE classid='$tmp' and hour='191-192'";
        $result1=mysql_query($sql,$conn);
		$row1 = mysql_fetch_assoc($result1);
		if ($row1)
             continue;												
		$running_class[$i]=$tmp;
		$i++;										
		
	}
	mysql_close($conn);
	sort($running_class);
	return $running_class;
}
function get_normal_class() {
	require_once("db_opt.php");
	$conn=db_conn("daresay_db");
	$running_class =array();
	$i=0;

	$sql="SELECT * FROM class";
	$result=mysql_query($sql,$conn);
	while ($row = mysql_fetch_assoc($result)) {
		$tmp=$row['classid'];
		if (!is_normal_class($tmp)) 
			continue;											
		$running_class[$i]=$tmp;
		$i++;										
		
	}
	mysql_close($conn);
	sort($running_class);
	return $running_class;
}
function get_all_class() {
	require_once("db_opt.php");
	$conn=db_conn("daresay_db");
	$running_class =array();
	$i=0;

	$sql="SELECT * FROM class";
	$result=mysql_query($sql,$conn);
	while ($row = mysql_fetch_assoc($result)) {
		$tmp=$row['classid'];											
		$running_class[$i]=$tmp;
		$i++;										
		
	}
	mysql_close($conn);
	sort($running_class);
	return $running_class;
}
function print_remind_by_classid($classid) {
	if (is_normal_class($classid)) {
		static $num=1;
		$conn=db_conn("daresay_db");
		$table_name="class";
		$sql="SELECT * FROM {$table_name} WHERE classid='$classid'";
		$result=mysql_query($sql,$conn);
		if (!$result)
			die("SQL: {$sql}<br>Error:".mysql_error());	
		$row = mysql_fetch_assoc($result);
		$current_hour_date = get_current_hour($classid);
		list($current_hour,$class_date) = array_pad(explode("&", $current_hour_date, 2), 2 , null);
		if($current_hour == "191-192")
			return 1;
		
		list($fir_tm,$sec_tm) = array_pad(explode(",", $row['class_time'], 2), 2 , null);
	echo "<h1 align='center'>".$num++." 班级: ".$classid."   课时：".$current_hour." [".$class_date."]   上课时间：".$row['class_time']."</h1>";
		echo "<table border='1' align='center'>";

		list($fir_class,$sec_class) = array_pad(explode("-", $current_hour, 2), 2 , null);
		//who need to pay
		$sql="SELECT * FROM students where classid='$classid'";
		$result=mysql_query($sql,$conn);
		while ($row = mysql_fetch_assoc($result)) {
			$need_pay=$row['hour_end'];
			$engname=$row['engname'];
			if ($need_pay - $sec_class <= 10) {
				echo "<tr>";
					
					echo "<td cellpadding='20' bgcolor='7ECD8C'><B>[缴费提醒]</B>".$row['engname']."缴费到第<B>".$need_pay."</B>课时</td>";
					echo "<td><input type='button' id='makeup_finish' value='Pay' onClick=''/></td>";
				echo "</tr>";
			}
		}
		//who need to make up
		$sql="SELECT * FROM absent";
		$result=mysql_query($sql,$conn);
		$i=0;
		while ($row = mysql_fetch_assoc($result)) {
			$ab_hour=$row['ab_hour'];
			$aclassid=$row['classid'];
			$engname=$row['engname'];
			$finish=$row['finish'];
			$cl1 = substr($classid,0,2);
			$cl2 = substr($aclassid,0,2);
			list($fir_ab, $sec_ab) = array_pad(explode("-", $ab_hour, 2), 2, null);
			if (($fir_ab <= ($fir_class+4)) && ($sec_class < $sec_ab) && ($cl1 == $cl2) && ($finish=="no")) {
				if ($fir_class+2 == $fir_ab)
					$makeup_tm = $fir_tm;
				else 
					$makeup_tm = $sec_tm;
				echo "<tr>";
					$str="[补课通知]请".$aclassid."班".$engname."于".$makeup_tm."来".$classid."补第".$ab_hour."课时，收到请回复。如果当天不能来补课，请微信中通知我，谢谢您的配合！";
					echo "<td>".$str."<input type='text' id='$i' value='$str'/></td>";
					echo "<td><a href='#' target='_self' id='$aclassid&$engname&$ab_hour&$classid&$i' onClick='javascript:return makeup_finish(this.id);'>DONE</a></td>";
				echo "</tr>";
			}
			$i++;
		}	
		echo "</table>";	
		return 1;
	} else {
		return 0;
	}
} 
?>