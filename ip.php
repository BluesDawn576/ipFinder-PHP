<?php
header('Content-Type:application/json');
//引用必要的php文件
require 'ipdata/src/IpLocation.php';
require 'ipdata/src/ipdbv6.func.php';
use itbdw\Ip\IpLocation;
error_reporting(E_ALL^E_NOTICE^E_WARNING); //关闭php报错显示
$ip = $_GET["ip"];
if ($ip == null) { //获得客户端ip地址（ipv6优先）
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$ip = trim(current($ip));
	}
}
if (!isipv6($ip)) {
	echo json_encode(IpLocation::getLocation($ip), JSON_UNESCAPED_UNICODE) . "\n";
} else {
	echo query($ip);
}
function isipv6($s) { //硬核判断是否为ipv6地址
	return strpos($s, ":") !== false;
}
function query($ip) {
	$db6 = new ipdbv6("ipdata/src/ipv6wry.db");
	$code = 0;
	try {
		if (isipv6($ip)) {
			$result = $db6->query($ip);
		}
	}
	catch (Exception $e) {
		$result = array("disp" => $e->getMessage());
		$code = -400;
	}
	$i1 = $result["start"];
	$i2 = $result["end"];
	$disp = $result["disp"];
	$o1 = $result["addr"][0];
	$o2 = $result["addr"][1];
	$disp = str_replace("\"", "\\\"", $disp);
	$o1 = str_replace("\"", "\\\"", $o1);
	$o2 = str_replace("\"", "\\\"", $o2);
	$outstr = <<<EOL
{"code":$code,"data":{"ip":"$ip","range":{"start":"$i1","end":"$i2"},"country":"$o1","isp":"$o2","area":"$disp"}}
EOL;
	return $outstr;
}
?>