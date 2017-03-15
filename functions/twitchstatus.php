<?php

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function twitchstatus()
{
	global $query;
	global $config;

	$channels = $query->getElement('data', $query->channelList("-topic"));
	foreach($channels as $channel)
	{
		$check = strpos($channel['channel_topic'], "twitch=");
		if ($check !== false) 
		{
			$rozdzielenie = explode("=", $channel['channel_topic']);
			$login = $rozdzielenie[1];

			$usr = curl_init('https://api.twitch.tv/kraken/users/'.$login.'?client_id=46r4t0bxrq0h12bo4wxmlhp5d0d2oh');
			curl_setopt($usr, CURLOPT_RETURNTRANSFER, true);
			$u = curl_exec($usr);
			curl_close($usr);
			$pleaseUser = json_decode($u);
				
			$tw = curl_init('https://api.twitch.tv/kraken/streams/'.$login.'?client_id=46r4t0bxrq0h12bo4wxmlhp5d0d2oh');
			curl_setopt($tw, CURLOPT_RETURNTRANSFER, true);
			$w = curl_exec($tw);
			curl_close($tw);
			$pleaseStream = json_decode($w);

			$opis = '[center]\n';
					
			if($pleaseStream->stream != null)
			{
				$opis.= '\n[size=16][color=orange][b]'.$pleaseUser->display_name.'[/b][/color][/size]\n';
				$opis.= '[size=16][color=green][b]ONLINE[/b][/color][/size]\n';
				$opis.= '\n[size=16][b][url]' .$pleaseStream->stream->channel->url. '[/url][/b][/size]\n';
				$opis.= '\n[size=10][b]Obecnie gra w: \n[color=#5555ff]' .$pleaseStream->stream->channel->game. '[/color][/b][/size]\n';
				$opis.= '\n[size=10][b]Obecnie oglądających: \n[color=#5555ff]' .$pleaseStream->stream->viewers. '[/color][/b][/size]\n';
				$opis.= '\n[size=10][b]Obecne followy: \n[color=#5555ff]' .$pleaseStream->stream->channel->followers. '[/color][/b][/size]\n';
				$opis.= '\n[size=10][b]Łącznie posiada wyświetleń: \n[color=#5555ff]' .$pleaseStream->stream->channel->views. '[/color][/b][/size]\n';
				$opis.= '\n[size=10][b]Jego aktualny status: \n[color=#5555ff]' .$pleaseStream->stream->channel->status. '[/color][/b][/size]\n';
				$opis.= '\n[size=10][b]Ujęcie ze streama: \n\n[img]' .$pleaseStream->stream->preview->medium. '[/img][/b][/size]\n';
			}
			else
			{
				$opis.= '[size=16][b][color=orange]'.$pleaseUser->display_name.'[/color][/b][/size]\n[size=14][color=red][b]OFFLINE[/b][/color][/size]\n';
				$opis.= '\n[img]'.$pleaseUser->logo.'[/img]\n';
			}
			$opis.= '\n[/center]';
			
			$query->channelEdit($channel['cid'], array(
				'channel_description' => $opis
			));
		}
	}

	unset($query);
	unset($config);
}