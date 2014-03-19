from sys import argv
import os


def main():
	if len(argv)!=5:
		usage()
	outdir=argv[4][::-1].split("/",1)[1][::-1]
	os.system("mkdir -p %s" % outdir)
	os.system("interleave_pairs.py %s %s %s %s " % (argv[1], argv[2], argv[3], argv[4]))


def usage():
	print """ This is a wraper for interleave process. Usage:
	python interleave.py archivo1.fsata archivo2.fasta pairs.fasta orphans.fasta
	"""
	exit()

main()



