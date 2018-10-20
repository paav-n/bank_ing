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
{ 
	exit("Bad Credentials Probabaly");
}; 

if (($sendMail = GET("receipt",$flag) == "yes"){}

$s="select mail from AA where UCID='$UCID'";
$t = mysqli_query( $db,  $s );
$row=mysqli_fetch_row($t);
$theEmail = $row[0];

if($type == 'D'){
	echo "depositing";
	deposit ($UCID, $type, $theEmail, $amount, $output, $db);
}
if($type == 'W'){
	echo "requesting a withdraw";
	if(enough($UCID, $amount, $db, $output, $theEmail)){
		withdraw($UCID, $amount, $db);
	}
	else print("not enough");
}

print "<br>bye" ;
mysqli_free_result($t);
mysqli_close($db);
exit ( "<br>Interaction completed.<br><br>"  ) ;

?>