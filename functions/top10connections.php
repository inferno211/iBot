<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';
include_once 'include/dbconnect.php';

function top10connections()
{
    global $query;
    global $config;
    global $polaczenie;
    
    $users = $query->getElement('data', $query->clientList('-groups -voice -away -times -uid'));
    
    foreach ($users as $user) 
    {
        $client = $query->getElement('data', $query->clientInfo($user['clid']));
        $sql    = "SELECT * FROM top10connections WHERE uid = '" . $user['client_unique_identifier'] . "' ";
        $result = mysqli_query($polaczenie, $sql);
        $u_data = mysqli_fetch_assoc($result);
        if ($u_data['id'] == null && $user['client_type'] != 1) 
        {
            $zapytanie = "INSERT INTO top10connections (`uid`, `connections`, `nick`, `clid`) VALUES ('" . $user['client_unique_identifier'] . "', '" . $client['client_totalconnections'] . "', '" . $user['client_nickname'] . "', '" . $user['clid'] . "')";
            $polaczenie->query($zapytanie);
        } 
        else 
        {
            if ($client['client_totalconnections'] > $u_data['connections']) 
            {
                $zapytanie = "UPDATE top10connections SET connections='" . $client['client_totalconnections'] . "' WHERE uid='" . $user['client_unique_identifier'] . "'";
                $polaczenie->query($zapytanie);
            }
        }
    }
    
    $desc = '[center][size=15][b]TOP 10 Ilosci polaczen z serwerem[/b][/size][/center]\n\n';
    $desc .= '[center]';
    $sql    = "SELECT * FROM top10connections ORDER BY connections DESC LIMIT 10";
    $result = mysqli_query($polaczenie, $sql);
    $number = 1;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
    {
        $desc .= '' . $number . '. [URL=client://0/' . $row['uid'] . ']' . $row['nick'] . '[/URL] polaczyl sie z serwerem [b]' . $row['connections'] . '[/b] razy \n\n';
        $number++;
    }
    $desc .= '[/center]';
    $query->channelEdit($config['top10connections']['channel'], array('channel_description' => $desc));
    
    unset($query);
    unset($config);
    unset($polaczenie);
}

?> 
