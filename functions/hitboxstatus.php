<?php

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function hitboxstatus()
{
	global $query;
	global $config;

	$channels = $query->getElement('data', $query->channelList("-topic"));
	foreach($channels as $channel)
	{
		$check = strpos($channel['channel_topic'], "hitbox=");
		if ($check !== false) 
		{
			$rozdzielenie = explode("=", $channel['channel_topic']);
			$login = $rozdzielenie[1];

			$usr = curl_init('https://api.hitbox.tv/user/'.$login);
			curl_setopt($usr, CURLOPT_RETURNTRANSFER, true);
			$u = curl_exec($usr);
			curl_close($usr);
			$pleaseUser = json_decode($u);

			if($pleaseUser->is_live != 0)
			{
				$opis = '[center]\n';
				$opis.= '[size=14][color=orange][b]'.$pleaseUser->user_name.'[/b][/color][/size]\n\n';
				$opis.= '[B]Status:[/B] [color=green][b]ONLINE[/b][/color]\n';
				$opis.= '[B]Link do profilu:[/B] [URL=http://hitbox.tv/'.$login.']tutaj[/URL]\n';
				$opis.= '[B]Followy:[/B] '.$pleaseUser->followers.'\n';
				$opis.= '\n[/center]';
			}
			else
			{
				$opis = '[center]\n';
				$opis.= '[size=14][color=orange][b]'.$pleaseUser->user_name.'[/b][/color][/size]\n\n';
				$opis.= '[B]Status:[/B] [color=red][b]OFFLINE[/b][/color]\n';
				$opis.= '[B]Link do profilu:[/B] [URL=http://hitbox.tv/'.$login.']tutaj[/URL]\n';
				$opis.= '[B]Followy:[/B] '.$pleaseUser->followers.'\n';
				$opis.= '\n[/center]';
			}

			$query->channelEdit($channel['cid'], array(
				'channel_description' => $opis
			));
		}
	}
	unset($query);
	unset($config);
}