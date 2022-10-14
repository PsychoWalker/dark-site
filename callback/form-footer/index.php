<?php
date_default_timezone_set('Europe/Moscow');
header('Content-Type: application/json; charset=utf-8');
$sharedDir = __DIR__ . '/../../data';
require_once $sharedDir . '/mail.php';

$number = date('U');
$str = "Заявка №".$number.":\n";
$str .= "ДАТА: ".date('c')."\n";
$str .= "Телефон: ".$_REQUEST['phone']."\n";

$subject = 'Заявка с сайта ' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);

custom_mail('online-ss4@yandex.ru', $subject, $str);

$fp = fopen($sharedDir . '/requests.txt', 'a+');
fwrite($fp, $str);
fclose($fp);

echo '{"result": "Заявка отправлена"}';
