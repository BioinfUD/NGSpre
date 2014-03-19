from sys import argv
import os


def main():
	if len(argv)!=3:
		usage()
	os.system("fastqc %s -q -o %s " % (argv[1], argv[2]))

def usage():
	print """ This is a wraper for clipping process that uses FastX-toolkit. Usage
	python qc.py in_file.fastq  out_dir
	"""
	exit()

main()


