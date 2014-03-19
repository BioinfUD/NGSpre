from sys import argv
import os


def main():
	if len(argv)!=4:
		usage()
	print "fastx_clipper -i %s -o %s -a %s" % (argv[1], argv[2], argv[3])
	os.system("fastx_clipper -i %s -o %s -a %s" % (argv[1], argv[2], argv[3]))

def usage():
	print """ This is a wraper for clipping process that uses FastX-toolkit. Usage
	python clipping.py in_file.fastq out_file.fastq adapter
	"""
	exit()

main()

