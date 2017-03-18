<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';
include_once 'include/dbconnect.php';

function premiumlist()
{
    global $query;
    global $config;
    global $polaczenie;

    $desc = '[center][size=15][b]LISTA UŻYTKOWNIKÓW PREMIUM[/b][/size][/center]\n\n';
    $desc .= '[center]';
    $sql    = "SELECT * FROM premium";
    $result = mysqli_query($polaczenie, $sql);
    $number = 1;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
    {
        if($row['endtime'] > time())
        {
        	$desc .= ''.$number.'. [URL=client://0/'.$row['uid'].']'.$row['nick'].'[/URL] aktywny do [b]'.gmdate("Y-m-d H:i:s", $row['endtime']).'[/b]\n';
        	$number++;
        }
    }
    $desc .= '[/center]';
    $query->channelEdit($config['premiumlist']['channel'], array('channel_description' => $desc));

    unset($query);
    unset($config);
    unset($polaczenie);
}

?> 