<?php
/*

        		iBot [v0.1 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website	 : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function welcomemsg()
{
	global $query;
	global $config;
	global $clients;

	$msg = fopen($config['welcomemsg']['msgpath'], "r");

	$clients['nowi'] = clientlist();

	if($config['welcomemsg']['data']=='1970-01-01 00:00:00')
	{
		$clients['actual'] = $clients['nowi'];
	}

	$clients['roznica'] = array_diff($clients['nowi'], $clients['actual']);


	if(count($clients['roznica']) != 0) 
	{
		foreach($clients['roznica'] as $clid) 
		{
			while(!feof($msg))
			{
				$line = fgets($msg);
				$message = convertmsg($line, $clid);
				$query->sendMessage(1, $clid, $message);
			}
		}
	}
		
	$clients['actual'] = $clients['nowi'];
}

function clientlist() 
{
	global $query;
		
	$clients['all'] = $query->getElement('data', $query->clientList());
		
	$clients['recent'] = array();
	foreach($clients['all'] as $client) 
	{
		if($client['client_type'] == 0) 
		{
			array_push($clients['recent'], $client['clid']);
		}
	}
	return $clients['recent'];
}

function convertmsg($msg, $clientid)
{
	global $query;

	$client = $query->getElement('data', $query->clientInfo($clientid));
	$serverinfo = $query->getElement('data', $query->serverInfo());

	$podmien = array(
			1 => array(1 => '[nickname]', 2 => $client['client_nickname']),
			2 => array(1 => '[connections]', 2 => $client['client_totalconnections']),
			3 => array(1 => '[client_first_connected]', 2 => date("d-m-Y", $client['client_created'])),
			4 => array(1 => '[client_last_connected]', 2 => date("d-m-Y", $client['client_lastconnected'])),
			5 => array(1 => '[server_name]', 2 => $serverinfo['virtualserver_name']),
			6 => array(1 => '[online]', 2 => $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline']),
			7 => array(1 => '[max]', 2 => $serverinfo['virtualserver_maxclients']));

	foreach($podmien as $new)
	{
		$msg = str_replace($new[1], $new[2], $msg);
	}
	return $msg;
}

?> 
