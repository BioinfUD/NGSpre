# Connect MySQL

import MySQLdb
from settings import settings

class DBHandler:

	def __init__(self):
		lnk = self.__getlnk()
		self.__lnk = lnk
		if(lnk):
			try:
				self.__cursor = self.__getcursor(lnk)
			except Exception, e:
				print e

	def __getlnk(self):
		params = settings()
		if(params.getSettings()):
			try:
				lnk = MySQLdb.connect(params.host,params.user,params.password,params.db)
				return lnk
			except Exception, e:
				print e
		return 0

	def __getcursor(self,lnk):
		return lnk.cursor(MySQLdb.cursors.DictCursor)

	def executeSQL(self,sql):
		try:
			if(self.__cursor):
				try:
					self.__cursor.execute(sql)
					self.__lnk.commit()
					return self.__cursor.fetchall()
				except Exception, e:
					print e
		except Exception, e:
			print e

	def executeSQLFile(self,filename):
		try:
			sqlscript = open(filename,'w')
		except Exception, e:
			raise e


