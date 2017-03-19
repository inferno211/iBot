<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function meeting($clid, $uid, $name, $params)
{
    global $query;
    global $config;
    
    $query->sendMessage(1, $clid, $config['commander']['commands']['meeting']['output']);

    $clients = $query->getElement('data', $query->clientList('-groups'));
    $admin = $query->getElement('data', $query->clientInfo($clid));
    foreach($clients as $client)
    {
        if($client['clid'] != $clid)
        {
            $groups = explode(",", $client['client_servergroups']);
            if(isInGroup($groups,$config['commander']['commands']['meeting']['groups']))
            {
                $query->clientMove($client['clid'], $admin['cid']);
                $query->sendMessage(1, $client['clid'], 'Administrator [B][URL=client://'.$clid.'/'.$uid.']'.$name.'[/URL][/B] przeniósł Cię automatycznie do siebie na kanał.');
            }
        }
    }

    unset($query);
    unset($config);
}

?> 
