<?php
date_default_timezone_set('Europe/Warsaw');

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function getchannel()
{
	global $config;
	global $query;
	$clients = $query->getElement('data', $query->clientList('-groups -uid'));
	foreach($clients as $client)
	{
		$channel = $query->getElement('data', $query->channelList('-topic -limits'));
  		foreach($channel as $channels)
  		{
	  		if($client['cid']==$config['getchannel']['cid'])
	  		{

		 		$groups = explode(",", $client['client_servergroups']);
		 		if(isInGroup($groups, $config['getchannel']['groups']))
		 		{
		  			$cglist = $query->getElement('data', $query->channelGroupClientList());
		  			foreach((array)$cglist as $cg)
		  			{
		  				$canget = false;
						if($cg['cldbid'] == $client['client_database_id'] && !$canget)
						{
							if($cg['cgid']==$config['getchannel']['channel_group'])
							{
								$query->sendMessage(1, $client['clid'], 'Posiadasz już u nas kanał prywatny! Zostałeś na niego przeniesiony');
								$query->clientMove($client['clid'], $cg['cid']);
								$canget = false;
								break 3;
							}
							else
							{
								$canget = true;
							}
						}
						else
						{
							$canget = true;
						}
				
						if($channels['channel_topic']=='wolny' && $canget)
						{
							$query->sendMessage(1, $client['clid'], '\n[b]Zostałeś przeniesiony na Twój nowy kanał[/b].\n\nZostały stworzone [b]'.$config['getchannel']['sub_channels'].'[/b] podkanały.\n\nInstrukcja postępowania:\n1. Zmień hasło\n2. Zmień nazwe kanału\n3. Przeczytaj instrukcję obsługi kanału oraz zasadu użytkowania.\n\nŻyczymy miłych rozmów!');

							$query->clientMove($client['clid'], $channels['cid']);
							$query->setClientChannelGroup($config['getchannel']['channel_group'], $channels['cid'], $client['client_database_id']);
							$number = (integer)$channels['channel_name'];
							$desc = '[hr][center]Numer kanału: [b]'.$number.'[/b]
									Właściciel: [b][URL=client://'.$client['clid']."/".$client['client_unique_identifier'].']'.$client['client_nickname'].'[/URL][/b]
									Data założenia: [b]'.date("d.m.y", time()).'[/b]
									Administrator: [b]'.$config['bot']['name'].'[/b][/center][hr]';
							
							$query->channelEdit($channels['cid'], array('channel_name' => ''.$number.'. Kanal '.$client['client_nickname'].''));
							$time = strtotime("+5 days",time());
							$query->channelEdit($channels['cid'], array('channel_description' => $desc, 'channel_flag_maxclients_unlimited'=>1, 'channel_flag_maxfamilyclients_unlimited'=>1, 'channel_flag_maxfamilyclients_inherited'=>0, 'channel_topic'=>''.$time.''));
							for($i=0; $i<$config['getchannel']['sub_channels']; $i++)
							{
								$numer = $i;
								$numer++;
								$query->channelCreate(array('channel_flag_permanent' => 1, 'cpid' => $channels['cid'], 'channel_name' => ''.$numer.'. Podkanal', 'channel_flag_maxclients_unlimited'=>1, 'channel_flag_maxfamilyclients_unlimited'=>1));
							}
							break 3;
						}
		  			}
		  		}
		  		else
		  		{
			  		$query->sendMessage(1, $client['clid'], 'Nie posiadasz rang wymaganych do założenia kanału prywatnego!');
			  		$query->clientKick($client['clid'], 'channel');
			  		break;
		  		}
		  	} 
	  	}
	}
	unset($query);
    unset($config);
}

?> 
