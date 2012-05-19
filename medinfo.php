<?php
	
	$url='http://rxnav.nlm.nih.gov/REST/rxcui?name=lipitor';
	$xml = simplexml_load_file($url);
	$mname=$xml->idGroup[0]->name;
	$drxcui=$xml->idGroup[0]->rxnormId;
	echo $mname;
	if($drxcui){
		
		echo $drxcui;
	}else{
		echo 'no id';
	}
	
	
	/*
	$url='http://localhost/SRHPWebService/';
	$xml = simplexml_load_file($url);
	$lat=$xml->facility[0]->latitude;
	echo $lat;
	*/
	
?>