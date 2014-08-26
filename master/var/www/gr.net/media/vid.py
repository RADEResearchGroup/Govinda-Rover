#import time
#import picamera
#import shutil
import datetime
import subprocess as jalankan
from subprocess import call

filename = datetime.datetime.now().strftime("%Y%m%d%H%M%S")
arg = ' -add' + ' /var/www/gr.net/media/vid_tmp.h264' + ' ' + '/var/www/gr.net/media/video/' + str(filename) + '.mp4';
jalankan.call("MP4Box" + arg, shell=True)

#with picamera.PiCamera() as camera:
#	filename = datetime.datetime.now().strftime("%Y%m%d%H%M%S")
	
#	camera.resolution = (1280, 720)
	# Set a framerate of 1/6fps, then set shutter
    # speed to 6s and ISO to 800
	#camera.framerate = Fraction(1, 6)
#	camera.shutter_speed = 6000000
	#camera.exposure_mode = 'off'
#	camera.ISO = 800
#	print "camera start"
#	camera.start_recording('/var/www/gr.net/media/vid_tmp.h264')
#	while True:
#		fifo = open("/var/www/gr.net/media/FIFO", "r")
#		status = str(fifo.read())
#		if status == '1':
#			fifo.close()
#			fifoend = open("/var/www/gr.net/media/FIFO", "w")			
#			fifoend.write("0")
#			fifoend.close()			
#			break
#	camera.stop_recording()
#	print "camera stop"
	
	# 2592 x 1944
	#camera.resolution = (2592, 1944)
	#camera.start_preview()
	# Camera warm-up time
	#time.sleep(2)
	#camera.capture('/var/www/gr.net/media/shot.jpg')
	
#	arg = ' -add' + ' /var/www/gr.net/media/vid_tmp.h264' + ' ' + '/var/www/gr.net/media/video/' + str(filename) + '.mp4';
	
#	jalankan.call("MP4Box" + arg, shell=True)
	
	#copy file ke media
	#shutil.copy2('/var/www/gr.net/media/shot.jpg', '/var/www/gr.net/media/video/' + filename + '.jpg')
	
	#print pesan selesai
#	print "Perekaman video selesai..."