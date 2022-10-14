<?php

function readDB(){
	$filesize = filesize(__DIR__ . '/ipblock.bin');
	$fp = fopen(__DIR__ . '/ipblock.bin', 'rb');
	$binary = fread($fp, $filesize);
	fclose($fp);
	return unserialize($binary);
}

function writeDB($arr){
	$fp = fopen(__DIR__ . '/ipblock.bin', 'wb');
	ftruncate($fp, 0);
	fwrite($fp, serialize($arr));
	fclose($fp);
}


function checkIP($ip){
	$num = 0;
  if (in_array($ip, ['127.0.0.1', '109.194.79.165'])) {
    return $num;
  }
  $arr = readDB();
	if(array_key_exists($ip, $arr)){
		foreach($arr[$ip] as $k=>$v){
			if($v<(date('U')-84400)){
				unset($arr[$ip][$k]);
			}
		}
		$num = count($arr[$ip]);
		$arr[$ip][] = date('U');
		writeDB($arr);
	}else{
		$arr[$ip] = array();
		$arr[$ip][] = date('U');
		writeDB($arr);
	}
	return $num;
}


function getIp() {
  $keys = [
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'REMOTE_ADDR'
  ];
  foreach ($keys as $key) {
    if (!empty($_SERVER[$key])) {
      $ips = explode(',', $_SERVER[$key]);
      $ip = trim(end($ips));
      if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
      }
    }
  }
}
