<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function ch_hour()
{
	global $query;
	global $config;

	$godzina = array();
	$godzina['channel_name'] = str_replace('[hour]', date('H:i'), $config['ch_hour']['name']);
	$query->channelEdit($config['ch_hour']['cid'], $godzina);

	unset($query);
	unset($config);
}

?>