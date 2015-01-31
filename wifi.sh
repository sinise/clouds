#!/bin/bash
file="/media/usb0/wificonfig.txt"
if [ -f "$file" ]
then
	echo "$file found."
if  ! diff -q /media/usb0/wificonfig.txt /etc/wpa_supplicant/wpa_supplicant.conf > /dev/null ;
then
	
       echo "filer ikke ens"
        cp /media/usb0/wificonfig.txt /etc/wpa_supplicant/wpa_supplicant.conf
        sleep 10
        echo "skal reboote her"
	reboot
else
	echo "filer er ens"
fi
else
	echo "$file not found."
fi
