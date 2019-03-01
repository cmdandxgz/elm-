<?php header("Content-type: text/plain; charset=utf-8"); ?><?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$db = new PDO($dsn, $user, $pass);


	$snurl='http://119.29.130.244/gethb/getsn.php';  
	$sn = file_get_contents($snurl); 

	$url='http://119.29.130.244/a.php?sn='.$sn.'&user=robot';  
	$res = file_get_contents($url); 
	echo $res;
	if(strstr($res,"emmm")) 
	{
	    		$query = "
				INSERT INTO 
				`eleme_sn` (`id`, `sn`, `state`,`sell`,`user`) 
				VALUES 
						(NULL,
						 '".$sn."', '0','1','');
				";
	//			$db->exec($query);
	//	$db -> query($query);
		 if($db->exec($query))
		 {
		 	echo "成功！"."<br>";
		 }
		 else
		 {
		 	echo "未知错误！"."<br>"."sn=".$sn;
		 }
	}
	else
	{
		$query = "
			UPDATE
				 `eleme_hongbao` 
			SET
				 `state` = '5'
			WHERE 
				 `sn` = '".$sn."';
				";
			$db->exec($query);
	}
	
	echo "sn=".$sn;
?>