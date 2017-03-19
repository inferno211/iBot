<?php
include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function channelinfo()
{
	global $config;
    global $query;

	$stats['suma'] = 0;
	$stats['wolnych'] = 0;
	$stats['zajetych'] =0;

	$firs_wolny = true;
	$wolne_desc = '[COLOR=GREEN][B]Lista wolnych kanałów:[/B][/COLOR]';

	$firs_zajety = true;
	$zajety_desc = '[COLOR=RED][B]Lista kanałów do usunięcia w ciągu 24h:[/B][/COLOR]';

	$channel = $query->getElement('data', $query->channelList('-topic -limits'));
	foreach($channel as $channels)
	{
		if($channels['pid'] == $config['channelinfo']['pid'])
		{
			$number = (integer)$channels['channel_name'];
			$stats['suma']++;
			if($channels['channel_topic'] == 'wolny')
			{
				$stats['wolnych']++;
				if(!$firs_wolny)
				{
					$wolne_desc.= ', '.$number;
				}
				else
				{
					$firs_wolny = false;
					$wolne_desc.= ' '.$number;
				}
			}
			else
			{
				$stats['zajetych']++;
				$waznydo = (int)$channels['channel_topic'];
				if(($waznydo - time()) < (24 * 60 * 60))
				{
					if(!$firs_zajety)
					{
						$zajety_desc.= ', '.$number;
					}
					else
					{
						$firs_zajety = false;
						$zajety_desc.= ' '.$number;
					}
				}
			}
		}
	}

	$desc = "[B]Kanałów prywatnych:[/B] ".$stats['suma']."\n";
	$desc .= "[B]Kanałów prywatnych zajętych:[/B] ".$stats['zajetych']."\n";
	$desc .= "[B]Kanałów prywatnych wolnych:[/B] ".$stats['wolnych']."\n";
	$desc .= "\n".$wolne_desc;
	$desc .= "\n\n".$zajety_desc;

	$query->channelEdit($config['channelinfo']['channel'], array('channel_description' => $desc));

	unset($config);
    unset($query);
}
?>