<?php
date_default_timezone_set('Europe/Warsaw');

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function channelchecker()
{
    
    global $config;
    global $query;
    global $number;
    global $main;
    global $mainclients;
    global $maintopic;
    
    $i = 0;
    
    $tablica = array();
    $channel = $query->getElement('data', $query->channelList('-topic -limits'));
    foreach ($channel as $channels) 
    {
        if ($channels['channel_topic'] != 'wolny') 
        {
            if ($channels['pid'] == $config['channelchecker']['pid'])
            {
                $main        = $channels['cid'];
                $mainclients = $channels['total_clients'];
                $maintopic   = $channels['channel_topic'];
                
                if ($channels['total_clients'] != 0) 
                {
                    $timestamp             = time();
                    $expiredate            = strtotime("+3 days", $timestamp); 
                    $data                  = array();
                    $data['channel_topic'] = $expiredate;
                    $query->channelEdit($channels['cid'], $data);
                }
                
                if ($channels['total_clients'] == 0) 
                {
                    if ($channels['channel_topic'] == '')
                    {
                        $timestamp             = time();
                        $expiredate            = strtotime("+1 days", $timestamp);
                        $data                  = array();
                        $data['channel_topic'] = $expiredate;
                        $query->channelEdit($channels['cid'], $data);
                    }
                    
                    $number    = (integer) $channels['channel_name'];
                    $date      = $channels['channel_topic'];
                    $date1     = strtotime($date);
                    
                    $todaydate = time();

                    if ($todaydate > (int) $date && $channels['channel_topic'] != '')
                    {
                        $data                             = array();
                        $data['channel_name']             = '' . $number . '. [Wolny]';
                        $data['channel_maxclients']       = 0;
                        $data['channel_maxfamilyclients'] = 0;
                        $data['channel_description']      = '';
                        $data['channel_topic']            = 'wolny';
                        $query->channelEdit($channels['cid'], $data);
                    }
                }
                $numer_kanalu = (integer) $channels['channel_name'];
                $tablica[$i]  = $numer_kanalu;
                
            }
            
            if ($channels['pid'] == $main)
            {
                if ($channels['total_clients'] != 0) 
                {
                    $timestamp             = time();
                    $expiredate            = strtotime("+3 days", $timestamp);
                    $data                  = array();
                    $data['channel_topic'] = $expiredate;
                    $query->channelEdit($main, $data);
                }
                
                if ($mainclients == 0) 
                {
                    $date      = $maintopic;
                    $date1     = strtotime($date);
                    $todaydate = time();
                    
                    if ($todaydate > (int) $date && $maintopic != '')
                    {
                        $query->channelDelete($channels['cid']);
                    }
                }
            }
            $i++;
        }
    }
    
    unset($config);
    unset($query);
    unset($number);
    unset($main);
    unset($mainclients);
    unset($maintopic);
}

?>
 
