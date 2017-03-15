<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function host_message()
{
	global $query;
	global $config;
	global $clients;

	$msg = file_get_contents($config['host_message']['msgpath'], "r");

	$query->serverEdit(array('virtualserver_hostmessage' => convert_host_message($msg), 'virtualserver_hostmessage_mode' => 2));

}

function convert_host_message($msg)
{
	global $query;

	$serverinfo = $query->getElement('data', $query->serverInfo());

	$podmien = array(
			1 => array(1 => '[connections]', 2 => $serverinfo['virtualserver_client_connections']),
			2 => array(1 => '[server_name]', 2 => $serverinfo['virtualserver_name']),
			3 => array(1 => '[online]', 2 => $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline']),
			4 => array(1 => '[max]', 2 => $serverinfo['virtualserver_maxclients']));

	foreach($podmien as $new)
	{
		$msg = str_replace($new[1], $new[2], $msg);
	}
	
	return $msg;
}


?> 
