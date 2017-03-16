<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function recordprotection()
{
	global $query;
	global $config;

	$clients = $query->getElement('data', $query->clientList("-uid -groups -voice"));
	foreach($clients as $client)
	{
		if($client['client_is_recording'])
		{
			$user_groups = explode(',', $client['client_servergroups']);
			if(!isInGroup($user_groups,$config['recordprotection']['aviable_groups']) &&
				!isInGroup($user_groups,$config['recordprotection']['admins']))
			{
				$msg = '\n
	                [COLOR=#990000][B]
	                =================================[ UWAGA ]=================================\n
	                                                            Zabrania się nagrywania na kanałach bez odpowiedniej grupy.\n
	                =========================================================================
	                [/B][/COLOR]';
				$query->sendMessage(1, $client['clid'], $msg);
				$query->clientKick($client['clid'], 'server', 'Nagrywanie');
			}
		}
	}

	unset($query);
	unset($config);
}