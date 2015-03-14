<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<?php
$url_array=parse_url($_SERVER['REQUEST_URI']);
foreach($url_array as $key=>$value){
	echo "key is ".$key." value is ".$value;
}
echo "<br>";
var_dump($url_array);

print_r(parse_url($_SERVER['REQUEST_URI']));


?>
</body>
</html>