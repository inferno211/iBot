<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function check($clid, $uid, $name, $params)
{
    global $query;
    global $config;
    
    $query->sendMessage(1, $clid, $config['commander']['commands']['check']['output']);
    channelchecker();

    unset($query);
    unset($config);
}

?> 