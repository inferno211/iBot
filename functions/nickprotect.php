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

function nickprotect()
{
	global $query;
	global $config;

	$list = $query->getElement('data', $query->clientList());
	foreach((array) $list as $clients)
	{
		for($i = 0; $i<count($config['nickprotect']['protected']); $i++)
		{
			if (strpos($clients['client_nickname'], $config['nickprotect']['protected'][$i]) !== false) 
			{
				$msg = file_get_contents($config['host_message']['msgpath'], "r");
				$msg = str_replace('[word]', $config['nickprotect']['protected'][$i], $msg);
				$query->clientKick($clients['clid'], 'server', $msg);
			}
		}
    }
}
?> 
