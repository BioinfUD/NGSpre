from sys import argv
import os


def main():
	if len(argv)!=5:
		usage()
	outdir=argv[4][::-1].split("/",1)[1][::-1]
	os.system("mkdir -p %s" % outdir)
	if (argv[1]=="bam" and argv[2]=="fastq"):
		os.system("bam2fastx --fastq -o %s  %s " % (argv[4], argv[3]))
	elif  (argv[1]=="fastq" and argv[2]=="fasta"):
		print "fastq to fasta"
		print "fastq_to_fasta -i %s -o %s " % (argv[3], argv[4])
		os.system("fastq_to_fasta -i %s -o %s " % (argv[3], argv[4]))
	elif  (argv[1]=="bam" and argv[2]=="fasta"):
		os.system("bam2fastx --fasta -o %s  %s " % (argv[4], argv[3]))

def usage():
	print """ This is a wraper for convert formats. Usage
	python fastqc.py format_in format_out infile outfile
	"""
	exit()

main()


