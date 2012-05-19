<?php
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

mysql_connect("localhost","davidtan824","Keepsecret") or die (mysql_error());


mysql_select_db("SRHP") or die (mysql_error());


$query="SELECT name, ertime,latitude,longitude FROM facilities";

$result=mysql_query($query);

if(!result){
	die (mysql_error."\n");
}

header('Content-type: text/xml');

echo '<facilities>';

while ($row=mysql_fetch_assoc($result)){
	
	echo '<facility>';
	echo '<name>';
	echo $row['name'];
	echo '</name>';
	echo '<ertime>';
	echo $row['ertime'];
	echo '</ertime>';
	echo '<latitude>';
	echo $row['latitude'];
	echo '</latitude>';
	echo '<longitude>';
	echo $row['longitude'];
	echo '</longitude>';
	
	echo '</facility>';
	
}
echo '</facilities>';



?>