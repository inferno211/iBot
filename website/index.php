<?php
/*

        		iBot [v0.5 Beta]
      Copyright (C) 2017 Piotr 'Inferno' Grencel
 
      @author    : Piotr 'Inferno' Grencel
      @website	 : http://github.com/inferno211
      @contact   : inferno.piotr@gmail.com

*/

	error_reporting(E_ALL);

	ini_set('error_reporting', E_ALL);
	ini_set("display_errors", 1);

	$settings = array(
		'userid' => '2096',
		'serviceid' => '2633',
		'text' => 'MSMS.INFERNO24',
		'number' => '7136',
		'cost' => '1',
		'days' => '2',

		'dbhost' => '127.0.0.1',
		'dbuser' => '',
		'dbpass' => '',
		'dbname' => ''
		);
		
	if (isset($_POST['send']) && isset($_POST['code']) && isset($_POST['uid'])) 
	{
		$code = addslashes($_POST['code']);

		if (preg_match("/^[A-Za-z0-9]{8}$/", $code)) 
		{
			$api = @file_get_contents("http://microsms.pl/api/v2/index.php?userid=" . $settings['userid'] . "&number=" . $settings['number'] . "&code=" . $code . '&serviceid=' . $settings['serviceid']);

			if (!isset($api)) 
			{
				$errormsg = 'Nie można nawiązać połączenia z serwerem płatności.';
			}
			else 
			{
				$api = json_decode($api);
					
				if (!is_object($api)) 
				{
					$errormsg = 'Nie można odczytać informacji o płatności.';
				} 
						
				if (isset($api->error) && $api->error) 
				{
					$errormsg = 'Kod błędu: ' . $api->error->errorCode . ' - ' . $api->error->message;
				} 
				else if ($api->connect == FALSE) 
				{
					$errormsg = 'Kod błędu: ' . $api->data->errorCode . ' - ' . $api->data->message;
				}
			}
					
			if (!isset($errormsg) && isset($api->connect) && $api->connect == TRUE) 
			{
				if ($api->data->status == 1) 
				{
					$polaczenie = @new mysqli($settings['dbhost'], $settings['dbuser'], $settings['dbpass'], $settings['dbname']);

    				$result = mysqli_query($polaczenie, "SELECT * FROM premium WHERE uid = '".$_POST['uid']."'");
					if(mysqli_num_rows($result) != 0)
					{
						$u_data = mysqli_fetch_assoc($result);
						if($u_data['endtime'] > time())
						{
							$okmsg = 'Twój kod jest poprawny. Czas premium przedłużony o '.$settings['days'].' dni.';
							$czas_nowy = $u_data['endtime'] + $settings['days'] * 86400;

							mysqli_query($polaczenie, "UPDATE premium SET endtime = '".$czas_nowy."' WHERE uid = '".$_POST['uid']."'");
						}
						else
						{
							$okmsg = 'Twój kod jest poprawny. Czas premium zostanie ustawiony na '.$settings['days'].' dni.';
							$czas_nowy = time() + $settings['days'] * 86400;

							mysqli_query($polaczenie, "UPDATE premium SET endtime = '".$czas_nowy."' WHERE uid = '".$_POST['uid']."'");
						}
					}
					else
					{
						$okmsg = 'Twój kod jest poprawny. Czas premium zostanie ustawiony na '.$settings['days'].' dni.';
						$czas_nowy = time() + $settings['days'] * 86400;

						mysqli_query($polaczenie, "INSERT INTO premium 	(`uid`, `endtime`) VALUES 
																				('".$_POST['uid']."', 
																				'".$czas_nowy."')");
					}
				} 
				else 
				{
					$errormsg = 'Przesłany kod jest nieprawidłowy, spróbuj ponownie.';
				}
			}
		}
		else 
		{
			$errormsg = 'Przesłany kod jest nieprawidłowy, przepisz go ponownie.';
		}
	}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>Zakup konta premium</title>
	  <link href="css.css" rel="stylesheet" type="text/css">
   </head>
   <body>
	 <div id="page">
         <div class="center title">Zakup konta premium</div>
         <br/>
         <div class="center">
            W celu zakupu produktu proszę wysłać SMS na numer <strong><?php echo $settings['number']; ?></strong> o treści <strong><?php echo $settings['text']; ?></strong><br/>
            Koszt wysłania wiadomości <?php echo $settings['cost']; ?>zł netto (<?php echo number_format($settings['cost'] * ( 1 + 23 / 100 ), 2); ?> zł z vat).<br/><br/>
            
			<?php if(isset($okmsg)) { ?><div class="msg ok"><?php echo $okmsg; ?></div><?php } ?>
			<?php if(isset($errormsg)) { ?><div class="msg error"><?php echo $errormsg; ?></div><?php } ?>
			
            <form method="post" >
               <input type="hidden" name="send" value="" />
               <input name="code" placeholder="Kod sms" type="text" style="width: 300px;" /><br />
               <input name="uid" placeholder="UID z TS3 znadziesz pod CTRL + I" type="text" style="width: 300px;" /><br />
               <button class="button" type="submit">Sprawdź kod</button>
            </form>
            <br/><br/>
            Płatności zapewnia firma <a href="http://microsms.pl/">MicroSMS</a>. <br/>
            Korzystanie z serwisu jest jednozanczne z akceptacją <a href="http://microsms.pl/partner/documents/">regulaminów</a>.<br/>
            Jeśli nie dostałeś kodu zwrotnego w ciągu 30 minut skorzystaj z <a href="http://microsms.pl/customer/complaint/">formularza reklamacyjnego</a><br/><br/>
            <img src="http://microsms.pl/public/cms/img/banner.png">
         </div>
      </div>
   </body>
</html>
