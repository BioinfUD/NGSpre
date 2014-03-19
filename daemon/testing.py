#!/usr/bin/python2.7

#name = "headlines.c2_up.clean.ok"
#sp = name.split('.')
#print sp[0]+'.'+sp[1]

import sys
from connector import DBHandler
import time
import os
args = sys.argv

inputFilename = args[1]
script  = open(inputFilename,'r')
lines = script.readlines();
qlen = len(lines)

print 'Lines:'+str(qlen)

a = DBHandler()
i = 0

for line in lines:
	i = i + 1
	print i," Lines processed \r",
	sys.stdout.flush()
	a.executeSQL(line)

print ""
print "Finished!"
script.close()
os.remove(inputFilename)
