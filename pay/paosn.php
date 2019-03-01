<?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$db = new PDO($dsn, $user, $pass);


	$num = $_GET['num'];

	while($num--)
	{
		$result = $db -> query("
			SELECT
				* 
			FROM
				eleme_sn
			WHERE
				state = '1'
				AND
				sell = '1'
		");
		$row = $result -> Fetch(); //每次取出一个小号出来
		$sn = $row['sn'];
		if($row === false)
		{
			echo "已经没有可用的sn了，请补充";
		}
		else
		{
			$url='http://119.29.130.244/a.php?sn='.$sn.'&user=robot';  
			$res = file_get_contents($url); 
			if(strstr($res,"下一个就是最大红包")) 
			{
				$query = "
				UPDATE
					 `eleme_sn` 
				SET
					 `state` = '0' 
				WHERE 
					 `sn` = '".$sn."';
					";
				$db->exec($query);
				echo "OK ";
			}
			else  	//错误
			{		
				$query = "
				UPDATE
					 `eleme_sn` 
				SET
					 `state` = '5' 
				WHERE 
					 `sn` = '".$sn."';
					";
				$db->exec($query);
			}
		}
	}
	
?>