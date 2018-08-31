<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
ini_set('max_execution_time','1000');
require_once "email.class.php";
require_once "../dollar.php";
switch($_GET["action"]) {
	case "send":
		$classid = $_POST["classid"];
		$class_num = $_POST["begin_class"];
		$class_source = $_POST["class_source"];
		$public_source = $_POST["public_source"];
		$smtpemailto = $_POST["mail_address"];
		$note = $_POST["note"];
		
		//需开启SMTP服务，在邮箱里面设置
		// 163发送邮件出现报错现象，其他邮箱可用
	    /*$smtpserver = "smtp.163.com";//SMTP服务器
		$smtpserverport =25;//SMTP服务器端口
		$smtpusermail = "15302130568@163.com";//SMTP服务器的用户邮箱
		$smtpuser = "15302130568";//SMTP服务器的用户帐号
		$smtppass = "daxi666";//SMTP服务器的用户密码 密码是daresay2014
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		*/
		/*
		$smtpserver = "smtp.aliyun.com";//SMTP服务器
		$smtpserverport =25;//SMTP服务器端口
		$smtpusermail = "daresay2014@aliyun.com";//SMTP服务器的用户邮箱
		$smtpuser = "daresay2014@aliyun.com";//SMTP服务器的用户帐号
		$smtppass = "daresay20140506";//SMTP服务器的用户密码 就是邮箱登陆密码
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		*/
		/*
		$smtpserver = "smtp.tom.com";//SMTP服务器
		$smtpserverport =25;//SMTP服务器端口
		$smtpusermail = "daresay2014@tom.com";//SMTP服务器的用户邮箱
		$smtpuser = "daresay2014@tom.com";//SMTP服务器的用户帐号
		$smtppass = "daresay20140506";//SMTP服务器的用户密码 就是邮箱登陆密码
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		*/
		
		$smtpserver = "smtp.sina.com";//SMTP服务器
		$smtpserverport =587;//SMTP服务器端口
		$smtpusermail = "daresay2014@sina.com";//SMTP服务器的用户邮箱
		$smtpuser = "daresay2014@sina.com";//SMTP服务器的用户帐号
		$smtppass = "daresay20140506";//SMTP服务器的用户密码 就是邮箱登陆密码
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		
		//将上课信息加入到class_info_record数据库中
		require_once("../database_opt/db_opt.php");
		$conn=db_conn("daresay_db");
		$table_name="class_info_record";
		$sql="SELECT * FROM {$table_name}";
		$result=mysql_query($sql,$conn);
		$result=mysql_num_rows($result);
		if($result<1){
			//表不存在，创建k2001_class_info_record类似的表
			$sql="CREATE TABLE {$table_name} (id INT(20) not null AUTO_INCREMENT,classid varchar(100),date varchar(100),week varchar(100),hour varchar(100),class_info varchar(1000),absent varchar(64),note varchar(1000),primary key(id))";
			$result=mysql_query($sql, $conn);
			if (!$result) {
				die("SQL: {$sql}<br>Error:".mysql_error());
				//goto SndMail;
			}
		}
		//将上课信息加入到class_info_record数据库中
		include("../class_content/hour_classinfo_match.php");
		$cb=substr($classid,0,2);
		$class_content=$cb."_class_content";
		list($tmp_fir,$tmp_sec) = explode("-",$class_num);
		foreach(${$class_content} as $K=>$V) {
			list($tmp_a,$tmp_b) = explode("-",$K);
			if ($tmp_a <= $tmp_fir && $tmp_sec <= $tmp_b) {
				if (strncmp($V,"Math",4) == 0 || strncmp($V,"Science",7)==0) {
					$print_lesson=$V;
						break;
				}

				$l_num=($tmp_fir-$tmp_a)/2+1;
				$print_lesson=$V." Lesson ".$l_num;
				break;
			} 
		}

		$weekarray=array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
		$date=date("Y-m-d");
		$week=$weekarray[date("w")];
		$class_info=$print_lesson;
		$absent="";
		//$note="";
		mysql_query('BEGIN',$conn);
		$sql="SELECT * FROM {$table_name} FOR UPDATE";
		$result=mysql_query($sql,$conn);
		if (!$result)
			die("SQL: {$sql}<br>Error:".mysql_error());
		$sql="INSERT INTO {$table_name} (classid, date, week, hour, class_info, absent, note) VALUES ('$classid', '$date', '$week', '$class_num', '$class_info', '$absent', '$note')";
		$result=mysql_query($sql, $conn);
		echo mysql_error();
		if (!$result) {
				die("SQL: {$sql}<br>Error:".mysql_error());
				//goto SndMail;
		}
		mysql_query('COMMIT',$conn);
		
//SndMail:
		//mail title
		$mailtitle = $class_num."课时 课程内容";//邮件主题

		//mail content
		$mailcontent = "Dear Parents:"."<br>"."<br>";

		/* get content */

		$cb = substr($classid,0,2);
		$filename = $cb."_class_content.txt";
		$filename = "../class_content/".$filename;
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
		//$mailcontent .= "<br>"."班级视频及照片地址: ".$class_source."<br>"."课后学习资源地址: ".$public_source."<br>";
		$mailcontent.="<br>"."<br>"."Thank you for your understanding and support!"."<br>"."Daresay Education";
		$send_Edward=0;
		$class_email=$smtpemailto;
		$reme_state="";

		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp->debug = false;//是否显示发送的调试信息
		
		//add attachment
		$audio_dir="../class_content/".$cb." audio/".$class_num;
		if (is_dir($audio_dir)) {
			$filesnames = scandir($audio_dir);
			if ($filesnames != false) {
				//print_r($filesnames);
				foreach ($filesnames as $filename) {
					
					if ($filename != "." && $filename != "..") { 
						
						$filename=$audio_dir."/".$filename;
						//echo $filename;
						$smtp->addAttachment($filename);
					}
				}
			}
		}

		$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
		//$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype,"","");
		$reme_state=$state;
		$org_mailcontent=$mailcontent;
		
		//Now send email to Edward

		$Edward_email="18612187698@163.com";
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp->debug = false;//是否显示发送的调试信息
		$smtpemailto=$Edward_email;
		$mailtitle = $classid."  ".$class_num."课时 课程内容"."发送结果为".$state;
		$mailcontent="";
	
//OUT:
		mysql_close($conn);
		everybody_get_dollar($classid, $class_num);
		echo "<div style='width:800px; margin:36px auto; align:center;'>";
		if($reme_state==""){
			echo "ERROR,Failed!Please check the email adress.   ";
			echo "<a href='http://b5270951.hk0004.007cloud.net/mail_index.php'>return</a>";
			exit();
		}
		echo "Success! Already sent to $class_email    ";
		echo "<a href='../mail.php'>return</a>"."<br><br>";
		echo "$org_mailcontent";
		echo "</div>";
}
?>
</html>


