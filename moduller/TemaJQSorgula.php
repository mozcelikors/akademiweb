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
			case 'Mavi' :?> <script src="js/menuanimasyon.jquery.js"></script><? break; 
			case 'Kirmizi' : ?> <script src="temalar/kirmizi_tema/menuanimasyon.jquery.js"></script><? break;
			case 'Yesil' : ?> <script src="temalar/yesil_tema/menuanimasyon.jquery.js"></script><? break;
			default : ?> <script src="js/menuanimasyon.jquery.js"></script> <?
		}
?>

