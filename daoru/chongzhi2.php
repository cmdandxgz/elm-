<?php
$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='test';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";
$db = new PDO($dsn, $user, $pass);



		$sql = "select * from eleme_qq";
		$res = $db->prepare($sql);
		//$res->exec();
		$res->execute();
		$num = $res->rowCount();
		$id = 1;
		while($id <= $num)
		{
			$query = "
				UPDATE
					 `eleme_qq` 
				SET
					 `left` = '5' 
				WHERE 
					`eleme_qq`.`id` = '".$id."';
					";
			$db->exec($query);
			$id++;
		}

		$sql = "select * from eleme_user";
		$res = $db->prepare($sql);
		$res->execute();
		$num = $res->rowCount();
		$num += 5;
		$id = 1;
		while($id <= $num)
		{
			$result = $db -> query("
			SELECT
				* 
			FROM
				eleme_user
			WHERE
				id = '".$id."'
			");
			$row = $result -> Fetch(); //每次取出一个小号出来
			if($row['quan'] == 10)
			{
				$query = "
					UPDATE
						 `eleme_user` 
					SET
						 `today_num` = '100' 
					WHERE 
						`user` = '".$row['user']."';
						";
				$db->exec($query);
			}
			else if($row['quan'] == 2)
			{
				$query = "
					UPDATE
						 `eleme_user` 
					SET
						 `today_num` = '5'
					WHERE 
						`user` = '".$row['user']."';
						";
				$db->exec($query);
			}
			else if($row['quan'] == 1)
			{
				$query = "
					UPDATE
						 `eleme_user` 
					SET
						 `today_num` = '1' 
					WHERE 
						`user` = '".$row['user']."';
						";
				$db->exec($query);
			}
			else if($row['quan'] == 0)
			{
				$query = "
					UPDATE
						 `eleme_user` 
					SET
						 `today_num` = '0'
					WHERE 
						`user` = '".$row['user']."';
						";
				$db->exec($query);
			}
			$id++;
		}
echo "成功重置数据库！";
?>