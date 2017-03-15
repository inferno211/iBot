<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function autopoke()
{
    global $query;
    global $config;
    global $interval;
    
    $cache   = array();
    $welcome = array();
    
    $users = $query->getElement('data', $query->clientList('-groups -voice -away -times'));
    
    $pokes  = array();
    $admins = array();
    
    foreach ($users as $client) 
    {
        if ($client['client_nickname'] != $config['bot']['name']) 
        {
            $user_groups = explode(',', $client['client_servergroups']);
            
            if (isInGroup($user_groups, $config['autopoke']['admins_groups']) && !in_array($client['clid'], $cache)) 
            {
                $admins[$client['clid']] = $user_groups;
            }
            
            if (array_key_exists($client['cid'], $config['autopoke']['messages']) && !isInGroup($user_groups, $config['autopoke']['admins_groups']) && !$client['client_is_talker']) 
            {
                
                $pokes[] = $client['cid'];
                
                //priv dla usera 
                if (!in_array($client['clid'], $cache)) 
                {
                    $msg = file_get_contents($config['autopoke']['user_poke_path'], "r");
                    $query->sendMessage(1, $client['clid'], $msg);
                    $cache[time() - 1] = $client['clid'];
                }
            }
        }
    }
    
    $counter = 0;
    foreach ($pokes as $poke) 
    {
        foreach ($admins as $clid => $admin) 
        {
            if (isInGroup($admin, $config['autopoke']['messages'][$poke]['groups'])) 
            {
                if (!in_array($clid, $cache)) 
                {
                    $cache[time() + $counter] = $clid;
                    $msg2 = file_get_contents($config['autopoke']['admin_poke_path'], "r");
                    $query->clientPoke($clid, $msg2);
                    $counter++;
                }
            }
        }
    }
    
    foreach ($cache as $time => $user) 
    {
        if (time() - $time > $interval) 
        {
            unset($cache[$time]);
        }
    }
    
    if (date('H') == '23') 
    {
        foreach ($welcome as $time => $user) 
        {
            if (time() - $time > 60 * 60 * 24) 
            {
                unset($welcome[$time]);
            }
        }
    }
    
    unset($query);
    unset($config);
    unset($interval);
    
    unset($cache);
    unset($welcome);
    
    unset($users);
    
    unset($pokes);
    unset($admins);
}

?> 
