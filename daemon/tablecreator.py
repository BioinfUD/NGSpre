#Table creation

from connector import DBHandler
import sys
import timing

dbh = DBHandler()

table = """CREATE TABLE `{0}` (
  `db_ref` varchar(100) NOT NULL,
  `query_id` varchar(100) NOT NULL,
  `query_len` int(11) NOT NULL,
  `hit_id` varchar(400) NOT NULL,
  `hit_def` varchar(400) NOT NULL,
  `hit_lenght` int(11) NOT NULL,
  `e_value` double NOT NULL,
  `coverage` double NOT NULL,
  `covovere_value` double NOT NULL,
  `alig_score` float NOT NULL,
  `alig_bitscore` float NOT NULL,
  `alig_identy` float NOT NULL,
  `gi_id` varchar(3000) NOT NULL,
  `ref_seq_ac` varchar(1000) NOT NULL,
  `ref_seq_def` varchar(1000) NOT NULL,
  `go_ids` varchar(3000) NOT NULL,
  `go_terms` varchar(12000) NOT NULL,
  `go_ontology` varchar(100) NOT NULL,
  `uniprot_ac` varchar(50) NOT NULL,
  `uniprot_def` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabla con los campos definitivos';"""

#query = table.format('morrongo')
#print query
#dbh.executeSQL(query);
timing.start()
result = dbh.executeSQL('select * from Diploria_datos limit 0,250000')
countd = dbh.executeSQL('select count(*) as count from Diploria_datos')
print countd[0]['count']
slices = countd[0]['count']/250000
print slices
timing.finish()
print "Took: "+str(timing.seconds())+" seconds to complete"
sconds_t = timing.seconds()*slices
print "Estimate to complete all records: "+str(sconds_t/60)+' minutes'




#print result
#print sys.getsizeof(result)/1000
#print len(result);
