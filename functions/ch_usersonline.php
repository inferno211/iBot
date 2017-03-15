<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function ch_usersonline()
{
	global $query;
	global $config;

	$serverinfo = $query->getElement('data', $query->serverInfo());
	$bots = $serverinfo['virtualserver_queryclientsonline'];
	$users = $serverinfo['virtualserver_clientsonline'];
	$online = $users - $bots;

	$data = array();
	$data['channel_name'] = str_replace('[online]',$online, $config['ch_usersonline']['name']);
	$query->channelEdit($config['ch_usersonline']['cid'], $data);

	unset($query);
	unset($config);
}

?>