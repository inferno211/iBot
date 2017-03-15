<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function ch_channels()
{
	global $query;
	global $config;

	$serverinfo = $query->getElement('data', $query->serverInfo());

	$kanaly = array();
	$kanaly['channel_name'] = str_replace('[channels]', $serverinfo['virtualserver_channelsonline'], $config['ch_channels']['name']);
	$query->channelEdit($config['ch_channels']['cid'], $kanaly);

	unset($query);
	unset($config);
}

?>