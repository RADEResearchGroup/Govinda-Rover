#!/usr/bin/python
# -*- coding: utf-8 -*-
import RPi.GPIO as GPIO
import time

import subprocess as jalankan
from subprocess import call

GPIO.setwarnings(False)

#========= START SETUP BAGIAN GPIO =========
GPIO.setmode(GPIO.BCM)

#Pin tombol power
GPIO.setup(27, GPIO.IN, pull_up_down = GPIO.PUD_UP)
#Pin tombol WLAN
GPIO.setup(23, GPIO.IN, pull_up_down = GPIO.PUD_UP)

#Pin LED Sig1
GPIO.setup(22, GPIO.OUT)
#Pin LED Sig2
GPIO.setup(18, GPIO.OUT)
#Pin LED Sig3
GPIO.setup(25, GPIO.OUT)

#Pin LED Net
GPIO.setup(4, GPIO.OUT)
#Pin LED Sys
GPIO.setup(17, GPIO.OUT)

#Reset indikator
GPIO.output(22, False)
GPIO.output(18, False)
GPIO.output(25, False)
GPIO.output(4, False)
GPIO.output(17, False)

#SET ON TEST
#GPIO.output(22, True)
#GPIO.output(18, True)
#GPIO.output(25, True)
#GPIO.output(4, True)
#GPIO.output(17, True)

## Fungsi shutdown power
def shutdown(tmp):
	#kedipkan lampu power
	for i in range(0, 29):
		GPIO.output(17, True)
		time.sleep(0.5)
		GPIO.output(17, False)
		time.sleep(0.5)
	jalankan.call(["/sbin/halt", "-p"])

## Fungsi kontrol WLAN
def switchWLAN(tmp):
	#kedipkan lampu WLAN
	for i in range(0, 29):
		GPIO.output(4, True)
		time.sleep(0.2)
		GPIO.output(4, False)
		time.sleep(0.2)
	#hostapd = jalankan.check_output(['/bin/ps','-A'])
	#if 'hostapd' in hostapd:
		#stop hostapd
		#jalankan.call(["/etc/init.d/hostapd","stop"])
		#print "WLAN Dimatikan..."
	#else:
		#jalankan.call(["/etc/init.d/hostapd","start"])
		#print "WLAN Diaktifkan..."

## Define function named Blink()
def Blink(ledPin, numTimes, speed):
	for i in range(0,numTimes): ## Run loop numTimes
		GPIO.output(ledPin, True) ## Turn on GPIO pin led
		time.sleep(speed) ## Wait
		GPIO.output(ledPin, False) ## Switch off GPIO pin led
		time.sleep(speed) ## Wait


## Event tombol shutdown dipencet
GPIO.add_event_detect(27, GPIO.RISING, callback=shutdown, bouncetime=10)
## Event tombol WLAN dipencet
GPIO.add_event_detect(23, GPIO.RISING, callback=switchWLAN, bouncetime=10)
		

while True:
	#GPIO.wait_for_edge(27, GPIO.FALLING)
	#Hitung mundur 3 detik
	#SET ON TEST
	GPIO.output(22, True)
	GPIO.output(18, True)
	GPIO.output(25, True)
	#GPIO.output(4, True)
	#GPIO.output(17, True)
	

GPIO.cleanup()
