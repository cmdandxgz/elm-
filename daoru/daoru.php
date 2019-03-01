<?php 

function wb_qzj($input, $start, $end) {
  $substr = substr($input, strlen($start)+strpos($input, $start),
  	(strlen($input) - strpos($input, $end))*(-1));
  return $substr;
}

$qq = $_POST['qq']; 
$mm = $_POST['mm']; 
//$mm = "qy66666666";
$utf = $_POST['utf']; 
$sid = $_POST['sid']; 
$phone = $_POST['phone']; 
// echo $utf."<br>";
$data = iconv("utf-8","gb2312//IGNORE",urldecode($utf))."<br>";
// echo "$data";
$z1="eleme_key"."\"".":"."\"";
$y1="\"".","."\""."figureurl";
$z2="openid"."\"".":"."\"";
$y2="\"".","."\""."province";

$key=wb_qzj($data,$z1,$y1);
$openid=wb_qzj($data,$z2,$y2);

// echo "$key"."<br>";
// echo "$openid"."<br>";


if(empty($qq) || empty($mm) || empty($key) || empty($openid) || empty($sid) || empty($phone))
{
	die("不能有空!");
}
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='test';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";

$db = new PDO($dsn, $user, $pass);
$query = "
			INSERT INTO 
			`eleme_qq` (`id`, `qq`, `pwd`, `eleme_key`, `openid`, `sid`, `left`, `phone`) 
			VALUES 
					(NULL,
					 '".$qq."', '".$mm."', '".$key."', '".$openid."', '".$sid."', '4', '".$phone."');
		";
	//	$db -> query($query);
		 if($db->exec($query))
		 {
		 	echo "成功！"."<br>";
		 }
		 else
		 {
		 	echo "未知错误！"."<br>";
		 }

?>

<a href="daoru.htm">返回</a>