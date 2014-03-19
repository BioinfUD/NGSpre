#!/usr/bin/python

print 'Locating!'
import sys
from connector import DBHandler
import time
import os
import smtplib

a = DBHandler()

def execute(command):
	os.system(command)


while(True):
	time.sleep(1)
	result = a.executeSQL("select * from commands where state='new'")
	for command in result:
		cmd = command['command']
		query = "UPDATE commands SET state='running' WHERE id={0}".format(command['id'])
		a.executeSQL(query)
		print "############# NEW COMMAND ############"
		print "new command: {0} is now running".format(cmd)
		print "______________________________________"
		execute(command['command'])
		query2 = "UPDATE commands SET state='finishd' WHERE id={0}".format(command['id'])
		a.executeSQL(query2)
		print "state updated to 'finished'"
		sender = 'admin@bioinfud.com'
		receivers = [command['email']]
		message = """
		Here is a link to your process output: http://200.69.103.29:21050/test/outputs/{0}
		The ID of your process is: {0}
		""".format(command['dir'])
		try:
		   smtpObj = smtplib.SMTP('localhost')
		   smtpObj.sendmail(sender, receivers, message)         
		   print "Successfully sent email"
		except SMTPException:
		   print "Error: unable to send email"
		print "############# COMMAND FINISHED ############"
