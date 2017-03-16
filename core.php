<?php
/*

        		iBot [v0.3 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website	 : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

date_default_timezone_set('Europe/Warsaw');
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, 'UTF-8');

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

foreach (glob("functions/*.php") as $filename)
{
    include_once $filename;
}

$query = new ts3admin($teamspeak['host'], $teamspeak['tcp']);
if($query->getElement('success', $query->connect()))
{
	$query->login($teamspeak['login'],$teamspeak['password']);
    $query->selectServer($teamspeak['udp']);
    $query->setName($config['bot']['name']);
    $core = $query->getElement('data',$query->whoAmI());
    $query->clientMove($core['client_id'],$config['bot']['default_channel']);
    //sendCommand("servernotifyregister event=textprivate");
    $query->executeCommand("servernotifyregister event=textprivate");

    echo 'iBot version '.VERSION.'' . PHP_EOL;
	echo 'Zaladowano '.count($config['bot']['functions']).' funkcji' . PHP_EOL;
	echo 'Konsola bota: ' . PHP_EOL;

    while(true)
    {
    	$date = date('Y-m-d G:i:s');
    	for($i=0; $i<count($config['bot']['functions']); $i++)
    	{
    		if($config[$config['bot']['functions'][$i]]['enabled'])
    		{
    			if(can_do($date, $config[$config['bot']['functions'][$i]]['data'], convertinterval($config[$config['bot']['functions'][$i]]['interval'])))
				{
					$funkcja = $config['bot']['functions'][$i];
					$funkcja();
					$config[$config['bot']['functions'][$i]]['data'] = $date;
					break;
				}
    		}
    	}
    }
}

function convertinterval($interval) {
		
		$interval['hours'] = $interval['hours'] + $interval['days']*24;
		$interval['minutes'] = $interval['minutes'] + $interval['hours']*60;
		$interval['seconds'] = $interval['seconds'] + $interval['minutes']*60;
		
		return $interval['seconds'];
}

function can_do($date1, $date2, $interval) {
		
		$time2 = strtotime($date2);
		$time1 = strtotime($date1);
		$sum = $time1 - $time2;
		
		if($sum >= $interval) {
				$cando = true;
		} else {
				$cando  = false;
		}
		
		return $cando;
}

function isInGroup($usergroups,$group) {
    $diff = count(array_diff($usergroups, $group));
    
    if ($diff < count($usergroups)) {
        return true;
    }
    else {
        return false;
    }
}

function getgroupname($grupa)
{
    global $query;
    $groups = $query->getElement('data', $query->serverGroupList());
    $groupname = '';
    foreach($groups as $group)
    {
        if ($group['sgid'] == $grupa)
        {
            $groupname = $group['name'];
        }
    }

    return $groupname;
}

function getchannelgroupname($grupa)
{
    global $query;
    $groups = $query->getElement('data', $query->channelGroupList());
    $groupname = '';
    foreach($groups as $group)
    {
        if ($group['cgid'] == $grupa)
        {
            $groupname = $group['name'];
        }
    }

    return $groupname;
}

?>