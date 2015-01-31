<?php
/* 

RaspBerry V2.0 
InfoScreen



*/

$user_mac= shell_exec("ip link show eth0 | awk '/ether/ {print $2}'");
$user_mac = substr($user_mac, 0, -1);

/* Raspberry V1.0 */
/*
	$fp = fopen('/etc/xdg/lxsession/LXDE/autostart', 'w');
	fwrite($fp, "#@lxpanel --profile LXDE\n");
	fwrite($fp, "@pcmanfm --desktop --profile LXDE\n");
	fwrite($fp, "@xscreensaver -no-splash\n");
	fwrite($fp, "@xset s off\n");
	fwrite($fp, "@xset -dpms\n");
	fwrite($fp, "@xset s noblank\n");
	#fwrite($fp, "@midori -i 600 -e Fullscreen -a http://infoscreen.webfilter.dk?mac=".$user_mac."\n");
	fwrite($fp, "@midori -e Fullscreen -a http://infoscreen.webfilter.dk?mac=".$user_mac."\n");
	fwrite($fp, "@unclutter\n");
	fclose($fp);
*/
/* RaspBerry V2.0 */

	$fp = fopen('/etc/xdg/lxsession/LXDE/autostart', 'w');
	fwrite($fp, "#Her skal sættes dato ind, eller et id nummer\n");
	fwrite($fp, "#@lxpanel --profile LXDE\n");
	fwrite($fp, "#@pcmanfm --desktop --profile LXDE\n");
	fwrite($fp, "#@xscreensaver -no-splash\n");
	fwrite($fp, "@xset s off\n");
	fwrite($fp, "@xset -dpms\n");
	fwrite($fp, "@xset s noblank\n");
	fwrite($fp, "@unclutter -idle 0\n");
	fwrite($fp, "@chromium --kiosk --disable-translate --disable-java --incognito http://infoscreen.webfilter.dk?mac=".$user_mac."\n");
	fclose($fp);


?>