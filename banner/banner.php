<?php

include_once 'ts3admin.class.php';

$config = array("host" => "localhost",
				"query" => "10011",
				"port" => "9987",
				"login" => "",
				"password" => "");

$img = imagecreatefrompng('img/tlo.png');
$bialy = imagecolorallocate($img, 255, 255, 255);

$query = new ts3admin($config['host'], $config['query']);
if($query->getElement('success', $query->connect()))
{
	$query->login($config['login'],$config['password']);
    $query->selectServer($config['port']);

    $serverinfo = $query->getElement('data', $query->serverInfo());
    $bots = $serverinfo['virtualserver_queryclientsonline'];
	$users = $serverinfo['virtualserver_clientsonline'];
	$online = $users - $bots;

	imagettftext($img, 43, 0, 200, 55, $bialy, 'img/font/CaviarDreams.ttf', $serverinfo['virtualserver_name']);
	imagettftext($img, 43, 0, 505, 195, $bialy, 'img/font/CaviarDreams.ttf', date('H:i'));
	imagettftext($img, 43, 0, 535, 360, $bialy, 'img/font/CaviarDreams.ttf', ''.$online.'');
	imagettftext($img, 43, 0, 520, 525, $bialy, 'img/font/CaviarDreams.ttf', ''.$serverinfo['virtualserver_channelsonline'].'');
}

imagettftext($img, 43, 0, 505, 195, $bialy, 'img/font/CaviarDreams.ttf', date('H:i'));

header('Content-type: image-png');
imagepng($img);
imagedestroy($img);
?>