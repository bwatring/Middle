<?php
echo "<p> Hellp>";
$hostname="localhost"; 
$username="webuser";
$password="hello";
$db="temp";
$mysqli=new mysqli($hostname, $username, $password, $db);
if (mysqli_connect_errno())
{
	die("error connecting to database: ".mysqli_connect_error());
	
}
$sql="Inset into `user_input` (`input`, `user_id`,  values ('input from web , 'webuser@mail.com)e";
$mysqli->query($sql) or
	die("somethingwent wrong with $sql".$mysqli->error);
echo "<p>executed $sql<p>";
	?>