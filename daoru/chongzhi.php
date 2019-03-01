<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='test';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";
$db = new PDO($dsn, $user, $pass);
$mm = $_POST['mima'];

	if($mm == "980406")
	{
		$sql = "select * from eleme_qq";
		$res = $db->prepare($sql);
		//$res->exec();
		$res->execute();
		$num = $res->rowCount();
		$id = 1;
		while($id <= $num)
		{
			$query = "
				UPDATE
					 `eleme_qq` 
				SET
					 `left` = '5' 
				WHERE 
					`eleme_qq`.`id` = '".$id."';
					";
			$db->exec($query);
			$id++;
		}
		echo "成功！"."<br>";
	}
	else
	{
		echo "密码错误！"."<br>";
	}
?>
<a href="daoru.htm">返回</a>