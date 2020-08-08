<?php
/**
 *	Public name: 最新IP定位系统
 *	Public phper: 污橘
 *	Public date: 2019/11/23
 */
/**
 * Fix name: 访客IP记录定位系统
 * Fix phper: 泽宇大大
 * Fix date: 2020/08/08
 * NOTE: 这新冠疫情整的我都胖了
 * GitHub: 
 */
error_reporting(0);
header("content-type:text/html;charset=utf-8");
include 'assets/db.class.php';
include 'config.php';
DB::connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pwd'], $dbconfig['dbname'], $dbconfig['port']);
$data = DB::get_row("SELECT url,sj,title FROM ip_config WHERE Id = 1");
function getIP()
{
	global $ip;
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if (getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if (getenv("REMOTE_ADDR"))
    $ip = getenv("REMOTE_ADDR");
  else if ($_SERVER['HTTP_TOKEN'])
    $ip =$_SERVER['HTTP_TOKEN'];
	else $ip = "NULL";
	return $ip;
}
$ip = getIP();
$sj = date('Y-m-d h:i:s');


if ($data['sj'] == 'moren'){
  /*
  你也可以在(http://lbsyun.baidu.com/apiconsole/key/create#/home)获取你自己的ak
  在下面填写你自己的ak
*/
  $ak = '';//请您在这里填写自己的ak
  //下面会自动获取我官网发布的最新公开ak
  if (empty($ak)){
    $deak=file_get_contents('http://zeyudada.cn/ak.php?domain='.urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]));
    function encrypt($string,$operation,$key='')
    {
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D')
        {
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
            {
                return substr($result,8);
            }
            else
            {
                return'';
            }
        }
        else
        {
            return str_replace('=','',base64_encode($result));
        }
    }
    $ak = encrypt($deak,'D','zeyunb666');

  //$ak = 'AMXeiw9ngfLYaN1MHLLMo0GL6IDiarUK';
  }

$json = file_get_contents('http://api.map.baidu.com/location/ip?ak='.$ak.'&coor=bd09ll&ip=' . $ip);

$redata = json_decode($json, true);
$address = $redata['address'];
$x = $redata['content']['point']['x'];
$y = $redata['content']['point']['y'];
$src = '<li class="list-group-item">IP地址：'.$ip.'</li><li class="list-group-item">地址：'.$address.'</li><li class="list-group-item">X坐标：'.$x.'<br>Y坐标：'.$y.'</li><li class="list-group-item">'.$_SERVER['HTTP_USER_AGENT'].'</li>';
}else{
$r = file_get_contents($data['sj'] . $ip);
$src = '<li class="list-group-item">IP地址：'.$ip.'</li><li class="list-group-item">'.$r.'</li><li class="list-group-item">'.$_SERVER['HTTP_USER_AGENT'].'</li>';
}

//加上访问信息
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
$url = $http_type.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] ;

$resrc = $src.'<li class="list-group-item">访问的地址：'.$url.'</li><li class="list-group-item">来源地址（为空就是手动输入）：'.$_SERVER['HTTP_REFERER'].'</li><li class="list-group-item">当前请求的Accept头部的内容：'.$_SERVER['HTTP_ACCEPT'].'</li>';


DB::query("INSERT INTO ip_list (ip, info,`time`) VALUES ('$ip', '$resrc','$sj')");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $data; ?></title>
</head>
<body><iframe src="<?php echo $data['url'] ?>" width="100%" height="100%" frameborder="0"></iframe></body>
</html>