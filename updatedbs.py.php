<?php
print '<pre>';
system('python UpdateDBs.py',$ret);
if($ret == 1){
	print '<p>Error al ejecutar el comando</p>';
	}
print '</pre>';
?>
