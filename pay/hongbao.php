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
		        eleme_user
		    WHERE
		        user = '".$user1."'
		    ;
  		");
	$row = $result -> Fetch(); //每次取出一个小号出来
    if($row === false) //空的  
    {
		echo "错误！请联系主人QQ：793991833";
    }
    else
    {
    	$hb_num = $row['hb_num'];
    	if($hb_num != 0)
    	{
    		$url='http://119.29.130.244/pay/payhb.php?user='.$user1;  
			$res = file_get_contents($url); 
			$hb_num--;
			$query = "
					UPDATE
						 `eleme_user` 
					SET
						 `hb_num` = '".$hb_num."' 
					WHERE 
						`user` = '".$row['user']."';
						";
			$db->exec($query);
			echo $res."
			剩余可免费领取次数：".$hb_num.
			" 您可发送~买红包~口令购买红包，大量购买请联系主人。"
			;
    	}
    	else
    	{
    		echo "剩余可免费领取次数不足：".$hb_num.
			" 您可发送~买红包~口令购买红包，大量购买请联系主人。";
    	}

    }
?>