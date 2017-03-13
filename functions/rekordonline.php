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

function rekordonline()
{
	global $query;
	global $config;

	$serverinfo = $query->getElement('data', $query->serverInfo());
	$bots = $serverinfo['virtualserver_queryclientsonline'];
	$users = $serverinfo['virtualserver_clientsonline'];
	$online = $users - $bots;

	$fp = fopen($config['rekordonline']['chachepath'], "r");
    $tekst = fread($fp, 4);
	$record = (int)$tekst;
	fclose($fp);
	if($record < $online)
	{
		$fp = fopen($config['rekordonline']['chachepath'], "w");
		fputs($fp, $online);
		fclose($fp);
	}
	$data = array();
	$data['channel_name'] = str_replace('[record]', $record, $config['rekordonline']['name']);
	$query->channelEdit($config['rekordonline']['cid'], $data);

	unset($query);
	unset($config);
}

?>