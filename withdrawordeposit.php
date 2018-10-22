<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);

include ("account.php") ;
$db = mysqli_connect($hostname,$username, $password ,$project);
if (mysqli_connect_errno())
  {	  
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
print "Successfully connected to SQL.<br>";
mysqli_select_db( $db, $project ); 
include ( "myfunctions.php" ) ;

$flag = false;
$UCID = GET("UCID2",$flag);
$pass = GET("pass2",$flag);
$amount = GET("amount",$flag);
$type = GET("type",$flag);

if($flag){exit("<br>Failed: empty input field");}

if (auth($UCID, $pass, $db) == false)
{ exit("Bad Credentials Probabaly");}; 

if (GET("receipt",$flag) == "email"){
	$mail = 'Y';
}else{$mail = 'N';}

if($type == 'D'){
	echo "depositing";
	deposit ($UCID, $type, $mail, $amount, $output, $db);
}
if($type == 'W'){
	echo "requesting a withdraw";
	if(enough($UCID, $amount, $db)){
		withdraw($UCID, $amount, $db, $output, $mail);
	}
	else {$output =("not enough");}
}

$headers = "";

if (GET("receipt",$flag) == "email"){
	mailer("psn24@njit.edu", "Withdraw or Deposit", $output, $headers);
}   

echo $output;

mysqli_free_result($t);
mysqli_close($db);
exit ( "<br>Interaction completed.<br><br>"  ) ;

?>