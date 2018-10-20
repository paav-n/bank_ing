<?php
function GET( $fieldname, &$flag )
{
	global $db;
	$fie = trim( $_GET [$fieldname] );
	if ($fie == "") 
	  { $flag = true ; echo "<br><br>$fieldname is empty." ; return  ;} ;
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
function withdraw($UCID, $amount, $db, $output, $mail)//-----------------------------------------------------------------------------------------------------------------
{
	$s = "insert into TT values ( '$UCID', 'W', '$amount', NOW() , '$mail' )";  
	print "<br>SQL insert statement is: $s "; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	print "<br>SQL insert TT statement was transmitted for execution.<br>"; 
	
	$s = "update AA   set recent = NOW(), current = current - $amount where UCID = '$UCID' ";  
	print "<br>SQL update AA statement is: $s"; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	print "<br>SQL statement was transmitted for execution.<br>"; 
}
function deposit($UCID, $type, $mail, $amount, $output, $db)//------------------------------------------------------------------------------------------------------------------
{
	$s = "insert into TT values ( '$UCID', 'D', '$amount', NOW() , '$mail' )";  
	print "<br>SQL insert statement is: $s "; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	print "<br>SQL insert TT statement was transmitted for execution.<br>"; 
	
	$s = "update AA   set recent = NOW(), current = $amount + current where UCID = '$UCID' ";  
	print "<br>SQL update AA statement is: $s"; 
	($t = mysqli_query( $db,  $s ) ) or die( "<br>SQL error: " . mysqli_error($db) );
	print "<br>SQL statement was transmitted for execution.<br>"; 
}
mail ($to, $subject, $message,$headers)//--------------------------------------------------------------------------------------------------------------------------------
{
	
}
function insert($UCID, $pass, $name, $mail, $initial, $db)//--------------------------------------------------------------------------------------------------------------
{
	$s   =  "insert into AA values ( '$UCID', '$pass', '$name','$mail',$initial,'$initial',NOW(),'$pass' ) " ;
	print "<br>SQL insert statement is: $s<br>"; 
	($t = mysqli_query ( $db,  $s   ) )  or die( mysqli_error($db) );
	echo "<br>insert succeeded<br><br>";
}
function auth ( $ucid, $pass, $db )//---------------------------------------------------------------------------------------------------------------------------------
{
	global $t;
	$a   =  "select * from AA where ucid = '$ucid'  and pass = '$pass' " ;
    //print "<br><br>SQL select statement is: $a<br>"; 

	($t = mysqli_query ( $db,  $a ) )  or die ( mysqli_error ($db) );
	
	$rows = $t->num_rows;
	
	if($rows == 0) {
		return false;
	} 
	
	else { 
		print "<br>There were $rows rows retrieved from the table.<br><br>";
		return true; 
	}
}
function display ($ucid, $db, $amount, $output)//-----------------------------------------------------------------------------------------------------------------------------------------
{ 
  global $t;
  
  $s   =  "select * from TT where ucid = '$ucid'  " ;
  print "<br>SQL select statement is: $s<br>"; 
  
  ($t = mysqli_query ( $db,  $s   ) )  or die ( mysqli_error ($db) );
  $i=0;
  print "<table border=2  width = 30% >" ;
	  while ( $r = mysqli_fetch_array ( $t, MYSQL_ASSOC) ) 
	  {
		$ucid = $r[ "ucid" ] ;
		$type = $r[ "type" ] ;
		$amount = $r[ "amount" ] ;
		$date = $r[ "date" ] ;
		$mail = $r[ "mail" ] ;
		print "<tr>" ;
		echo "<td>$ucid</td>" ; 
		echo "<td>$type</td>" ;
		echo "<td>$amount</td>"; 
		echo "<td>$date</td>";
		echo "<td>$mail</td>";  
		print "</tr>" ;
		$i++;
		if(i>=$amount){
			break;
		}
	  };
    print "</table>";
}


?>