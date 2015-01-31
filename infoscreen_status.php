<?php


$star_unit_ip = shell_exec("ip addr list eth0 |grep 'inet ' |cut -d' ' -f6|cut -d/ -f1");
$star_unit_ip = substr($star_unit_ip, 0, -1);
$star_unit_mac = shell_exec("ip link show eth0 | awk '/ether/ {print $2}'");
$star_unit_mac = substr($star_unit_mac, 0, -1);

$ctx = stream_context_create(array('http' => array('timeout' => 5)));  ## time out

$lan_ip = shell_exec("ip addr list eth0 |grep 'inet ' |cut -d' ' -f6|cut -d/ -f1");
$lan_ip = substr($lan_ip, 0, -1);
$wifi_ip = shell_exec("ip addr list wlan0 |grep 'inet ' |cut -d' ' -f6|cut -d/ -f1");
$wifi_ip = substr($wifi_ip, 0, -1);

if ($wifi_ip){ /* Got wifi ip */
 $ip = "Wi-Fi,".$wifi_ip;
} else if ($lan_ip){ /* Got lan ip */
 $ip = "LAN,".$lan_ip;
} else {
 $ip ="unknown adapter";
}


$user_mac= shell_exec("ip link show eth0 | awk '/ether/ {print $2}'");
$user_mac = substr($user_mac, 0, -1);
#$pids = trim(shell_exec("pgrep -f 'php /home/pi/dns.php'"));

if(file_exists('/proc/loadavg')){
	$load = file_get_contents('/proc/loadavg');
	$load = explode(' ', $load, 1);
	$load = $load[0];
}
$cpu=($load[0].$load[1].$load[2].$load[3])*100;

/*
$pid = explode("\n", $pids);
if(empty($pid[count($pid)-1])) {
    unset($pid[count($pid)-1]);
}
unset($pid[count($pid)-1]);
if (count($pid)<1){
	print "Program stoppet\n";
	print "Prøver at starte igen\n";
	$power=shell_exec ("sudo /etc/init.d/dnsrelay start");
	print "Status = ".$power."\n";
	exit;
}


if(file_exists('/proc/loadavg')){
	$load = file_get_contents('/proc/loadavg');
	$load = explode(' ', $load, 1);
	$load = $load[0];
}
$cpu=($load[0].$load[1].$load[2].$load[3])*100;
#if ($avg > 99){sleep(1);}
if ($cpu > 100)$cpu=100;
exec("/usr/bin/dig @8.8.8.8 google.com A +short +time=3 +tries=1",$ips_array,$fp);
if ($fp==0) {  
	$up="open"; // server up
} else {  
	$up="closed"; // server down
} 

$time_start = microtime(true);
exec("/usr/bin/dig @".$ip." google.com A +short +time=3 +tries=1",$ips_array,$fp);
if ($fp==0) {  
	$dnst_up="open"; // server up
} else { 
	$dnst_up="closed"; // server down
} 
$time_end = microtime(true);
$time = $time_end - $time_start;
$dnst_time=number_format($time,3);
	$config=NULL;	
foreach( file( '/home/pi/config/config.txt') as $line) {
	$config .= $line."|";
}

*/
$domain = "http://system.webfilter.dk/admin/infoscreen_status.php?ip=".$ip."&mac=".$user_mac."&cpu=".$cpu;
$data = file_get_contents($domain, NULL, $ctx, 0, 70000);

## Config sysntax
## newconfig|dnst_servers=89.150.177.131,89.150.177.89|syslog_server=95.166.209.82|forks_start=5|local_dns=192.168.111.1|

$convert = explode("|", $data); //create array separate by new line

for ($i=0;$i<count($convert);$i++)  
{
  # echo $convert[$i].', '; //write value by index

}
if ($convert[0] == "newconfig"){
	$fp = fopen('/home/pi/config/config.temp', 'w');
	fwrite($fp, "# For more options and information see\n");
	fwrite($fp, "# http://www.raspberrypi.org/documentation/configuration/config-txt.md\n");
	fwrite($fp, "# Some settings may impact device functionality. See link above for details\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment if you get no picture on HDMI for a default 'safe' mode\n");
	fwrite($fp, "#hdmi_safe=1\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment this if your display has a black border of unused pixels visible\n");
	fwrite($fp, "# and your display can output without overscan\n");
	fwrite($fp, "disable_overscan=1\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment the following to adjust overscan. Use positive numbers if console\n");
	fwrite($fp, "# goes off screen, and negative if there is too much border\n");
	fwrite($fp, "#overscan_left=16\n");
	fwrite($fp, "#overscan_right=16\n");
	fwrite($fp, "#overscan_top=16\n");
	fwrite($fp, "#overscan_bottom=16\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment to force a console size. By default it will be display's size minus\n");
	fwrite($fp, "# overscan.\n");
	fwrite($fp, "#framebuffer_width=1280\n");
	fwrite($fp, "#framebuffer_height=720\n");
	fwrite($fp, "\n");
	fwrite($fp, $convert[1]."\n"); ## display_rotate=0
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment if hdmi display is not detected and composite is being output\n");
	fwrite($fp, "hdmi_force_hotplug=1\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment to force a specific HDMI mode (this will force VGA)\n");
	fwrite($fp, "#hdmi_group=1\n");
	fwrite($fp, "#hdmi_mode=1\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment to force a HDMI mode rather than DVI. This can make audio work in\n");
	fwrite($fp, "# DMT (computer monitor) modes\n");
	fwrite($fp, "#hdmi_drive=2\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment to increase signal to HDMI, if you have interference, blanking, or\n");
	fwrite($fp, "# no display\n");
	fwrite($fp, "#config_hdmi_boost=4\n");
	fwrite($fp, "\n");
	fwrite($fp, "# uncomment for composite PAL\n");
	fwrite($fp, "#sdtv_mode=2\n");
	fwrite($fp, "\n");
	fwrite($fp, "#uncomment to overclock the arm. 700 MHz is the default.\n");
	fwrite($fp, "#arm_freq=800\n");
	fwrite($fp, "\n");
	fwrite($fp, "\n");
	fwrite($fp, "# NOOBS Auto-generated Settings:\n");
	fwrite($fp, "hdmi_force_hotplug=1\n");
	fwrite($fp, "config_hdmi_boost=4\n");
	fwrite($fp, "#overscan_left=24\n");
	fwrite($fp, "#overscan_right=24\n");
	fwrite($fp, "#overscan_top=16\n");
	fwrite($fp, "#overscan_bottom=16\n");
	fwrite($fp, "framebuffer_depth=32\n");
	fwrite($fp, "framebuffer_ignore_alpha=1\n");
	fwrite($fp, "disable_overscan=1\n");
	fwrite($fp, "start_x=0\n");
	fwrite($fp, "gpu_mem=128\n");

	fclose($fp);

	print "Ny config skrevet\n";
	$power=shell_exec ("sudo mv /boot/config.txt /home/pi/config/config-".uniqid().".txt");
	print "Gammel konfig rename\n";
	$power=shell_exec ("sudo mv /home/pi/config/config.temp /boot/config.txt");
	print "Ny konfig rename\n";
	print "Reboot skal udføres\n";
	

	

}

if ($convert[0] == "screenon"){
	$power=shell_exec ("tvservice --preferred > /dev/null");
	$power=shell_exec ("fbset -depth 8; fbset -depth 16;");
}
if ($convert[0] == "screenoff"){
	$power=shell_exec ("tvservice --off > /dev/null");
}

if ($convert[0] == "reboot"){
	$power=shell_exec ("sudo reboot");
}
if ($convert[0] == "poweronunit"){
	$power=shell_exec ("sudo /etc/init.d/dnsrelay start");
}
if ($convert[0] == "poweroffunit"){
	$power=shell_exec ("sudo /etc/init.d/dnsrelay stop");
}
/*
if ($convert[0] == "newconfig"){
	$fp = fopen('/home/pi/config/config.temp', 'w');
	fwrite($fp, $convert[1]."\n");
	fwrite($fp, $convert[2]."\n");
	fwrite($fp, $convert[3]."\n");
	fwrite($fp, $convert[4]);
	fclose($fp);
	rename ("/home/pi/config/config.txt", "/home/pi/config/config-".uniqid().".txt");
	rename ("/home/pi/config/config.temp", "/home/pi/config/config.txt");
}
*/

if ($convert[0] == "time"){
	$newtime = explode("=", $convert[1]);
	print "Tid modtaget : ".$newtime[1]."\n";
	$power=shell_exec ("sudo date +%s -s @".$newtime[1]."");
	print "Tid sat\n";
}
/*
print "hej2\n";
print $data;
print "\n";
print $newtime[1];
print "\n";
*/

?>
