<?php

function backup_db() {
	$time=date("Y-m-d");
	$cmd="C:/xampp/mysql/bin/mysqldump.exe -uroot -pdaresay2014 b5270951>db_backup/b5270951_".$time.".sql";
	//exec("C:/xampp/mysql/bin/mysqldump.exe -uroot -pdaresay2014 b5270951>C:/xampp/htdocs/internal_0506/db_backup/b5270951.sql");
	exec($cmd);
}
	function db_conn($mysql_database)

	{
		ini_set('max_execution_time','1000');
		$mysql_server_name='localhost';
		$mysql_username='root';
		$mysql_password='xingpai888';
		$mysql_database='xingpai';//云主机上的数据库名字
		
		$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
		if (!$conn)
		{
			die('Could not connect: ' . mysql_error());
		}
		//$mysql_database="b5270951";
		$db_selected = mysql_select_db($mysql_database,$conn);
		return $conn;
		
	}
?>
