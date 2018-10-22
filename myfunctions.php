<?php
function GET( $fieldname, &$flag )
{
	global $db;
	$fie = trim( $_GET [$fieldname] );
	if ($fie == "") 
	  { $flag = true ; return  ;} ;
	$fie = mysqli_real_escape_string ($db, $fie );
	return $fie; 
}
function enough ($UCID, $amount, $db)//---------------------------------------------------------------------------------------------------------------------
{
	global $t ;

	$s = "select * from AA where ucid = '$UCID' and current >= '$amount' " ;
	echo "<br> $s <br>" ;
	($t = mysqli_query ($db, $s) ) or die ( mysqli_error($db) ) ;

	$num = mysqli_num_rows ( $t ) ;
	if ( $num == 0 ) {return false;}   else { return true;};		
}
function withdraw($UCID, $amount, $db, &$output, $mail)//-----------------------------------------------------------------------------------------------------------------
{
	$output = "";
	$s = "insert into TT values ( '$UCID', 'W', '$amount', NOW() , '$mail' )";  
	$output .= "<br>SQL insert statement is: $s "; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	$output .= "<br>SQL insert TT statement was transmitted for execution.<br>"; 
	
	$s = "update AA   set recent = NOW(), current = current - $amount where UCID = '$UCID' ";  
	$output .= "<br>SQL update AA statement is: $s"; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	$output .= "<br>SQL statement was transmitted for execution.<br>"; 
}
function deposit($UCID, $type, $mail, $amount, &$output, $db)//------------------------------------------------------------------------------------------------------------------
{
	$output = "";
	$s = "insert into TT values ( '$UCID', 'D', '$amount', NOW() , '$mail' )";  
	$output .= "<br>SQL insert statement is: $s "; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	$output .= "<br>SQL insert TT statement was transmitted for execution.<br>"; 
	
	$s = "update AA   set recent = NOW(), current = $amount + current where UCID = '$UCID' ";  
	$output .= "<br>SQL update AA statement is: $s"; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	$output .= "<br>SQL statement was transmitted for execution.<br>"; 
}
function mailer($to, $subject, $message,$headers)//--------------------------------------------------------------------------------------------------------------------------------
{
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <psn24@njit.edu>' . "\r\n";
	mail($to, $subject, $message,$headers);
}
function insert($UCID, $pass, $name, $mail, $initial, &$output, $db)//--------------------------------------------------------------------------------------------------------------
{
	$output = "";
	$s   =  "insert into AA values ( '$UCID', '$pass', '$name','$mail',$initial,'$initial',NOW(),'$pass' ) " ;
	$output .= "<br>SQL insert statement is: $s<br>"; 
	($t = mysqli_query ( $db,  $s   ) )  or die( mysqli_error($db) );
	$output .= "<br>insert succeeded<br><br>";
}
function auth ( $ucid, $pass, $db )//---------------------------------------------------------------------------------------------------------------------------------
{
	global $t;
	$a   =  "select * from AA where UCID = '$ucid'  and pass = '$pass' " ;
    //print "<br><br>SQL select statement is: $a<br>"; 

	($t = mysqli_query ( $db,  $a ) )  or die ( mysqli_error ($db) );
	
	$rows = $t->num_rows;
	
	if($rows == 0) {
		return false;
	} 
	
	else { 
		return true; 
	}
}
function display ($ucid, $db, $num, &$output)//-----------------------------------------------------------------------------------------------------------------------------------------
{ 
  global $t;
  
  $output = "";
  $s ="select * from TT where ucid = '$ucid' ORDER BY date DESC limit $num";
  $output .= "<br>SQL select statement is: $s<br>"; 
  ($t = mysqli_query ( $db,  $s   ) )  or die ( mysqli_error ($db) );
  if ($num == 0){$output .= "<br> $num rows retrieved.<br>"; return 0;};
  
  $output .= "<table border=2  width = 30% >" ;
	  while ( $r = mysqli_fetch_array ( $t, MYSQL_ASSOC) ) 
	  {
		$ucid = $r[ "UCID" ] ;
		$type = $r[ "type" ] ;
		$amount = $r[ "amount" ] ;
		$date = $r[ "date" ] ;
		$mail = $r[ "mail" ] ;
		$output .= "<tr>" ;
		$output .= "<td>$ucid</td>" ; 
		$output .= "<td>$type</td>" ;
		$output .= "<td>$amount</td>"; 
		$output .= "<td>$date</td>";
		$output .= "<td>$mail</td>";  
		$output .= "</tr>" ;
	  };
    $output .= "</table>";
	$s ="select * from AA where ucid = '$ucid'";
	$output .= "<br>SQL select statement is: $s<br>"; 
	($t = mysqli_query ( $db,  $s   ) )  or die ( mysqli_error ($db) );
	
	$output .= "<table border=2  width = 30% >" ;
	  while ( $r = mysqli_fetch_array ( $t, MYSQL_ASSOC) ) 
	  {
		$ucid = $r[ "UCID" ] ;
		$pass = $r[ "pass" ] ;
		$name = $r[ "name" ] ;
		$mail = $r[ "mail" ] ;
		$initial = $r[ "initial" ] ;
		$current = $r[ "current" ] ;
		$recent = $r[ "recent" ] ;
		$plaintext = $r[ "plaintext" ] ;
		$output .= "<tr>" ;
		$output .= "<td>$ucid</td>" ; 
		$output .= "<td>$pass</td>" ;
		$output .= "<td>$name</td>"; 
		$output .= "<td>$mail</td>";
		$output .= "<td>$initial</td>";  
		$output .= "<td>$current</td>";  
		$output .= "<td>$recent</td>";  
		$output .= "<td>$plaintext</td>";  
		$output .= "</tr>" ;
	  };
	  $output .= "</table>";
}


?>