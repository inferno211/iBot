<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function adminlist()
{
	global $query;
	global $config;
	$adminsgroups = $config['adminlist']['groups'];
	
	$desc = '[center][size=15][b]Lista Administracji[/b][/size][/center]\n\n';
	foreach($adminsgroups as $group)
	{
		$group_name = getgroupname($group);
		$groupsclients = $query->getElement('data', $query->serverGroupClientList($group, $names = true));
		$clients = $query->getElement('data', $query->clientList("-uid -groups -times"));
		$desc.= '[center][size=12][b]' . $group_name . '[/b][/size][/center]\n';
		if (array_key_exists('client_nickname', $groupsclients[0]))
		{
			foreach($groupsclients as $groupclient)
			{
				foreach($clients as $client)
				{
					if ($client['client_unique_identifier'] == $groupclient['client_unique_identifier'])
					{
						$online = true;
						break;
					}
					else
					{
						$online = false;
					}
				}

					if ($online)
					{
						$desc.= '[size=10][url=client://' . $client['clid'] . '/' . $groupclient['client_unique_identifier'] . '][b]' . $groupclient['client_nickname'] . '[/b][/url] jest aktualnie [color=green][b]ONLINE[/b][/color][/size]\n';
						
					}
					else
					{
						$info = $query->getElement('data', $query->clientDbInfo($groupclient['cldbid']));
						$seconds = time() - $info['client_lastconnected'];

						$days    = floor($seconds / 86400);
						$hours   = floor(($seconds - ($days * 86400)) / 3600);
						$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
						$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
						
						$desc.= '[size=10][url=client://' . $client['clid'] . '/' . $groupclient['client_unique_identifier'] . '][b]' . $groupclient['client_nickname'] . '[/b][/url] jest aktualnie [color=red][b]OFFLINE[/b][/color] od '.$days.' dni, '.$hours.' godzin i '.$minutes.' minut[/size]\n';
					
					}
				}
			

			$desc.= '[hr]\n';
		}
		else
		{
			$desc.= '[size=10][b]Brak![/b][/size]\n[hr]\n';
		}
	}

	$channel = $query->channelInfo($config['adminlist']['channel']);
	if (strcmp($channel['data']['channel_description'], $desc) != 0)
	{
		$query->channelEdit($config['adminlist']['channel'], array(
			'channel_description' => $desc
		));
	}
}