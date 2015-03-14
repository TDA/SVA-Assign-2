<?php
define("IMGPATH", "Images/");
define("AUTHERR", "Sorry mate, You dont seem to have the authentication to enter in here");
$dbname="cse591";
$uname="root";
$server="localhost";


$dbconn= new mysqli("$server","$uname","","$dbname") or die('Invalid Password');
?>