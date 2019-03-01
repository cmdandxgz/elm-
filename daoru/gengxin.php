<?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
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
		`left` = '11' 
	");

	while(true)

	{
		$row = $result -> Fetch(); 
		if($row === false)
		{
			die('更新成功！');
		}

		$db -> exec("UPDATE `eleme_qq` SET `left` = '5' WHERE `qq` = '".$row['qq']."';");
	}
?>