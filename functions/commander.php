<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function commander()
{
	global $query;
	global $config;

	$channels = $query->getElement('data', $query->channelList("-topic"));
	foreach($channels as $channel)
	{
		if($channel['channel_topic'] == 'commander')
		{
			$wiadomosci = $query->readChatMessage('textchannel', false, $channel['cid']);
			if(isset($wiadomosci['success']) && strlen($wiadomosci['data']['msg']) > 2)
			{
				if($wiadomosci['success'] == 1)
				{
					if($wiadomosci['data']['msg']{0} == '!')
					{
						$wpisana_komenda = substr($wiadomosci['data']['msg'], 1);
						$command_arguments = explode(" ", $wpisana_komenda);

						$user = $query->getElement('data', $query->clientInfo($wiadomosci['data']['invokerid']));
						$groups = explode(",", $user['client_servergroups']);

						$client['client_nickname'] = $wiadomosci['data']['invokername'];
						$client['client_uid'] = $wiadomosci['data']['invokeruid'];
						$client['client_clid'] = $wiadomosci['data']['invokerid'];
						$client['client_cmd'] = $command_arguments[0];
						$client['client_params'] = $wpisana_komenda;

						for($i=0; $i<count($config['commander']['commands_list']); $i++)
						{
							if($client['client_cmd'] == $config['commander']['commands_list'][$i])
							{
								if(isInGroup($groups, $config['commander']['commands'][$config['commander']['commands_list'][$i]]['allowed_groups']))
								{
									echo 'Użytkownik '.$client['client_nickname'].' (clid: '.$client['client_clid'].') wywołał komendę: '.$client['client_cmd'].'' . PHP_EOL;
									$funkcja = $wpisana_komenda;
									$funkcja($client['client_clid'], $client['client_uid'], $client['client_nickname'], $client['client_params']);
									break;
								}
							}
						}
					}
				}
			}
		}
	}

	unset($query);
	unset($config);
}
?>