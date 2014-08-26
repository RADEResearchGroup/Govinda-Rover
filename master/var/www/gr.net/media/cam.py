import time
import picamera
import shutil
import datetime

with picamera.PiCamera() as camera:
	filename = datetime.datetime.now().strftime("%Y%m%d%H%M%S")
	# 2592 x 1944
	camera.resolution = (2592, 1944)
	camera.start_preview()
	# Camera warm-up time
	time.sleep(2)
	camera.capture('/var/www/gr.net/media/shot.jpg')
	
	#copy file ke media
	shutil.copy2('/var/www/gr.net/media/shot.jpg', '/var/www/gr.net/media/foto/' + filename + '.jpg')
	
	#print pesan selesai
	print "Foto selesai diambil..."
	