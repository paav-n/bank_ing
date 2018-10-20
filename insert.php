<?php
include("account.php") ;
include("myfunctions.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

$db = mysqli_connect($hostname,$username,$password,$project);
if (mysqli_connect_errno())
  {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
     exit();
  }

mysqli_select_db( $db, $project );


$flag = false;
$UCID = GET("UCID",  $flag);
$pass = GET("pass", $flag);
$name = GET("name",$flag);
$mail = GET("mail", $flag);
$initial = GET ("initial", $flag);
if($flag){exit("<br>Failed: empty input field");}

if (($sendMail = GET("receipt",$flag) == "yes"){}

insert($UCID, $pass, $name, $mail, $initial, $db);

print "<br>bye" ;
//mysqli_free_result($t);
mysqli_close($db);
exit ( "<br>Interaction completed.<br><br>"  ) ;


?>