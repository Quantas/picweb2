<?php
if(isset($_SERVER['HTTP_REFERER']) && ( strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']) >= 0))
{
$id=$_GET['pic'];//get id
$size=$_GET['size'];
$hostname_picweb = "database";
$database_picweb = "picweb2";
$username_picweb = "picweb2";
$password_picweb = "picweb2";
$picweb = mysql_pconnect($hostname_picweb, $username_picweb, $password_picweb) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_select_db($database_picweb, $picweb);

$query = "SELECT p.$size, p.type FROM picture p WHERE p.id = $id";
$result = mysql_query($query) or die('Error, query failed');
$content=mysql_result($result,0,$size); //get content
$type=mysql_result($result,0,"type");//get type
header("Content-type: $type");

if (substr($type, 0, 5) == "image"){
echo base64_decode(stripslashes($content));
}
mysql_free_result($result); //close database connection
}
else
{
    echo 'You cannot access images this way.';
}
?>