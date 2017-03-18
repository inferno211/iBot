<?php
date_default_timezone_set('Europe/Warsaw');

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';
include_once 'include/dbconnect.php';

function premiumchecker()
{
    global $query;
    global $config;
    global $polaczenie;

    $users = $query->getElement('data', $query->clientList('-groups -uid'));

    foreach ($users as $user) 
    {
    	$sql    = "SELECT * FROM premium WHERE uid = '".$user['client_unique_identifier']."' ";
    	$result = mysqli_query($polaczenie, $sql);
    	if(mysqli_num_rows($result) != 0)
    	{
    		$groups = explode(",", $user['client_servergroups']);
    		$u_data = mysqli_fetch_assoc($result);
    		if($u_data['endtime'] < time())
    		{
    			if(isInGroup($groups, $config['premiumchecker']['premiumgroup']))
    			{
    				foreach ($config['premiumchecker']['premiumgroup'] as $premium_groups)
    				{
    					$query->serverGroupDeleteClient($premium_groups, $user['client_database_id']);
    				}
    				$query->sendMessage(1, $user, '\n[COLOR=#990000][B]Twój okres konta premium minął![/B][/COLOR]');
    			}
    		}
    		else
    		{
    			if(!isInGroup($groups, $config['premiumchecker']['premiumgroup']))
    			{
    				foreach ($config['premiumchecker']['premiumgroup'] as $premium_groups)
    				{
    					$query->serverGroupAddClient($premium_groups, $user['client_database_id']);
    				}
                    mysqli_query($polaczenie, "UPDATE premium SET nick = '".$user['client_nickname']."' WHERE uid = '".$user['client_unique_identifier']."'");
                    
    				$query->sendMessage(1, $user, '\n[COLOR=#990000][B]Nadano rangę premium![/B][/COLOR]\nWażność do '.gmdate("Y-m-d H:i:s", $u_data['endtime']).'.');
    			}
    		}
    	}
        else
        {
            $groups = explode(",", $user['client_servergroups']);
            if(isInGroup($groups, $config['premiumchecker']['premiumgroup']))
            {
                foreach ($config['premiumchecker']['premiumgroup'] as $premium_groups)
                {
                    $query->serverGroupDeleteClient($premium_groups, $user['client_database_id']);
                }
                $query->sendMessage(1, $user, '\n[COLOR=#990000][B]Twój okres konta premium minął![/B][/COLOR]');
            }
        }
    }

    unset($query);
    unset($config);
    unset($polaczenie);
}

?> 
