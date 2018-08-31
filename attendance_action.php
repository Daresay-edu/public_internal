<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>DareSay Education</title>
 <style type="text/css">  
 table
{
	border-collapse:collapse;
}
 table, tr, td
{
border: 1px solid;
}
.title td
{
	text-align:center;
	width:140px;
}
.content td
{
	text-align:center;
	width:140px;
	height:57px;
}
</style> 
</head>

<?php
header("Content-type:text/html;charset=utf-8"); 
include("class_content/hour_classinfo_match.php");
require_once("database_opt/db_opt.php");
$db_table="class";
switch($_GET["action"]) {
	case "add":

		$classid = $_POST["classid"];
		$year = $_POST["begin_year"];
		$month = $_POST["begin_month"];
		$day = $_POST["begin_day"];
		$begin_class = $_POST["begin_class"];
		$days = $_POST["days"];
		$months = $_POST["months"];
		//do some check
		if ($days == '' || $months == '') {
			echo "天数或出勤表所占月份不能为空！";
			break;
		}
		
		$found=0;
		$week=0;
		$tmp_time=$year."-".$month."-".$day;
		$tmp_week = date('w',strtotime($tmp_time));
		$conn=db_conn("daresay_db");
		$sql="SELECT * FROM $db_table WHERE classid='$classid'";
		$result=mysql_query($sql,$conn);
		if (!$result)
			die("SQL: {$sql}<br>Error:".mysql_error());						
		$row = mysql_fetch_assoc($result);
		$class_time=$row['class_time'];
		list($first_time,$sec_time) = explode(",",$class_time);
		
		if ($num_to_week[$tmp_week] == $first_time || $num_to_week[$tmp_week] == $sec_time) { 
			$week = $num_to_week[$tmp_week]; 
			$found = 1;
		}

		if ($found==0) { 
			echo "$year-$month-$day","这天","$classid","班不应该有课，请检查下星期！";
			exit;
		}
		
		/* get the class number*/
		list($org_first,$org_sec) = explode("-",$begin_class);
		$last_class = $org_first-1;
		$will_class = $days*2;
		$left_class = 192-$last_class-$will_class;
		$cb=substr($classid,0,2);

		echo "<h1 align='center'>","$classid","班","$months","月学员出勤表","</h1>";
		echo "<table class='title' border='0' align='center'>";
			echo "<tr>";
				echo "<td>班级阶段";
				echo "</td>";
				echo "<td line-height:20px>","$cb";
				echo "</td>";
				echo "<td>班级开课日期";
				echo "</td>";
				foreach($class_first_class as $K=>$V) {
					if ($classid == $K) {
						$first_class=$V;
					}
				}
				echo "<td>","$first_class";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>已上课时数";
				echo "</td>";
				echo "<td bgcolor='7ECD8C'>","$last_class";
				echo "</td>";
				echo "<td>本月累计课时";
				echo "</td>";
				echo "<td bgcolor='7ECD8C'>","$will_class";
				echo "</td>";
				echo "<td>截至本月剩余课时";
				echo "</td>";
				echo "<td bgcolor='7ECD8C'>","$left_class/192";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<p>","</p>";
		echo "<table class='content' border='1' align='center'>";
			echo "<tr>";
				echo "<td align='center'>名字";
				echo "</td>";
				$i=1;
				$tmp_fir=$org_first;
				$tmp_sec=$org_sec;
				for($i;$i <= $days; $i++) {
					echo "<td align='center'>";
					echo "$tmp_fir-$tmp_sec","H".'<br/>';
					echo "$month","月","$day","日".'<br/>';
					echo "$week";
					echo "</td>";
					$tmp_fir+=2;
					$tmp_sec+=2;
					while(1) {
						$found=0;
						$day++;
						if ($month==12 && $day==32) {
							$year++;
							$month=1;
						}
						if ($month==2 && $day==29) {
							$month++;
							$day=1;
						}
						if ($day==31) {
							if($month==2 || $month==4 || $month==6||$month==9||$month==11) {
								$month++;
								$day=1;
							}
						}
						if ($day==32) {
							if($month==1 || $month==3 || $month==5||$month==7||$month==8||$month==10||$month==12) {
								$month++;
								$day=1;
							}
						}
						/* check the date is correct or not, match the week */
						$tmp_time=$year."-".$month."-".$day;
						$tmp = date('w',strtotime($tmp_time));
						$class_ct=$classid."_ct";
						foreach(${$class_ct} as $K=>$V) {
							if ($tmp == $V) {
								foreach($num_to_week as $K1=>$V1) {
									if ($V==$K1) 
										$week=$V1;
									$found=1;
								}
								break;
							}
						}
						if ($found==1)
							break;
					}

				}
			echo "</tr>";

			$class_content=$cb."_class_content";

			/* read studenst informantion from db */

			$sql="SELECT * FROM students WHERE classid='$classid'";
			$result=mysql_query($sql,$conn);
			if (!$result)
				die("SQL: {$sql}<br>Error:".mysql_error());

			while($row = mysql_fetch_assoc($result)){
				$tmp_fir=$org_first;
				$tmp_sec=$org_sec;
				$print_lesson="";
				echo "<tr>";
				echo "<td align='center'>".$row['name'].'<br/>'.$row['engname'];
				echo "</td>";
				$i=1;
				for($i;$i<=$days;$i++) {
					foreach(${$class_content} as $K=>$V) {
						list($tmp_a,$tmp_b) = explode("-",$K);
						if ($tmp_a <= $tmp_fir && $tmp_sec <= $tmp_b) {
							if (strncmp($V,"Math",4) == 0 || strncmp($V,"Science",7)==0) {
								$print_lesson=$V;
								break;
							}

							$l_num=($tmp_fir-$tmp_a)/2+1;
							$print_lesson=$V.'<br/>'."Lesson ".$l_num;
							break;
						} 
					}
					echo "<td align='center'>","$print_lesson";
					echo "</td>";
					$tmp_fir+=2;
					$tmp_sec+=2;
				}
				echo "</tr>";


			}
		echo "</table>";
		mysql_close($conn);
		break;

}
?>
</html>
