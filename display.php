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
$UCID = GET("UCID",$flag);
$pass = GET("pass",$flag);
$amount = GET("amount",$flag);

if($flag){exit("<br>Failed: empty input field");}

if (auth($ucid, $pass, $db ) == false) { 
	exit("Bad Credentials Probabaly");
   }; 

if (($sendMail = GET("receipt",$flag) == "yes"){}   

display ($ucid, $db, $amount, $output) ;

print "<br>bye" ;
mysqli_free_result($t);
mysqli_close($db);
exit ( "<br>Interaction completed.<br><br>"  ) ;

?>