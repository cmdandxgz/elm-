<?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	//$host='192.29.130.244'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";

	$db = new PDO($dsn, $user, $pass);
	$result = $db -> query("
		SELECT
			* 
		FROM
			`eleme_qq` 
		WHERE
			`left` BETWEEN 0 AND 11
	");

	while($rew = $result -> Fetch())
	{
		echo " i".$rew['id']."--".$rew['left']." ";
	}
?>