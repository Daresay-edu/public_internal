								<?php
								// Enable CORS (http://enable-cors.org/server_php.html)
								header('Access-Control-Allow-Origin: *');
								require_once("database_opt/db_opt.php");
								$classid=$_POST["Classid"];
								$engname=$_POST["EngName"];
								

								$pay_time=$year."-".$month."-".$day;
								//check if have the same engname in db
								$conn=db_conn("daresay_db");
								$sql="SELECT * FROM students WHERE engname='$engname' and classid='$classid'";
								$result=mysql_query($sql,$conn);
								if (!$result)
									die("SQL: {$sql}<br>Error:".mysql_error());						

								$row = mysql_fetch_assoc($result);
								if ($row) {
									echo $classid."���Ѿ�����Ӣ������Ϊ".$engname."��ѧ��!����������!";	
									mysql_close($conn);
									http_response_code(200);

								} else {
									http_response_code(400);
								}
								
								