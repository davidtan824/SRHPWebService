<?php
	include_once('simple_html_dom.php');
	$drugname=$_GET["drugname"];
	$url='http://rxnav.nlm.nih.gov/REST/rxcui?name='.$drugname;
	$xml = simplexml_load_file($url);
	
	$mname=$xml->idGroup[0]->name;
	$drxcui=$xml->idGroup[0]->rxnormId;
	
	if($drxcui){
		
		//echo $drxcui;
	}else{
		echo 'no id';
	}
	$medlineplusurl='http://apps2.nlm.nih.gov/medlineplus/services/mpconnect_service.cfm?mainSearchCriteria.v.cs=2.16.840.1.113883.6.88&mainSearchCriteria.v.c='.$drxcui;
	
	$medlinexml=simplexml_load_file($medlineplusurl);
	
	$link=$medlinexml->entry->link->attributes()->href;
	$html=file_get_html($link);
	foreach($html->find('.drugResults dt a') as $e) 
	
	echo '<a href="'.$e->href.'">'.$e->innertext.'</a>';
    
		
	
	
?>

