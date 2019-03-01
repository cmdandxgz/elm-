<?php

function aa($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}

function wb_qzj($input, $start, $end) {
  $substr = substr($input, strlen($start)+strpos($input, $start),
  	(strlen($input) - strpos($input, $end))*(-1));
  return $substr;
}

$dbms='mysql';     //数据库类型
$host='localhost'; //数据库主机名
$dbName='test';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";
$db = new PDO($dsn, $user, $pass);
$mgs = aa($_POST['content']);
$wx_id = $_POST['mid'];
$zhuan = $_POST['msgtype'];

if($_POST['msgtype'] == '49')   
{

    if(strstr($mgs,"转账"))
    {
        $z1="到转账";
        $y1="元。";
        $money=wb_qzj($mgs,$z1,$y1);
        $z1="cationidCDATA";
        $y1="transcationidbrtransferid";
        $logo=wb_qzj($mgs,$z1,$y1);
        if($logo == NULL)
        {
            $z1="cationidCDATA";
            $y1="transcationidtransferid";
            $logo=wb_qzj($mgs,$z1,$y1);
        }

        $result = $db -> query("
            SELECT
                * 
            FROM
                eleme_zzid
            WHERE
                logo = '".$logo."'
            ;
        ");
        $row = $result -> Fetch(); //每次取出一个小号出来
        if($row === false) //空的  
        {
            $query = "
                INSERT INTO 
                    `eleme_zzid`(`id`, `logo`, `user`) 
                VALUES 
                    (NULL,'".$logo."','".$wx_id."');    //默认1， 朋友2， 主人10， 无权0
            ";
            $db->exec($query);
            if($money == '050')
            {
                $url='http://119.29.130.244/pay/payhb.php?user='.$wx_id;  
                $res = file_get_contents($url); 
                echo '{"rs":1,"tip":"'.$res.'","end":0}';
            }
            else
            {
                echo '{"rs":1,"tip":"错误的转账金额，24小时候会自动退款，或联系主人退款。","end":0}';
            }
        }
        else
        {
            echo '{"rs":1,"tip":"你在做什么，我可是都知道的哦~\n如有疑问，请联系主人。","end":0}';
        }
    }
    else if(strstr($mgs,"http"))
    {
        $z1="ampsn";
        $y1="amptheme_id";
        $sn=wb_qzj($mgs,$z1,$y1);
        if(strlen($sn) != strlen("2a0b48b7a0aebc7c"))
        {
            echo '{"rs":1,"tip":"错误的红包链接。如有疑问请联系主人QQ：793991833","end":0}';
            die();
        }
        $url='http://119.29.130.244/a.php?sn='.$sn.'&user='.$wx_id;  
        $res = file_get_contents($url);  

        if(strstr($res,"下一个就是最大红包"))
        {
            echo '{"rs":1,"tip":"'.$res.'\n----------\n菜单：\n买红包、查询、使用方法、获取wxid
            [结束]祝您使用愉快~~您还可打开支付宝首页搜索“545504819” 立即领红哦~~~[结束]主人更新不易，记得领着支付宝红包哦～谢谢～","end":0}';
            die();
        }
        else
        {
            echo '{"rs":1,"tip":"'.$res.'","end":0}';
            //\n----------\n菜单：\n买红包、查询、使用方法、获取wxid\n如有疑问请联系主人QQ：793991833
        }
    }
}

if(strstr($mgs,"买红包"))
{
    echo '{"rs":1,"tip":"1.转账给me 0.5元（有次数的直接发送~领取最大红包~）（发送~查询~查询次数）\n2.骚等一会me将会发送一条红包链接给您\n3.直！接！点！击！链接进去领取\n4.大红包到手\n注意事项！！！！！！！\n①.转账！！！转账！！！转账！！！不收红包\n②.大量购买请联系主人优惠\n③.遇到错误请联系主人敲他。主人QQ：793991833[结束]购买的红包和正常红包一模一样，只是被主人删除le不必要的参数，请大家放心使用。额度为4-10元不等","end":0}';
    die();
}

if(strstr($mgs,"查询"))
{
    $url='http://119.29.130.244/pay/cxuser.php?user='.$wx_id;  
    $res = file_get_contents($url); 
    echo '{"rs":1,"tip":"'.$res.'","end":0}';
    die();
}

if(strstr($mgs,"获取wxid"))
{
    echo '{"rs":1,"tip":"您的wxid为：'.$wx_id.'","end":0}';
    die();
}

if(strstr($mgs,"领取最大") || strstr($mgs,"最大包"))
{
    $url='http://119.29.130.244/pay/hongbao.php?user='.$wx_id;  
    $res = file_get_contents($url); 
    echo '{"rs":1,"tip":"'.$res.'","end":0}';
    die();
}

if($zhuan == '10000' && strstr($mgs,"收到红包"))
{
    echo '{"rs":1,"tip":"感谢赞赏~~~~
如果是买红包请转账！！转账！！转账！！，你可以等待24小时候会自动退款，或联系主人退款。","end":0}';
}
if(strstr($mgs,"使用方法"))
{
	echo '{"rs":1,"tip":"1.进入饿了么app（暂不支持支付宝分享的链接）\n2.点击订单，进入随便一个历史订单（注意该订单的红包要没被分享过）\n3.点击右上角的小红包，选择分享到微信\n4.选择分享给我\n5.等待提示下一个就是最大红包（一般10s左右）\n6.点击您分享的红包，领取红包，大红包到手^.^\n/***红包自产自销，切勿到群里转发别人的红包，以免引起纠纷***/\n/***！！买红包功能发送~买红包~口令查询！！***/","end":0}';
	die();
}

//echo '{"rs":1,"tip":"你可以发送~使用方法~来查询如何使用\n如有疑问请联系主人QQ：793991833","end":0}';

?>