
<?php
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$db = new PDO($dsn, $user, $pass);

	$sql2 = "select * from eleme_sn where state = 0 and sell =1";
	$res2 = $db->prepare($sql2);
	//$res->exec();
	$res2->execute();
	$hb_num1 = $res2->rowCount();
		

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
    	echo "请先发一个饿了么红包给me，让me帮忙领到最大。或者联系主人，主人QQ：793991833";
    }
    else
    {
    	echo "今日剩余使用次数（每日重置）：".$row['today_num']."
    	总共剩余可免费领取最大红包次数（发送~领取最大红包~领取）：".$row['hb_num']."
    	买红包库存: ". $hb_num1 . "个，可发送~买红包~口令购买。购买的红包和正常红包一模一样，额度为4-10元不等";
    }
?>