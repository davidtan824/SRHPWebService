<?php
	include_once('simple_html_dom.php');
	function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

	$drugname=$_GET["drugname"];
	$url='http://rxnav.nlm.nih.gov/REST/rxcui?name='.$drugname;
	$xml = simplexml_load_file($url);
	
	$mname=$xml->idGroup[0]->name;
	$drxcui=$xml->idGroup[0]->rxnormId;
	//echo $drxcui.'<br/>';

	$medlineplusurl='http://apps2.nlm.nih.gov/medlineplus/services/mpconnect_service.cfm?mainSearchCriteria.v.cs=2.16.840.1.113883.6.88&mainSearchCriteria.v.c='.$drxcui;
	
	$medlinexml=simplexml_load_file($medlineplusurl);
	
	$link=$medlinexml->entry->link->attributes()->href;
	$html=file_get_html($link);
	
	foreach($html->find('.drugResults dt a') as $e) 
	{
		$detailurl=$e->href;
	
		$detailhtml=file_get_html($detailurl);
		header('Content-type: text/xml');
		echo '<entries>';
		
		$titles=$detailhtml->find('h2');
		
		foreach($titles as $title){
			if(($title->innertext!='Notice:')&&($title->innertext!='Brand names')){
			echo '<entry>';
			echo '<title>'.$title->innertext.'</title>';
		
			$titlediv=$title->parent();
			echo '<detail>'.parseToXML(getblurb($titlediv)).'</detail>';
			
			
			echo '</entry>';
			}
		}
		
		echo '</entries>';
	}
	
	function getblurb($e){
		$blurb="";
		if(($e->next_sibling()->tag=='p')||($e->next_sibling()->tag=='h3')){
			
			$blurb.=$e->next_sibling()->innertext;
			
			getblurb($e->next_sibling());
			
			return $blurb;
		}else{
			return;
		}
		
		
	}
	
    
		
	
	
?>

