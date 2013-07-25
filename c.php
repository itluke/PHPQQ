<?php
/**
 * @author luke
 * @date 2013.7.23
 * @function QQ群发问候消息 
 * 
 */
include "q1.php";
$mq = new qq();
$mq->login(853441442,'luke.web-14.com.');
$url='http://m.weather.com.cn/data/101040100.html';
$w=curl($url);
$weather=json_decode($w);
$weatherinfo=object_to_array($weather);
$info=$weatherinfo['weatherinfo'];
$str=$info['date_y'].','.$info['week'].'。'.$info['city'].'今天气温：'.$info['temp1'].'，天气：'.$info['weather1'].'有'.$info['wind1'].',风力：'.$info['fx1'].',穿衣建议：'.$info['index48_d'].'祝你生活愉快。From 李旭东。';
$f = array(858546653,2011988177,1121666010,991452169,554695100,270497459,906006734,1051907494,506466329,524630507,1481145809,281234510,1020170185,770791832,669214538);
foreach($f as $key){
	$mq->sendMsg($key,$str,$sid = 0);
}
function curl($url, $postFields = null)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FAILONERROR, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
}
 
if (is_array($postFields) && 0 < count($postFields))
{
$postBodyString = "";
$postMultipart = false;
foreach ($postFields as $k => $v)
{
if("@" != substr($v, 0, 1))//判断是不是文件上传
{
$postBodyString .= "$k=" . urlencode($v) . "&"; 
}
else//文件上传用multipart/form-data，否则用www-form-urlencoded
{
$postMultipart = true;
}
}
unset($k, $v);
curl_setopt($ch, CURLOPT_POST, true);
if ($postMultipart)
{
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
}
else
{
curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
}
}
$reponse = curl_exec($ch);
 
if (curl_errno($ch))
{
throw new Exception(curl_error($ch),0);
}
else
{
$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (200 !== $httpStatusCode)
{
throw new Exception($reponse,$httpStatusCode);
}
}
curl_close($ch);
return $reponse;
}
function object_to_array($obj)
{
$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
foreach ($_arr as $key => $val)
{
$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
$arr[$key] = $val;
}
return $arr;
}

?>