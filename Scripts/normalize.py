from sys import argv
import os


def main():
	if len(argv)!=5:
		usage()
	outdir=argv[4][::-1].split("/",1)[1][::-1]
	os.system("mkdir -p %s" % outdir)
	print "normalize-by-median.py -C %s -k %s  -N 4   %s " % (argv[1], argv[2], argv[3])
	os.system("normalize-by-median.py -C %s -k %s  -N 4  %s " % (argv[1], argv[2], argv[3]))
	print "mv -- '-C' %s/file_normalized.fastq" % ( argv[4])
	os.system("mv -- '-C' %s/file_normalized.fastq" % ( argv[4]))


def usage():

	print """ This is a wraper for clipping process that uses FastX-toolkit. Usage
	python normalize.py coverage kmer in_file.fasta out_dir
	"""

	exit()

main()



