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
$ucid = GET("UCID",$flag);
$pass = GET("pass",$flag);
$num = GET("number",$flag);

if($flag){exit("<br>Failed: empty input field");}

if (auth($ucid, $pass, $db ) == false) { 
	exit("Bad Credentials Probabaly");
   }; 

display ($ucid, $db, $num, $output) ;
 
$headers = "";
  
if (GET("receipt",$flag) == "email"){
	mailer("psn24@njit.edu", "Display Transactions", $output, $headers);
}   

echo $output;
echo "Sucess!!";

mysqli_free_result($t);
mysqli_close($db);
exit ( "<br>Interaction completed.<br><br>"  ) ;

?>