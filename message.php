<?php
require_once 'dbconn.php';
require_once 'header.php';
$page=new Page();
//here is a variable change
if(strpos($_SERVER['PHP_SELF'],"add")>0){
$page->title.='Add Messages';
$page->fn='Add';
}//here is a variable change
else if(strpos($_SERVER['PHP_SELF'],"list")>0){
$page->title.='List Messages';
$page->fn='List';
}
$page->DisplayTitle();
?>


<body>
<header>
<?php $page->DisplayNav();
if(isset($_SESSION['username'])){
	//logged in user, now check which function is required
	//knock check
	//something like
	//$k_arr[$seq[$count]] and current REQUEST URI have the same stuff
	//$count++;
	//else reset count
	$count=$_SESSION['count'];
	$kseq=$_SESSION['kseq'];
	$secret=$_SESSION['secret'];
	$seq=str_split($kseq);
	//echo 'here';
	//echo $count;
	$page->CheckSecretMode($seq,$secret,$count);
?>
<h3>Welcome to CSE 591 - Your Message center - <?php echo $_SESSION['username']?> </h3>
</header>
<?php

if($page->fn=='Add'){
//add message fnality
	if(isset($_REQUEST['submit'])){
		//here is a variable change
		$values[0]=$dbconn->real_escape_string($_SESSION['username']);
		$values[1]=$dbconn->real_escape_string(htmlentities($_REQUEST['title']));
		$values[2]=$dbconn->real_escape_string(htmlentities($_REQUEST['message']));
		
		if(trim($values[1])==''||trim($values[2])==''){
		$page->DisplayError('Cant be empty');
		//die();
		}
	$secret=$_SESSION['secret'];
	//echo $secret."hhhhh";
	$query='';
	if($secret==1){
		//add to secret msgs
		//echo 'here';
		$query.=$page->CreateInsertQueryString('secret_msgs',$values);
		}
	else{
		//add to normal msgs
		//echo 'durp';
		$query.=$page->CreateInsertQueryString('messages',$values);
		}
		$res=$dbconn->query($query);
		
		if($res)
		echo 'Successfully added message';
	}
		//here is a variable change
?>
<form name="create-message" id="create-message" action="../message/add" method="post">
<label for="title">Title:
</label>
<input type="text" name="title" id="title" placeholder="Title here" required>
<label for="message">Message:
</label>
<textarea rows="12" cols="80" name="message" id="message" placeholder="Type your message here" required></textarea>
<input type="submit" value="Submit" name="submit">

</form>
<?php
		
		
}
else if($page->fn=='List'){
//list msg fnality	
$secret=$_SESSION['secret'];
$query='';
if($secret==1){
	//display secret messages
	$query.=$page->CreateSelectQueryString('secret_msgs');
	}
else{
	//display normal msgs
	$query.=$page->CreateSelectQueryString('messages');
	}

	$res=$dbconn->query($query);
	while($row=$res->fetch_array(MYSQLI_NUM))
		{	//here is a variable change
			echo '<div class="message">';
			$page->DisplayMessage(html_entity_decode($row[3]),'msg',$row[1],html_entity_decode($row[2]));
			echo '</div>';
		}
}

}
else{
	$page->DisplayError('You are not logged in.');
}
?>


</body>
</html>

