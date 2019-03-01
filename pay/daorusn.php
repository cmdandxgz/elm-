<?php
function wb_qzj($input, $start, $end) {
  $substr = substr($input, strlen($start)+strpos($input, $start),
  	(strlen($input) - strpos($input, $end))*(-1));
  return $substr;
}

class Hongbao {
		private $_sn;
		private $_lucky_number;
		function __construct($sn) {
			$this -> _sn = $sn;
			$this -> _eosid = substr(hexdec($sn), 0, -2) . '00';
			if (isset($this -> getDetail()['lucky_number'])) {
				$this -> _lucky_number = $this -> getDetail()['lucky_number'];
			} else {
				$this -> _lucky_number = 0;
			}
		}
		public function getDetail() {
			$url = 'https://h5.ele.me/restapi//marketing/themes/0/group_sns/'.$this -> _sn;
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			$res = curl_exec($curl);
			curl_close($curl);
			return json_decode($res, true);
		}
		public function getLuckyNumber() {
			return $this -> _lucky_number;
		}
		public function getSN() {
			return $this -> _sn;
		}
		public function getEosid() {
			return $this -> _eosid;
		}
	}
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='test';    //使用的数据库
	$user='root';      //数据库连接用户名
	$pass='';          //对应的密码
	$dsn="$dbms:host=$host;dbname=$dbName";
	$db = new PDO($dsn, $user, $pass);

	$sql = "select * from eleme_hburl";
	$res = $db->prepare($sql);
	$res->execute();
	$num = $res->rowCount();
	$id = 1;
	while($id <= $num)
	{
		$result = $db -> query("
	    SELECT
	        * 
	    FROM
	        eleme_hburl
	    WHERE
	        id = '".$id."'
	    ;
  		");
	    $row = $result -> Fetch(); //每次取出一个url
	    $hburl = $row['url'];
	    $z1="&sn=";
		$y1="&theme_id=";
		//$data = iconv("utf-8","gb2312//IGNORE",urldecode($hbur))."<br>";
		$sn = wb_qzj($hburl,$z1,$y1);

	    $h = new Hongbao($sn); //构造红包对象
		$lucky_number = $h -> getLuckyNumber(); //取出红包的最大包是在第几个，下称幸运数
		$record_number = 0; //记录已经抢了多少个
		if ($lucky_number === 0) {
			echo "这个红包可能过期了或失效了！";
		}
		else
		{

		    $result1 = $db -> query("
			    SELECT
			        * 
			    FROM
			        eleme_sn
			    WHERE
			        sn = '".$sn."'
			    ;
	  		");
		    $row1 = $result1 -> Fetch(); //每次取出一个小号出来
		    if($row1 === false) //空的  建立   state 1未领取 0下个就是最大    sell 1未使用   0已使用
		    {
	    		$query = "
				INSERT INTO 
				`eleme_sn` (`id`, `sn`, `state`,`sell`,`user`) 
				VALUES 
						(NULL,
						 '".$sn."', '1','1','');
				";
				$db->exec($query);
		    }
		}
		unset($h); //释放内存
		$id++;
	}

		

?>