<?php
session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="description" content="super spy agency">
<meta name="keywords" content="super spies, secret, cse 591">
<meta name="author" content="Sai Pc">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">

<!--[if lt IE 9]>  
<script src="../Scripts/html5shiv.js"></script> 
<script src="../Scripts/respond.min.js" type="text/javascript"></script>
<script src="../Scripts/selectivizr-min.js" type="text/javascript"></script>
 
<![endif]--> 

<link rel="stylesheet" href="../normalize.css">
<link rel="stylesheet" href="../styles.css">

<?
class Page{
	public $title='CSE 591 - ';
	public $fn='Home';
	public $kseq=array('/user/register','/user/login','/message/add','/message/list');
	//here is a variable change
	public function __set($name,$value){
		$this->$name=$value;	
	}
	public function DisplayTitle(){
		 echo "<title> $this->title </title>\n";
		 echo "</head>";
	}
	public function DisplayNav(){
		 echo '<nav>
				<ul>
				<li><a href="../user/register">Register</a></li>
				<li><a href="../user/login">Login</a></li>
				<li><a href="../message/add">Add message</a></li>
				<li><a href="../message/list">View messages</a></li>';
				//here is a variable change
		 if(isset($_SESSION['username']))
		 echo '<li><a href="../user/logout">Logout</a></li>';		
		 echo '</ul></nav>';//here is a variable change
		
	}
	public function DisplayError($error){
		echo '<div class="error">'.$error.'</div>';
		//die();
	}
	
	public function DisplayMessage($message,$className,$uname,$title){
		if(isset($uname)&&strlen($uname)>1)
		echo '<div class="author">'.$uname.' says: </div>';
		if(isset($title)&&strlen($title)>1)
		echo '<div class="title">Title : '.$title.'</div>';
		echo '<div class="'.$className.'">Message : '.$message.'</div>';
	}
	
	public function CheckSecretMode($seq,$secret,$count){
		if($secret==0)
		if(strpos($_SERVER['REQUEST_URI'],$this->kseq[$seq[$count]])>0){
	
		//echo 'matched<br>';
		//echo $this->kseq[$seq[$count]];
		//echo ' with<br>';
		//echo $_SERVER['REQUEST_URI'];
		$count++;
		//echo 'updatedcount'.$count."<br>";
		}
		else{
		//echo 'dint match';
		$count=0;
		}
		$_SESSION['count']=$count;
		//here is a variable change
		if($count==4){
		echo 'Entered secret mode<br>';
		$_SESSION['secret']=1;
		//more code for displaying secret msgs
		}
		
	}
	
	public function CreateInsertQueryString($table,$values)
	{
		return "INSERT INTO $table VALUES('','$values[0]','$values[1]','$values[2]')";
		
	}
	public function CreateSelectQueryString($table)
	{
		return "select * from $table";
	}
	
	
}
?>
