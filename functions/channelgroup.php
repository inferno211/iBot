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

function channelgroup()
{
	global $query;
	global $config;

	$array = $config['channelgroup']['channels'];

  	$clients = $query->getElement('data', $query->clientList());
  	foreach($clients as $client)
  	{
		foreach($config['channelgroup']['channels'] as $key => $value) 
		{
	    	if($client['cid']==$key)
			{
				$clientinfo = $query->getElement('data', $query->clientInfo($client['clid']));
				foreach((array)$clientinfo['client_servergroups'] as $groups)
				{
					$query->serverGroupAddClient($value, $clientinfo['client_database_id']);
				}
			}
		}
  	}

	unset($query);
	unset($config);
}

?> 
