from sys import argv
import os



def main():
	if len(argv)!=4:
		usage()
	outdir=argv[2][::-1].split("/",1)[1][::-1]
	os.system("mkdir -p %s" % outdir)
	os.system("fastq_quality_trimmer -i %s -o %s -t %s" % (argv[1], argv[2], argv[3]))

def usage():
	print """ This is a wraper for trimming process that uses FastX-toolkit. Usage
	python trimming.py in_file.fastq out_file.fastq treshold
	"""
	exit()

main()

