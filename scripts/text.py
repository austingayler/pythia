#!/usr/bin/env python

import sys
import os
from datetime import datetime
import ConfigParser
import MySQLdb

configParser = ConfigParser.RawConfigParser()
configFilePath = r'/home/pi/config/pythia'	#config file with my number
configParser.read(configFilePath)

recipient = configParser.get('pythia', 'recipient')

db = MySQLdb.connect(host="localhost", user="root", passwd="toor", db="pythia")
cur = db.cursor()
sql = "SELECT * FROM quotes ORDER BY RAND() LIMIT 0,1"	#select random quote from table
cur.execute(sql)
for row in cur.fetchall():
	message = row[1]

# message = str(datetime.now())

shell_cmd = 'echo \"' + message + '\" | mail -s \"\" ' + recipient	#send msg
print shell_cmd
os.system(shell_cmd)

quit()
