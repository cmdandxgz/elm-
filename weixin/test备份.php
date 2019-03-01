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

$mgs = aa($_POST['content']);
$wx_id = $_POST['mid'];

if(strstr($mgs,"使用方法"))
{
	echo '{"rs":1,"tip":"1.进入饿了么app（暂不支持支付宝分享的链接）\n2.点击订单，进入随便一个历史订单（注意该订单的红包要没被分享过）\n3.点击右上角的小红包，选择分享到微信\n4.选择分享给我\n5.等待提示下一个就是最大红包（一般10s左右）\n6.点击您分享的红包，领取红包，大红包到手^.^\n/***红包自产自销，切勿到群里转发别人的红包，以免引起纠纷***/\n/***主人积极拒绝承担任何形式的责任，本应用仅是主人玩玩而已，切勿用于商业及非法用途，如产生法律纠纷与主人无关。***/","end":0}';
	die();
}

if(strstr($mgs,"http"))
{
	$z1="ampsn";
	$y1="amptheme_id";
	$sn=wb_qzj($mgs,$z1,$y1);
	if(strlen($sn) != strlen("2a0b48b7a0aebc7c"))
	{
		echo '{"rs":1,"tip":"错误的红包链接。如有疑问请联系主人QQ：793991833","end":0}';
		die();
	}
	$url='http://119.29.130.244/a.php?sn='.$sn.'&user=w'.$wx_id;  
	$res = file_get_contents($url);  

	if(strstr($res,"下一个就是最大红包"))
	{
		echo '{"rs":1,"tip":"emmm，下一个就是最大红包了，块去动手去领吧~~~[结束]感谢各位大佬们的使用，温馨提示：您还可以复制此条消息到支付宝领取一个小红包哦~~~~~~\n瑜1丽香帆虹WJ15依骏","end":0}';
		die();
	}
	else
	{
		echo '{"rs":1,"tip":"'.$res.'\n如有疑问请联系主人QQ：793991833","end":0}';
	}
}

echo '{"rs":1,"tip":"你可以发送~使用方法~来查询如何使用\n如有疑问请联系主人QQ：793991833","end":0}';

?>