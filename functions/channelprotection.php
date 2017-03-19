<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function channelprotection()
{
	global $config;
	global $query;
	$clients = $query->getElement('data', $query->clientList('-groups'));
	foreach($clients as $client)
	{
		$channel = $query->getElement('data', $query->channelInfo($client['cid']));
		$check = strpos($channel['channel_topic'], "protect=");
		if ($check !== false)
		{
			$rozdzielenie = explode("=", $channel['channel_topic']);
			$idgrupy = array($rozdzielenie[1]);

			$groups = explode(",", $client['client_servergroups']);
			if(!isInGroup($groups, $idgrupy) && !isInGroup($groups, $config['channelprotection']['admingroup']))
			{
				$query->clientKick($client['clid'], "channel", "Nie masz uprawnień by przebywać na tym kanale!");
				$query->sendMessage(1, $client['clid'], '[COLOR=#990000][B]Nie masz uprawnień by przebywać na tym kanale![/B][/COLOR]');
			}
		}
	}

	unset($query);
    unset($config);
}

?>