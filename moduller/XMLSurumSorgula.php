<?php 

// @author: Mustafa �z�elik�rs
// @webSite: www.thewebblog.net
// @contact: mozcelikors@gmail.com

function sayiyaCevir($string)
{
     $pattern = '/[^0-9]/';
     return preg_replace($pattern, '', $string);
}

if( file_exists('xml/surum.xml') ){
	$xmlveri =	simplexml_load_file('xml/surum.xml');
}else{
	echo "Dosya A�ilamadi.";	
	exit();
}
$xml=file_get_contents('xml/surum.xml');



$file='http://www.thewebblog.net/akademiweb/guncel_surum_xml/surum.xml'; // Web sitesindeki s�r�m
if(!$xml2 = simplexml_load_file($file))
  exit('Dosya A�ilamadi.'.$file);
$xml2_veri=file_get_contents('http://www.thewebblog.net/akademiweb/guncel_surum_xml/surum.xml');

/*if(sayiyaCevir($xml2_veri) > sayiyaCevir($xml)){*/

?>