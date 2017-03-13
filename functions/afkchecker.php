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


function afkchecker()
{
	global $query;
	global $config;
	global $clientchannel;
	
	$users = $query->getElement('data',$query->clientList('-groups -voice -away -times -uid'));
	
	foreach ($users as $client)
	{
		$idle = $client['client_idle_time'];
		$time = $config['afkchecker']['afktime'];
		$group = $config['afkchecker']['afkgroup'];
		if($client['client_type'] == 0)
		{
			if($idle>$time*60000 || $client['client_input_muted']==1 || $client['client_output_muted']==1 || $client['client_away']==1)
		    {
				$query->serverGroupAddClient($group, $client['client_database_id']);
				if($config['afkchecker']['move_afk'])
				{
					$clientchannel[$client['client_unique_identifier']] = $client['cid'];
					$query->clientMove($client['clid'], $config['afkchecker']['afk_channel']);
				}
			}
			else
			{
				$query->serverGroupDeleteClient($group, $client['client_database_id']);
				if($config['afkchecker'])
				{
					$query->clientMove($client['clid'], $clientchannel[$client['client_unique_identifier']]);
					unset($clientchannel[$client['client_unique_identifier']]);
				}
			}
		}
	}
	
	unset($query);
	unset($config);
	unset($users);
	unset($idle);
	unset($time);
	unset($group);
}

?> 

