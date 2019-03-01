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
		AND
			`id` > 80
	");
	$row = $result -> Fetch(); //每次取出一个小号出来
	//var_dump($row);
	echo "id:".$row['id']."<br>";
	echo "qq:".$row['qq']."<br>";
	echo "pwd:".$row['pwd']."<br>";
	echo "eleme_key:".$row['eleme_key']."<br>";
	echo "openid:".$row['openid']."<br>";
	echo "sid:".$row['sid']."<br>";
	echo "phone:".$row['phone']."<br><br><br>";

	$key = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
	$opid= "bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb";
	$str = "%7B%22city%22%3A%22%22%2C%22constellation%22%3A%22%22%2C%22eleme_key%22%3A%22aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F77E967488511FDCF5C2A46D91D4F3B54%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F77E967488511FDCF5C2A46D91D4F3B54%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F77E967488511FDCF5C2A46D91D4F3B54%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fthirdqq.qlogo.cn%2Fqqapp%2F101204453%2F77E967488511FDCF5C2A46D91D4F3B54%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fthirdqq.qlogo.cn%2Fqqapp%2F101204453%2F77E967488511FDCF5C2A46D91D4F3B54%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22~ra%E5%A3%81%E4%B9%9D%E6%B6%9D%EF%BF%A58%22%2C%22openid%22%3A%22bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb%22%2C%22province%22%3A%22%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%220%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22~ra%E5%A3%81%E4%B9%9D%E6%B6%9D%EF%BF%A58%22%2C%22avatar%22%3A%22http%3A%2F%2Fthirdqq.qlogo.cn%2Fqqapp%2F101204453%2F77E967488511FDCF5C2A46D91D4F3B54%2F40%22%7D";

	$str = str_replace($key,$row['eleme_key'],$str);
	$str = str_replace($opid,$row['openid'],$str);
	//echo $str."<br>";
?>

<textarea type="text" name="test" style="height:200px;width:800px;" readonly>
<?php echo $str ?>
</textarea> 