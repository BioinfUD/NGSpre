<?php
require_once('config.php');
$funct=NULL;
if($_GET){
	$funct=$_GET['f'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="imagetoolbar" content="no">
	<title>NGSpre</title>
	<link rel='stylesheet' type='text/css' href='styles.css' />
	<link rel="stylesheet" href="css/style.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script type='text/javascript' src='menu_jquery.js'></script>
	<script src="js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      $(function(){
        $("input:checkbox, input:radio, input:file, select").uniform();
      });
    </script>
	<style>
body{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;
}
.info, .desc{
    border: 1px solid;
    border-radius:3px;
    margin: 10px 0px;
    padding: 15px 30px 15px 30px;
    background-repeat: no-repeat;
    background-position: 10px center;
}
.info{
    color: #727272;
	background-color: #DADADA;
}
.desc{
	color: #727272;
	background-color: #D9ECF8;
	text-align:left;
	max-width: 600px;
}
	</style>
</head>
<body>
<table>
	<tr>
	<td style="vertical-align: top;">
		<div id='cssmenu'>
<ul>
   <li class='active'><a href='index.php?f='><span>Home</span></a></li>
   <li class='has-sub last'><a href='#'><span>Format Conversion</span></a>
      <ul>
         <li><a href='index.php?f=bam2fasta.py.html'><span>bam to fasta</span></a></li>
         <li><a href='index.php?f=bam2fastq.py.html'><span>bam to fastq</span></a></li>
         <li class='last'><a href='index.php?f=fastq2fasta.py.html'><span>fastq to fasta</span></a></li>
      </ul>
   </li>
   <li><a href='index.php?f=qual.py.html'><span>Quality stats</span></a></li>
   <li><a href='index.php?f=clip.py.html'><span>Clipping</span></a></li> 
   <li><a href='index.php?f=norm.py.html'><span>Normalization</span></a></li>
   <li><a href='index.php?f=trim.py.html'><span>Trimming</span></a></li>
   <li><a href='index.php?f=pair.py.html'><span>Interleave pairs</span></a></li>
   <li><a href='tail.php' target="_blank"><span>Processes in tail</span></a></li>
</ul>
</div>
	</td>
	<td style="vertical-align: top;padding-left: 25px;border-left: solid 2px gray;">
		<div id="cont"></div>
	<?php
	
	if(!$_POST){
		if($funct){
			switch($funct){
				
				case 'clip.py.html':
					echo '<script>$("#cont").load("clip.py.html");</script>';
				break;
				case 'norm.py.html':
					echo '<script>$("#cont").load("norm.py.html");</script>';
				break;
				case 'pair.py.html':
					echo '<script>$("#cont").load("pair.py.html");</script>';
				break;
				case 'trim.py.html':
					echo '<script>$("#cont").load("trim.py.html");</script>';
				break;
				case 'qual.py.html':
					echo '<script>$("#cont").load("qual.py.html");</script>';
				break;
				case 'bam2fastq.py.html':
					echo '<script>$("#cont").load("bam2fastq.py.html");</script>';
				break;
				case 'fastq2fasta.py.html':
					echo '<script>$("#cont").load("fastq2fasta.py.html");</script>';
				break;
				case 'bam2fasta.py.html':
					echo '<script>$("#cont").load("bam2fasta.py.html");</script>';
				break;
				default:
					echo '<script>$("#cont").load("welcome.html");</script>';
				break;
			}//endswitch()
		}else{
			echo '<script>$("#cont").load("welcome.html");</script>';
		}
	}else{
		$link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB) or die("Error " . mysqli_error($link));
		$char = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$numlet=7;
		$dir = "";
		for($i=0;$i<$numlet;$i++){
			$dir .= substr($char,rand(0,strlen($char)),1);
		}
		switch($_POST['proc']){
			case 'clip.py':
				print '<div class="info">Blast Exec</div><br>';
				//upload the file
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$adapter = $_POST['adapter'];
					$cmd = 'cd '.DIR_SOFT.' && python clipping.py '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.fastq'.' '.$adapter;
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					$adapter = $_POST['adapter'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python clipping.py '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fastq'.' '.$adapter;
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
					
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'trim.py':
				print '<div class="info">XML to Custom</div><br>';
				//upload the file
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$threshold = $_POST['threshold'];
					$cmd = 'cd '.DIR_SOFT.' && python trimming.py '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.fastq'.' '.$threshold;
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					$threshold = $_POST['threshold'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python trimming.py '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fastq'.' '.$threshold;
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'norm.py':
			print '<div class="info">Hits to Go</div><br>';
				//upload the file
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$coverage = $_POST['coverage'];
					$email = $_POST['email'];
					$kmer = $_POST['kmer'];
					$cmd = 'cd '.DIR_SOFT.' && python normalize.py '.$coverage.' '.$kmer.' '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir;
				}else{
					$idfile = $_POST['idfile'];
					$coverage = $_POST['coverage'];
					$email = $_POST['email'];
					$kmer = $_POST['kmer'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python normalize.py '.$coverage.' '.$kmer.' '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir;
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
					
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'pair.py':
				print '<div class="info">Graph Pie</div><br>';
				//upload the file
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					//first file
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					//second file
					if ($_FILES["file2"]["error"] > 0){
						echo "Error: " . $_FILES["file2"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file2"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file2"]["name"])){
							print "> file2 uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$adapter = $_POST['adapter'];
					$cmd = 'cd '.DIR_SOFT.' && python interleave.py '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file2"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/(pairs)'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/(orphans)'.$_FILES["file"]["name"];
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					$adapter = $_POST['adapter'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python clipping.py '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fastq'.' '.$adapter;
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
					
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'qual.py':
				print '<div class="info">Quality Stats</div><br>';
				//upload the file
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$cmd = 'cd '.DIR_SOFT.' && python fastqc.py '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.fasta';
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python fastqc.py '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fasta';
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'bam2fastq.py':
				print '<div class="info">Bam to Fastq</div><br>';
				//upload the file
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$cmd = 'cd '.DIR_SOFT.' && python convert.py bam fastq '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.fasta';
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python convert.py bam fastq '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fasta';
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'bam2fasta.py':
				print '<div class="info">Bam to Fasta</div><br>';
				//upload the file
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$cmd = 'cd '.DIR_SOFT.' && python convert.py bam fasta '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.fasta';
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python convert.py bam fasta '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fasta';
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
			case 'fastq2fasta.py':
				print '<div class="info">Fastq to Fasta</div><br>';
				//upload the file
				system('mkdir -p '.DIR_OUTPUTS.'/'.$dir);
				if($_POST['idfile'] == ''){
					system('mkdir -p '.DIR_UPLOADS.'/'.$dir);
					if ($_FILES["file"]["error"] > 0){
						echo "Error: " . $_FILES["file"]["error"] . "<br>";
					}else{
						if(move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/". $dir . "/" . $_FILES["file"]["name"])){
							print "> file uploaded successfully<br>";
						}else{ 
							print "> Upload error<br>";
							print "> The process cannot be executed<br>";
							break;
						}
					}
					$email = $_POST['email'];
					$cmd = 'cd '.DIR_SOFT.' && python convert.py fastq fasta '.DIR_UPLOADS.'/'.$dir.'/'.$_FILES["file"]["name"].' '.DIR_OUTPUTS.'/'.$dir.'/'.$_FILES["file"]["name"].'.fasta';
				}else{
					$idfile = $_POST['idfile'];
					$email = $_POST['email'];
					if($gest = opendir(DIR_UPLOADS.'/'.$idfile)){
						$nameFind=false;
						while($nameFind == false){
							$nameOldFile = readdir($gest);
							if($nameOldFile == '..' || $nameOldFile == '.'){
							}else{
								$nameFind=true;
							}
						}
						$cmd = 'cd '.DIR_SOFT.' && python convert.py fastq fasta '.DIR_UPLOADS.'/'.$idfile.'/'.$nameOldFile.' '.DIR_OUTPUTS.'/'.$dir.'/'.$nameOldFile.'.fasta';
					}else{
						print 'No se pudo encontrar el archivo, rectifique el ID<br>';
						break;
					}
				}
				//save the command in the database.
				print "Se va a ejecutar: ".$cmd."<br>";
				$query = 'INSERT INTO commands VALUES (DEFAULT,"'.$cmd.'","new","'.$dir.'","'.$email.'");';
				
				$link->query($query);
				if($_POST['email'] && $_POST['email'] != ''){
					print 'An email will be sent to you when the process is complete.<br><br>';
				}
				print "<a href='tail.php'><input type='button' value='All processes in server' /></a><br>";
			break;
		}//endswitch()		
	}//endifelse()
	
	?>
	</td>
	</tr>
</table>
</body>
</html>
