<?php
/**
 * TEMA SORGULAYAN SCRIPT
 *
 * @author Mustafa Özçelikörs
 *
 */ 
	require_once('Connections/yunusnet.php');
	mysql_select_db($database_yunusnet,$yunusnet);
	$sorgu=mysql_query("SELECT * FROM `yonetici` WHERE `id`='1'");
	$dizi=mysql_fetch_assoc($sorgu);
	$uygulananTema=$dizi['tema'];
		switch ($uygulananTema){
			case 'Mavi' :?> <link href="css/stil.css" rel="stylesheet" type="text/css" /><? break; 
			case 'Kirmizi' : ?> <link href="temalar/kirmizi_tema/stil.css" rel="stylesheet" type="text/css" /><? break;
			case 'Yesil' : ?> <link href="temalar/yesil_tema/stil.css" rel="stylesheet" type="text/css" /><? break;
			default : ?> <link href="css/stil.css" rel="stylesheet" type="text/css" /> <?
		}
?>

