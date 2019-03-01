<?php

function wb_qzj($input, $start, $end) {
  $substr = substr($input, strlen($start)+strpos($input, $start),
  	(strlen($input) - strpos($input, $end))*(-1));
  return $substr;
}

	if (!isset($_GET['user'])) {
		$user1 = "0";
	}
	else
	{
		$user1 = $_GET['user'];
	}
	$apiKey='2849184197';//要修改这里的key再测试哦
	$dlj = $_GET['dlj'];
	$apiUrl='https://api.weibo.com/2/short_url/shorten.json?source='.$apiKey.'&url_long='.$dlj;
	   		  // https://api.weibo.com/2/short_url/shorten.json?source=1388349045&url_long=https://url.cn/5Ue9ua8
	$curlObj = curl_init();
	curl_setopt($curlObj, CURLOPT_URL, $apiUrl);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($curlObj);
	curl_close($curlObj);
	//var_dump($response);
	if(strstr($response,'error'))
	{
		die("错误的短连接！");
	}
	//$json = explode("\"",$response);
	$json = json_decode($response,1);
	//var_dump($json);
	$clj = $json['urls'][0]['url_long'];

	//var_dump($clj);
	$z1="&sn=";
	$y1="&theme_id=";
	$sn=wb_qzj($clj,$z1,$y1);
	//var_dump($sn);
	header("location:a.php?sn=".$sn."&user=".$user1);
?>


<a href="a.php?sn=<?php echo $sn ?>"><br>领取</a>
<a href="index.htm"><br><br>返回</a>