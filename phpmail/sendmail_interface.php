<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=gbk" />
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
require_once "email.class.php";
include "mail_array.php";
function send_mail($email_addr,$email_title,$email_content) {
			//$classid = $_POST["classid"];
			//$class_num = $_POST["begin_class"];
			$smtpserver = "smtp.sina.com";//SMTP服务器
			$smtpserverport =587;//SMTP服务器端口
			$smtpusermail = "daresay2014@sina.com";//SMTP服务器的用户邮箱
			$smtpuser = "daresay2014@sina.com";//SMTP服务器的用户帐号
			$smtppass = "daresay20140506";//SMTP服务器的用户密码 就是邮箱登陆密码
			$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
			
			$smtpemailto=$email_addr;
			$mailtitle=$email_title;
			$mailcontent=$email_content;
			$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
			$smtp->debug = false;//是否显示发送的调试信息
			$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
	
}

?>
</html>


