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

			
					
			if($pleaseStream->stream != null)
			{
				$opis = '[center]\n';
				$opis.= '[size=14][color=orange][b]'.$pleaseUser->display_name.'[/b][/color][/size]\n\n';
				$opis.= '[B]Status:[/B] [color=green][b]ONLINE[/b][/color]\n';
				$opis.= '[B]Link do profilu:[/B] [URL='.$pleaseStream->stream->channel->url.']tutaj[/URL]\n';
				$opis.= '[B]Obecnie gra w:[/B] '.$pleaseStream->stream->channel->game.'\n';
				$opis.= '[B]Obecnie oglądających:[/B] '.$pleaseStream->stream->viewers.'\n';
				$opis.= '[B]Followy:[/B] '.$pleaseStream->stream->channel->followers.'\n';
				$opis.= '[B]Wyświetlenia:[/B] '.$pleaseStream->stream->channel->views.'\n';
				$opis.= '[B]Status:[/B] '.$pleaseStream->stream->channel->status.'\n';
				$opis.= '\n[B]Ujęcie z streama[/B]\n[img]' .$pleaseStream->stream->preview->medium. '[/img]';
				$opis.= '\n[/center]';
			}
			else
			{
				$opis = '[center]\n';
				$opis.= '[size=16][color=orange][b]'.$pleaseUser->display_name.'[/b][/color][/size]\n\n';
				$opis.= '[B]Link do profilu:[/B] [URL=http://www.twitch.tv/'.$login.']tutaj[/URL]\n';
				$opis.= '[B]Status:[/B] [color=red][b]OFFLINE[/b][/color]\n';
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