<?php

class Hongbao 
{
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
		//$res1 = json_decode($res, true);
		//print_r($res1); //调试用
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

	$result = $db -> query("
		SELECT
			* 
		FROM
			eleme_hongbao
		WHERE
			state = 0
	");
	while(true)
	{
		$row = $result -> Fetch(); //每次取出一个小号出来
		$sn = $row['sn'];
		if($row === false)
		{
			echo "NO";
		}
		else
		{
			// $query = "
			// UPDATE
			// 	 `eleme_hongbao` 
			// SET
			// 	 `state` = '1'
			// WHERE 
			// 	 `sn` = '".$sn."';
			// 	";
			// $db->exec($query);
			$h = new Hongbao($sn); //构造红包对象
			$lucky_number = $h -> getLuckyNumber(); //取出红包的最大包是在第几个，下称幸运数
			$record_number = 0; //记录已经抢了多少个
			if ($lucky_number === 0) 
			{
				//echo ("这个红包可能过期了或失效了！");
				$query = "
				UPDATE
					 `eleme_hongbao` 
				SET
					 `state` = '4'
				WHERE 
					 `sn` = '".$sn."';
					";
				$db->exec($query);
			}
			else
			{
				$query = "
				UPDATE
					 `eleme_hongbao` 
				SET
					 `state` = '1'
				WHERE 
					 `sn` = '".$sn."';
					";
				$db->exec($query);

				$result1 = $db -> query("
					SELECT
						* 
					FROM
						eleme_sn
					WHERE
						sn = '".$sn."'
				");
				$row1 = $result1 -> Fetch(); //每次取出一个小号出来
				if($row1 === false)
				{
					echo $sn;
					break;
				}
				else
				{

				}
			}
		}
	}
?>