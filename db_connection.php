<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "u542069135_plvrs";
 $dbpass = "Plvrs2021";
 $db = "u542069135_plvrs";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>