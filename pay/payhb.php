<?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$db = new PDO($dsn, $user, $pass);
	
	$user1 = $_GET['user'];

	$result = $db -> query("
		SELECT
			* 
		FROM
			eleme_sn
		WHERE
			state = '0'
			AND
			sell = '1'
	");
	$row = $result -> Fetch(); //每次取出一个小号出来
	$sn = $row['sn'];
	if($row === false)
	{
		// $url='http://119.29.130.244/pay/paosn.php?num=1';  
		// $res = file_get_contents($url); 
		// if(strstr($res,"OK"))
		// {
		// 	$row = $result -> Fetch(); //每次取出一个小号出来
		// 	$sn = $row['sn'];
		// 	$query = "
		// 	UPDATE
		// 		 `eleme_sn` 
		// 	SET
		// 		 `sell` = '0' ,
		// 		 `user` = '".$user1."'
		// 	WHERE 
		// 		 `sn` = '".$sn."';
		// 		";
		// 	$db->exec($query);
		// 	echo "https://h5.ele.me/hongbao/?sn=".$sn;
		// }
		// else
		// {
				echo "已经没有可用的红包了，请联系主人补充或退款。主人QQ：793991833";
		//}
	}
	else
	{
		$query = "
			UPDATE
				 `eleme_sn` 
			SET
				 `sell` = '0', 
				 `user` = '".$user1."'
			WHERE 
				 `sn` = '".$sn."';
				";
		$db->exec($query);
		echo "下一个就是最大红包啦，直接点进去领取吧~~
		 https://h5.ele.me/hongbao/?sn=".$sn."
		 如果不是最大，请截图联系主人更换或退款。";
	}
	
?>