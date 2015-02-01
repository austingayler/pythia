#! /usr/bin/env python

import sys
import os
import time
import numpy
from scipy.io.wavfile import read,write
import MySQLdb

#fp = "/home/pi/dr.wav"
fp = '/home/pi/Recordings/log.wav'
duration = 10	# seconds

shell_cmd = 'arecord -D plughw:0 --duration=' + str(duration) + ' -f cd -vv ' + fp # plughw:0 set to whatever usb port the mic is plugged into
os.system(shell_cmd) #record for 10s

time.sleep(1) # even though os.system waits for its process to complete, wait 1s for good measure

rate,data = read(fp)
y = data[:,1]
data = data - numpy.average(data)
data = numpy.absolute(data)
avg = numpy.average(data) #avg, max samples in the recording
maxval = numpy.max(data)
print avg
print maxval

db = MySQLdb.connect(host="localhost", user="root", passwd="toor", db="pythia")
cur = db.cursor()
sql = 'INSERT INTO `audio` (`avg`, `max`) VALUES (\'' + str(avg) + '\',\'' + str(maxval) + '\')' #store in db
cur.execute(sql)
db.commit()
db.close()
