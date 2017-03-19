<?php
/*

        		iBot [v0.6 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website	 : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

define('VERSION', '0.6 Beta');

$teamspeak['host'] 						= '127.0.0.1'; // Host TS3
$teamspeak['udp'] 						= '9987'; // Port TS3
$teamspeak['tcp'] 						= '10011'; // Port Query TS3
$teamspeak['login'] 					= ''; // Login Query TS3
$teamspeak['password'] 					= ''; // Hasło Query TS3

$db['host'] 							= '127.0.0.1'; // Host DB
$db['login'] 							= ''; // Login DB
$db['password'] 						= ''; // Hasło DB
$db['database'] 						= ''; // Baza danych

$config['bot']['name'] 					= "iBot @ BOT"; // Nazwa bota na serwerze
$config['bot']['default_channel'] 		= 19; // kanał na jakim ma siedzieć bot

// Lista aktywowanych funkcji
$config['bot']['functions'] 			= array(
										'advertisement', 
										'welcomemsg', 
										'servername', 
										'host_message', 
										'autoregister', 
										'adminlist', 
										'ch_usersonline', 
										'ch_channels',
										'ch_hour',
										'rekordonline',
										'channelgroup',
										'nickprotect',
										'afkchecker',
										'autopoke',
										'top10connections',
										'top10connectiontime',
										'getchannel',
										'channelchecker',
										'checkupdate',
										'group_online',
										'twitchstatus',
										'recordprotection',
										'hitboxstatus',
										'premiumchecker',
										'premiumlist',
										'channelprotection',
										'channelinfo',
										'commander');

/*
ADVERTISEMENT
Reklama co x czasu
	msgpath - plik reklamy
*/
$config['advertisement']['enabled'] 	= false;
$config['advertisement']['msgpath'] 	= 'messages/advertisement.txt';
$config['advertisement']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 30,'seconds' => 0);
$config['advertisement']['data'] 		= '1970-01-01 00:00:00';

/*
WELCOME MESSAGE
Wiaomość powitalna przy połączeniu
	msgpath - plik wiadomości
*/
$config['welcomemsg']['enabled'] 		= true;
$config['welcomemsg']['msgpath'] 		= 'messages/welcome_message.txt';
$config['welcomemsg']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 1);
$config['welcomemsg']['data'] 			= '1970-01-01 00:00:00'; 

/*
AUTOMATIC HOST MESSAGE
Automatyczne powiadomienie po wejsciu na serwer
	msgpath - plik wiadomości
*/
$config['host_message']['enabled'] 		= true;
$config['host_message']['msgpath'] 		= 'messages/host_message.txt';
$config['host_message']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['host_message']['data'] 		= '1970-01-01 00:00:00'; 

/*
AUTOMATIC SERVER NAME
Automatyczna nazwa serwera
	servername - nazwa serwera gdzie [online] to liczba online użytkowników, a [max] to ilość slotów
*/
$config['servername']['enabled'] 		= true;
$config['servername']['servername'] 	= '[PTSRP.com.pl]Polski Trans Serwer [[online]/[max]]';
$config['servername']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['servername']['data'] 			= '1970-01-01 00:00:00';

/*
AUTOMATIC REGISTER
Automatyczna rejestracja po x minutach
	group - grupa zarejestrowanych
	time - po ilu minutach nadać
*/
$config['autoregister']['enabled'] 		= false;
$config['autoregister']['group'] 		= 23;
$config['autoregister']['time'] 		= 30;
$config['autoregister']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['autoregister']['data'] 		= '1970-01-01 00:00:00';

/*
AUTOMATIC ADMIN LIST
Lista administracji, kto jest i kiedy ostatnio był online
	channel - kanał
	groups - grupy do wyświetlenia
*/
$config['adminlist']['enabled'] 		= true;
$config['adminlist']['channel'] 		= 464;
$config['adminlist']['groups'] 			= array(13,39,40,41,43,42);
$config['adminlist']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['adminlist']['data'] 			= '1970-01-01 00:00:00'; 

/*
CHANNEL NAME: USERS ONLINE
Liczba użytkowników w nazwie danego kanału
	cid - numer kanału
	name - nazwa kanału
*/
$config['ch_usersonline']['enabled'] 	= true;
$config['ch_usersonline']['cid'] 		= 461;
$config['ch_usersonline']['name'] 		= '[cspacer]·٠•● ONLINE: [online] ●•٠·';
$config['ch_usersonline']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['ch_usersonline']['data'] 		= '1970-01-01 00:00:00'; 

/*
CHANNEL NAME: HOUR
Godzina w nazwie danego kanału
	cid - numer kanału
	name - nazwa kanału
*/
$config['ch_hour']['enabled'] 			= true;
$config['ch_hour']['cid'] 				= 460;
$config['ch_hour']['name'] 				= '[cspacer]·٠•● GODZINA: [hour] ●•٠·';
$config['ch_hour']['interval'] 			= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['ch_hour']['data'] 				= '1970-01-01 00:00:00';

/*
CHANNEL NAME: CHANNELS
Liczba kanałów w nazwie danego kanału
	cid - numer kanału
	name - nazwa kanału
*/
$config['ch_channels']['enabled'] 		= true;
$config['ch_channels']['cid'] 			= 463;
$config['ch_channels']['name'] 			= '[cspacer]·٠•● ILOŚĆ KANAŁÓW: [channels] ●•٠·';
$config['ch_channels']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['ch_channels']['data'] 			= '1970-01-01 00:00:00';

/*
REKORD USERS ON THE SERVER
Rekord użytkowników online na serwerze w nazwie kanału
	cid - numer kanału
	name - nazwa kanału gdzie [record] to aktualny rekord
	cachepath - gdzie przechowywać rekord
*/
$config['rekordonline']['enabled'] 		= true;
$config['rekordonline']['cid'] 			= 462;
$config['rekordonline']['name'] 		= '[cspacer]·٠•● REKORD ONLINE: [record] ●•٠·';
$config['rekordonline']['chachepath'] 	= 'cache/onlinerecord.txt';
$config['rekordonline']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['rekordonline']['data'] 		= '1970-01-01 00:00:00';

/*
ADD RANK WHEN USER JOIN THE CHANNEL
Nadaje daną rangę po wejściu na kanał
	channels - [kanał] => [grupa]
*/
$config['channelgroup']['enabled'] 		= false;
$config['channelgroup']['channels'] 	= array(2076 => 283, 2077 => 284);
$config['channelgroup']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 1);
$config['channelgroup']['data'] 		= '1970-01-01 00:00:00'; 

/*
BLOCK INAPPROPIATE WORDS IN NICKNAMES
Blokuje obraźliwe lub niedozwolone słowa w loginach
	protected - lista zakazanych słów w loginach
	msgpath - wiadomość dla użytkownika z złym loginem
*/
$config['nickprotect']['enabled'] 		= true;
$config['nickprotect']['protected'] 	= array('huj', 'cipa', 'chuj', 'jebać', 'jebac', 'kurwa', 'Zarzad', 'Operator TS', 'Admin', 'JuniorAdmin', 'Moderator');
$config['nickprotect']['msgpath'] 		= 'messages/nickprotect.txt';
$config['nickprotect']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 1);
$config['nickprotect']['data'] 			= '1970-01-01 00:00:00';

/*
AUTOMATIC ADD AFK RANK AND MOVE TO SPECIFIC CHANNEL
Automatyczne nadawanie rangi AFK i przenoszenie na kanał prywatny.
	afkgroup - id grupy afk
	move_afk - czy przenosić gdy będzie afk
	afk_channel - id kanału na który ma przenieść
	afktime - po ilu minutach nadawać rangę afk
*/
$config['afkchecker']['enabled'] 		= false;
$config['afkchecker']['afkgroup'] 		= 202;
$config['afkchecker']['move_afk'] 		= false;
$config['afkchecker']['afk_channel'] 	= 1909;
$config['afkchecker']['afktime'] 		= 30;
$config['afkchecker']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5);
$config['afkchecker']['data'] 			= '1970-01-01 00:00:00';

/*
AUTO POKE
Powiadamia dane grupy gdy ktoś wejdzie na wskazany kanał
	admins_groups - wszystkie grupy administratorów
	messages - 	[kanał] => array(     'groups' => array([po przecinku id grup do powiadomienia])),
	admin_poke_path - wiadomość dla admina
	user_poke_path - wiadomość dla użytkownika
*/
$config['autopoke']['enabled'] 			= true;
$config['autopoke']['admins_groups'] 	= array(13,39,40,41,42,43);
$config['autopoke']['messages'] 		= array(
							        	119 => array(     'groups' => array(13,39,40,41,42,43)),

							        	118 => array(     'groups' => array(13,39,40,41,42,43)),
									
									    121 => array(     'groups' => array(13,39,40,41,42,43))
												);
$config['autopoke']['admin_poke_path'] 	= 'messages/autopoke_admin.txt';
$config['autopoke']['user_poke_path'] 	= 'messages/autopoke_user.txt';
$config['autopoke']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 5);
$config['autopoke']['data'] 			= '1970-01-01 00:00:00';

/*
TOP 10 CONNECTIONS
Top 10 połączeń.
	channel - id kanału na którym ma pokazywać topkę
*/
$config['top10connections']['enabled'] 	= true;
$config['top10connections']['channel'] 	= 465;
$config['top10connections']['interval'] = array('days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0);
$config['top10connections']['data'] 	= '1970-01-01 00:00:00'; 

/*
TOP 10 CONNECTION TIME
Top 10 czasu połączenia.
	channel - id kanału na którym ma pokazywać topkę
*/
$config['top10connectiontime']['enabled'] 	= true;
$config['top10connectiontime']['channel'] 	= 466;
$config['top10connectiontime']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0);
$config['top10connectiontime']['data'] 		= '1970-01-01 00:00:00'; 

/*
AUTOMATIC PRIVATE CHANNEL
Tworzy automatycznie kanały prywatne po wejściu na kanał.
	cid - id kanału na który trzeba wejść by uzyskać kanał
	groups - wymagane grupy by otrzymać kanał
	channel_group - numer grupy kanału którą ma nadać po daniu kanału prywatnego
	sub_channels - liczba podkanałów jakie ma utworzyć
*/
$config['getchannel']['enabled'] 		= true;
$config['getchannel']['cid'] 			= 470;
//$config['getchannel']['pid'] 			= 105;
$config['getchannel']['groups'] 		= array(23);
$config['getchannel']['channel_group']	= 5;
$config['getchannel']['sub_channels'] 	= 2;
$config['getchannel']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 1);
$config['getchannel']['data'] 			= '1970-01-01 00:00:00';

/*
PRIVATE CHANNEL CHECKER
Sprawdza w podanej strefie czy kanały prywatne mają aktualną godzinę, aktualizuje godzinę gdy właściciel siedzi na kanale oraz usuwa gdy data jest przestarzała
	pid - id kanału w którym znajduje się strefa kanałów prywatnych
*/
$config['channelchecker']['enabled'] 	= true;
$config['channelchecker']['pid'] 		= 105;
$config['channelchecker']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 30,'seconds' => 0);
$config['channelchecker']['data'] 		= '1970-01-01 00:00:00'; 

/* 
CHECK BOT UPDATE
Sprawdza czy nie wyszła aktualizacja do bota
*/
$config['checkupdate']['enabled'] 		= true;
$config['checkupdate']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 30,'seconds' => 0);
$config['checkupdate']['data'] 			= '1970-01-01 00:00:00';

/*
SERVER GROUP ONLINE
Pokazuje listę osób online z danej grupy na wybranym kanale. By pokazać listę użytkowników dodaj w "Topic" show_group=[gid] gdzie [gid] zamień na numer grupy do pokazania.
*/
$config['group_online']['enabled'] 		= true;
$config['group_online']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['group_online']['data'] 		= '1970-01-01 00:00:00';

/*
TWITCH STREAM STATUS
Pokazuje w opisie status streama w serwisie twitch. By wyświetlać stan w "Topic" podaj twitch=[login] gdzie [login] zamień na login z titch.tv
*/
$config['twitchstatus']['enabled'] 		= true;
$config['twitchstatus']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 3,'seconds' => 0);
$config['twitchstatus']['data'] 		= '1970-01-01 00:00:00';

/*
ANTY RECORD PROTECTION
Pokazuje w opisie status streama w serwisie twitch. By wyświetlać stan w "Topic" podaj twitch=[login] gdzie [login] zamień na login z titch.tv
*/
$config['recordprotection']['enabled'] 			= true;
$config['recordprotection']['interval'] 		= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 3);
$config['recordprotection']['aviable_groups'] 	= array(64);
$config['recordprotection']['admins']			= array(24);
$config['recordprotection']['data'] 			= '1970-01-01 00:00:00';

/*
HITBOX STREAM STATUS
Pokazuje w opisie status streama w serwisie hitbox. By wyświetlać stan w "Topic" podaj hitbox=[login] gdzie [login] zamień na login z hitbox.tv
*/
$config['hitboxstatus']['enabled'] 		= true;
$config['hitboxstatus']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 3,'seconds' => 0);
$config['hitboxstatus']['data'] 		= '1970-01-01 00:00:00';

/*
PREMIUM CHECKER
Sprawdza czy nie upłynął użytkownikowi czas premium
	premiumgroup - grupy jakie przysługują użytkownikowi premium
*/
$config['premiumchecker']['enabled'] 			= true;
$config['premiumchecker']['premiumgroup'] 		= array(24, 65, 66);
$config['premiumchecker']['interval'] 			= array('days' => 0,'hours' => 0,'minutes' => 3,'seconds' => 0);
$config['premiumchecker']['data'] 				= '1970-01-01 00:00:00';

/*
PREMIUM LIST
Lista użytkowników premium.
	channel - id kanału na którym ma pokazywać listę użytkowników premium
*/
$config['premiumlist']['enabled'] 	= true;
$config['premiumlist']['channel'] 	= 533;
$config['premiumlist']['interval'] = array('days' => 0,'hours' => 0,'minutes' => 1,'seconds' => 0);
$config['premiumlist']['data'] 	= '1970-01-01 00:00:00'; 

/*
CHANNEL PROTECTION
Blokuje wchodzenie na kanał gdy nie posiada się danej rangi. By zablokować w "Topic" podaj protect=[group id] gdzie [group id] zamień na ID grupy
	admingroup - id grup których nie będzie bot sprawdzał
*/
$config['channelprotection']['enabled'] 	= true;
$config['channelprotection']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 1);
$config['channelprotection']['data'] 		= '1970-01-01 00:00:00';
$config['channelprotection']['admingroup'] 	= array(13,39,40,41,43,42);

/*
CHANNELS INFO
Pokazuje jakie kanały są do usunięcia a jakie wolne.
	channel - kanał na jakim ma to pokazywać
	pid - id kanału w którym znajduje się strefa kanałów
*/
$config['channelinfo']['enabled'] 	= true;
$config['channelinfo']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 5,'seconds' => 0);
$config['channelinfo']['data'] 		= '1970-01-01 00:00:00';
$config['channelinfo']['channel'] 	= 470;
$config['channelinfo']['pid'] 		= 105;

/*
COMMANDER
Komendy serwerowe działają tylko na kanałach gdzie w topicu wpisane jest 'commander';
*/
$config['commander']['enabled'] 	= true;
$config['commander']['interval'] 	= array('days' => 0,'hours' => 0,'minutes' => 0,'seconds' => 3);
$config['commander']['data'] 		= '1970-01-01 00:00:00';


$config['commander']['commands_list'] = array ('help','meeting','check');
$config['commander']['commands'] = array(
	'help' => array('description' => 'Wyswietla listę komend',
					'usage' => '!help',
					'output' => '
					!help - Wyswietla liste komend
					!meeting - Przenosi administracje na wybrany kanal
					!check - Sprawdza poprawność prywatnych kanałów',
				    'allowed_groups' => array(13) //Grupy, które mogą korzystać z komendy
	),
	'check' => array('description' => 'Sprawdza poprawność prywatnych kanałów',
					'usage' => '!check',
					'output' => 'Wykonano sprawdzenie',
				    'allowed_groups' => array(13) //Grupy, które mogą korzystać z komendy
	),
	'meeting' => array('description' => 'Przeniosi wybrane grupy na kanal zebrania',
					   'usage' => '!meeting',
					   'output' => 'Przeniesiono administracje na kanal zebrania',
					   'groups' => array(23),
					   'channel' => 2682,
					   'allowed_groups' => array(13) //Grupy, które mogą korzystać z komendy
	));












?>