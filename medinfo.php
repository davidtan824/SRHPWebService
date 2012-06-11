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

	
	$medlineplusurl='http://apps.nlm.nih.gov/medlineplus/services/mpconnect.cfm?mainSearchCriteria.v.cs=2.16.840.1.113883.6.88&mainSearchCriteria.v.c='.$drxcui.'&mainSearchCriteria.v.dn=&informationRecipient.languageCode.c=en';
	
	
	header('Content-type: text/xml');
	$html=file_get_html($medlineplusurl);
	
	foreach($html->find('.drugResults dt a') as $e) 
	{
		
		$detailurl=$e->href;
	
		$detailhtml=file_get_html($detailurl);
		
		echo '<entries>';
		echo '<generic>';
		echo $e->innertext;
		echo '</generic>';
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
		break;
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

