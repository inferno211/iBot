<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function servername()
{
	global $query;
	global $config;
	global $clients;

	$query->serverEdit(array('virtualserver_name' => convertservername($config['servername']['servername'])));

}

function convertservername($msg)
{
	global $query;

	$serverinfo = $query->getElement('data', $query->serverInfo());

	$online = $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline'];

	$podmien = array(
			1 => array(1 => '[online]', 2 => $online),
			2 => array(1 => '[max]', 2 => $serverinfo['virtualserver_maxclients']),
			3 => array(1 => '[query]', 2 => $serverinfo['virtualserver_queryclientsonline']));

	foreach($podmien as $new)
	{
		$msg = str_replace($new[1], $new[2], $msg);
	}
	return $msg;
}


?> 
