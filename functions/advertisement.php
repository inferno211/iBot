<?php
/*

        		iBot [v1.0 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website	 : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function advertisement()
{
	global $query;
	global $config;

	$fp = fopen($config['advertisement']['msgpath'], "r");
	$ad = fread(fopen($config['advertisement']['msgpath'], "r"), filesize($config['advertisement']['msgpath']));
	fclose($fp);
	
	//Automatyczna wiadomosc
	$query->sendMessage(3, 1, $ad);
	
	unset($query);
	unset($config);
}

?>