<?php
/*

                iBot [v0.1 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website   : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';
include_once 'include/dbconnect.php';

function top10connectiontime()
{
    global $query;
    global $config;
    global $polaczenie;
    
    $users = $query->getElement('data', $query->clientList('-groups -voice -away -times -uid'));
    
    foreach ($users as $user) 
    {
        $client = $query->getElement('data', $query->clientInfo($user['clid']));
        $sql    = "SELECT * FROM top10connectiontime WHERE uid = '" . $user['client_unique_identifier'] . "' ";
        $result = mysqli_query($polaczenie, $sql);
        $u_data = mysqli_fetch_assoc($result);
        if ($u_data['id'] == null && $user['client_type'] != 1) 
        {
            $zapytanie = "INSERT INTO top10connectiontime (`uid`, `connectiontime`, `nick`, `clid`) VALUES ('" . $user['client_unique_identifier'] . "', '" . $client['connection_connected_time'] . "', '" . $user['client_nickname'] . "', '" . $user['clid'] . "')";
            $polaczenie->query($zapytanie);
        } 
        else 
        {
            if ($client['connection_connected_time'] > $u_data['connectiontime']) 
            {
                $zapytanie = "UPDATE top10connectiontime SET connectiontime='" . $client['connection_connected_time'] . "' WHERE uid='" . $user['client_unique_identifier'] . "'";
                $polaczenie->query($zapytanie);
            }
        }
    }
    
    $desc = '[center][size=15][b]TOP 10 Najdluzszych polaczen z serwerem[/b][/size][/center]\n\n';
    $desc .= '[center]';
    $sql    = "SELECT * FROM top10connectiontime ORDER BY connectiontime DESC LIMIT 10";
    $result = mysqli_query($polaczenie, $sql);
    $number = 1;
    
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
    {
        $init    = $row['connectiontime'] / 1000;
        $hours   = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;
        
        $desc .= '' . $number . '. [URL=client://0/' . $row['uid'] . ']' . $row['nick'] . '[/URL] - [b]' . $hours . ' godzin ' . $minutes . ' minut i ' . $seconds . ' sekund[/b] \n\n';
        $number++;
    }
    $desc .= '[/center]';
    $query->channelEdit($config['top10connectiontime']['channel'], array(
        'channel_description' => $desc
    ));
    
}

?> 
