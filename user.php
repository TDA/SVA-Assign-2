<?php
require_once 'dbconn.php';
require_once 'header.php';
$page=new Page();
//here is a variable change
if(strpos($_SERVER['PHP_SELF'],"register")>0){
$page->title.='Register';
$page->fn='Register';
}//here is a variable change
else if(strpos($_SERVER['PHP_SELF'],"login")>0){
$page->title.='Login';
$page->fn='Login';
}//here is a variable change
else if(strpos($_SERVER['PHP_SELF'],"logout")>0){
$page->title.='Logout';
$page->fn='Logout';
}
else{
$page->title.='Home';
$page->fn='Home';
}
$page->DisplayTitle();
?>


<body>
<header>
<?php $page->DisplayNav();?>
<h3>Welcome to CSE 591 </h3>

</header>
<div class="center">
<?php

if($page->fn=='Register'){
	if(isset($_SESSION['username'])){
		$page->DisplayError('You are already logged in. Log out before registering again');	
		$count=$_SESSION['count'];
		$kseq=$_SESSION['kseq'];
		$secret=$_SESSION['secret'];
		$seq=str_split($kseq);
		//echo 'here';
		$page->CheckSecretMode($seq,$secret,$count);	 //knock check
	}
	else if(isset($_REQUEST['submit'])){
		//here is a variable change
		$username=htmlentities($_REQUEST['username']);
		$password=htmlentities($_REQUEST['password']);
		$password_confirm=htmlentities($_REQUEST['password_confirm']);
		if($password!=$password_confirm){
			$page->DisplayError('Passwords don\'t match, please try again');	
		}
		$username=$dbconn->real_escape_string($username);
		$password=$dbconn->real_escape_string($password);
		$query="select * from users where username='$username'";
		$res=$dbconn->query($query) or "q error";
		//var_dump($res);
		if($res&&($res->num_rows)>0){
			$page->DisplayError('Username already exists');
			
		}
		
		
		$password=SHA1($password);
		$md5=MD5($username);
		//here is a variable change
		$md5_4=substr($md5,0,4);
		$each_val=str_split($md5_4);
		$num_value;
		$str='';
		for($i=0;$i<count($each_val);$i++)
			$num_value[$i]= hexdec($each_val[$i])%4;
			//here is a variable change
		foreach($num_value as $v)
			$str.=$v;
		//echo $str;
		$query="insert into users values('','$username','$password','$str')";
		//echo $_SERVER['REQUEST_URI'];
		$res=$dbconn->query($query) or "insert error";
		if($res){
			$page->DisplayMessage('Registered Successfully.','success','','');
			}
	}
	else{
?>
<h3>Registration</h3>

<p>To begin the registration process please enter your preferred username and password</p>

<form action="../user/register" method="post" name="register">
	<label for="username">User Name:
	</label>
	<input type="text" placeholder="Enter User Name here" id="username" name="username" required maxlength="32">
	<label for="password">Password:
	</label>
	<input type="password" placeholder="Password" id="password" name="password" required>
    <label for="password_confirm">Password-Confirm:
	</label>
	<input type="password" placeholder="Password" id="password_confirm" name="password_confirm" required>
<input type="submit" value="Signup" name="submit">
</form>
<?php //here is a variable change
	}
}
else if($page->fn=='Login'){
	if(isset($_SESSION['username'])){
	$page->DisplayError('You are already logged in.');	
	$count=$_SESSION['count'];
	$kseq=$_SESSION['kseq'];
	$secret=$_SESSION['secret'];
	$seq=str_split($kseq);
	//echo 'here';
	$page->CheckSecretMode($seq,$secret,$count);
		 //knock check
	}
	else if(isset($_REQUEST['submit'])){
		//here is a variable change
		$username=htmlentities($_REQUEST['username']);
		$password=htmlentities($_REQUEST['password']);
		
		$username=$dbconn->real_escape_string($username);
		$password=$dbconn->real_escape_string($password);
		
		$password=SHA1($password);
		$query="select * from users where username='$username' AND password='$password'";
		$res=$dbconn->query($query) or "q error";
		if($res&&($res->num_rows)==0){
			$page->DisplayError('Username or password is incorrect. Please try again');
		}
		else{
			$row=$res->fetch_assoc();
			$_SESSION['kseq']=$row['kseq'];
			$_SESSION['count']=0;
			$_SESSION['secret']=0;
			$_SESSION['username']=$username;
			$page->DisplayMessage('You are now logged in.','success','','');
		}
	}
	else{
	
//here is a variable change	
?>
<h3>Login</h3>

<p>Please enter your username and password</p>

<form action="../user/login" method="post" name="login">
	<label for="username">User Name:
	</label>
	<input type="text" placeholder="Enter User Name here" id="username" name="username" required maxlength="32">
	<label for="password">Password:
	</label>
	<input type="password" placeholder="Password" id="password" name="password" required>
    
	    
<input type="submit" value="Login" name="submit">
</form>

<?php
	}
}
else if($page->fn=='Logout'){
$uname=$_SESSION['username'];
echo $uname." Logged Out";
session_destroy();
header('Location:../user/home');
}
else if($page->fn=='Home')
echo "Use the links to navigate";
?>

</div>
</body>
</html>
