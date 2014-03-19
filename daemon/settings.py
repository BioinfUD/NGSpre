#Settings Handler

class settings:
		
	def getSettings(self):
		settingsfile = 'settings.conf'
		config = open(settingsfile,'r')
		params = config.readlines()
		if(len(params)< 4):
			print 'Error in settings file missing value'
			return 0
		else:
			self.user =  self.clean(params[0])
			self.password = self.clean(params[1])
			self.host = self.clean(params[2])
			self.db = self.clean(params[3])
			return 1
	
	def clean(self,row):
		return row[:row.find('\n')]
  	
#	print 'user: {0} password: {1} host: {2} db: {3}'.format(user,password,host,db)






