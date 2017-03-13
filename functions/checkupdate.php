<?php
/*

        		iBot [v0.1 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website	 : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

include_once 'include/config.php';
include_once 'include/ts3admin.class.php';

function checkupdate()
{
    global $query;
    global $config;

	$fp = fopen('cache/checkupdate.txt', "r");
    $tekst = fread($fp, 4);
	$installedversion = (int)$tekst;
	fclose($fp);

    $strona = getStatus("http://inferno24.eu/update/checkupdate.txt");
	$gitversion = (int)$strona;

    if($installedversion != $gitversion)
    {
        $msg = '\n
                [COLOR=#990000][B]
                =================================[ UWAGA ]=================================\n
                                                            Serwer korzysta z przestażałej wersji bota! Zaleca się jego aktualizacja.\n
                                                                                    Najnowszą wersję pobierzesz z [URL=http://inferno24.eu]inferno24.eu[/URL]\n
                =========================================================================
                [/B][/COLOR]';
        $query->sendMessage(3, 1, $msg);
    }

    unset($strona);
    unset($query);
    unset($config);
}

function getStatus($url) 
{
    if(in_array('curl', get_loaded_extensions())) 
    {
        $curl = curl_init($url) ;
        curl_setopt( $curl, CURLOPT_URL , $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $source = curl_exec( $curl );
        curl_close( $curl );
    } 
    else 
    {
        $source = file_get_contents($url);
    }
    return $source;     
}

?>