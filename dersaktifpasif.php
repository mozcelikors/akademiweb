<?php 
// @author : Mustafa Özçelikörs
// @webSite : www.thewebblog.net
// @contact : mozcelikors@gmail.com
ob_start();
session_start();
include('Connections/YoneticiOnaylama.php') ;
require_once('Connections/yunusnet.php');
echo "<br /><br /><center>";
if(    ($_SESSION['MM_UserGroup']=="5") && isset($_SESSION['MM_Username'])  ){

		if(strip_tags($_GET['pasifID'])){
			$islem="pasiflestir";
			$pasifID=$_GET['pasifID'];
			$mesaj="Bu ders basariyla pasif hale getirilmistir.";
		}elseif(strip_tags($_GET['aktifID'])){
			$islem="aktiflestir";
			$aktifID=$_GET['aktifID'];
			$mesaj="Bu ders basariyla aktiflestirilmistir.";		
		}else{
			$mesaj="Uygun veriler alinamadigi için islem gerçeklestirilememistir";
		}
		mysql_select_db($database_yunusnet,$yunusnet);
		switch($islem){
			case "pasiflestir": 
								mysql_query("UPDATE `dersler` SET `aktif`='hayir' WHERE `id`='{$pasifID}'");
								echo "<h1 style=\"	color:#3399CC;
										text-shadow:#FFFFFF 1px 1px 1px;
										font-size:29px;
										font-family:'Calibri','Arial';\">".$mesaj."</h1>";
								echo "<p style=\"font-family:'Calibri'; font-size:19px;\">Yönlendiriliyorsunuz,bekleyin.</p>";
								header( "refresh:1; url=dersleriduzenle.php" );
								break;
			case "aktiflestir": 
								mysql_query("UPDATE `dersler` SET `aktif`='evet' WHERE `id`='{$aktifID}'");
								echo "<h1 style=\"	color:#3399CC;
										text-shadow:#FFFFFF 1px 1px 1px;
										font-size:29px;
										font-family:'Calibri','Arial';\">".$mesaj."</h1>";
								echo "<p style=\"font-family:'Calibri'; font-size:19px;\">Yönlendiriliyorsunuz,bekleyin.</p>";
								header( "refresh:1; url=dersleriduzenle.php" );
								break;
			default: 
								echo "<h1>".$mesaj."</h1>";
								break;
								
		}
		
		
}else{ exit(); }
echo "</center><br /><br />";

ob_end_flush();
?>