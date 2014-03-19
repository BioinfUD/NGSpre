<?php
require_once('config.php');
$link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB) or die("Error " . mysqli_error($link));
$sql = 'select * from commands';
if(!$result = $link->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}else{
	print "
<!DOCTYPE html>
<html>

<head>
	<title>Tail</title>
	<style>
ol{
	counter-reset: li; /* Initiate a counter */
	list-style: none; /* Remove default numbering */
	*list-style: decimal; /* Keep using default numbering for IE6/7 */
	font: 15px 'trebuchet MS', 'lucida sans';
	padding: 0;
	margin-bottom: 4em;
	text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

ol ol{
	margin: 0 0 0 2em; /* Add some left margin for inner lists */
}
.rectangle-list a{
	position: relative;
	display: block;
	padding: .4em .4em .4em .8em;
	*padding: .4em;
	margin: .5em 0 .5em 2.5em;
	background: #ddd;
	color: #444;
	text-decoration: none;
	transition: all .3s ease-out;	
}

.rectangle-list a:hover{
	background: #eee;
}	

.rectangle-list a:before{
	content: counter(li);
	counter-increment: li;
	position: absolute;	
	left: -2.5em;
	top: 50%;
	margin-top: -1em;
	background: #fa8072;
	height: 2em;
	width: 2em;
	line-height: 2em;
	text-align: center;
	font-weight: bold;
}

.rectangle-list a:after{
	position: absolute;	
	content: '';
	border: .5em solid transparent;
	left: -1em;
	top: 50%;
	margin-top: -.5em;
	transition: all .3s ease-out;				
}

.rectangle-list a:hover:after{
	left: -.5em;
	border-left-color: #fa8072;				
}	
	</style>
</head>

<body>";
print "<ol class='rectangle-list'>";
	while($row = $result->fetch_assoc()){
		print "<li>";
		print "<a href='outputs/".$row['dir']."' target='_blank'>";
		//div command
		print "<div>";
		print $row['command'];
		print "</div>";
		//div state
		print "<div>";
		print $row['state'];
		print "</div>";
		print "</a>";
		print "</li>";
	}
	print "</ol>";
	
print "
</body>

</html>
	";
}
?>
