<?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$db = new PDO($dsn, $user, $pass);

	$id = 0;
	$result = $db -> query("
	SELECT
		* 
	FROM
		`eleme_hongbao` 
	WHERE
		`left` = '".$id."' 
	");

	while($id++ < 400)
	{
		//$row = $result -> Fetch(); 
		$db -> exec("UPDATE `eleme_hongbao` SET `state` = '1' WHERE `id` = '".$id."';");
	}
	echo "OK id=".$id;
?>