<!--
/**********
 * AkademiWeb Açýk Kaynak Kodlu Dosya ve Ýçerik Yönetim Sistemi
 * Resmi web sayfasý http://akademiweb.thewebblog.net
 * @author mozcelikors
 *****/
-->
<?php ob_start(); ?>
<?php if (!isset($_SESSION)) {
  session_start();
}
?>

<?php require_once('Connections/yunusnet.php'); ?><?php
// Oturumu Baþlatýyoruz
// ** Giriþ yapmýþ üye için üye çýkýþý yapýyoruz**
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  // Üye ve Oturum deðiþkenlerini temizliyoruz
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
$colname_dosyadetay = "-1";
if (isset($_GET['did'])) {
  $colname_dosyadetay = (get_magic_quotes_gpc()) ? $_GET['did'] : addslashes($_GET['did']);
}
mysql_select_db($database_yunusnet, $yunusnet);
$query_dosyadetay = sprintf("SELECT duyuruID, duyuruaciklamasi, duyurulink, did, duyurudosyalink FROM duyurular WHERE did = '%s'", $colname_dosyadetay);
$dosyadetay = mysql_query($query_dosyadetay, $yunusnet) or die(mysql_error());
$row_dosyadetay = mysql_fetch_assoc($dosyadetay);
$totalRows_dosyadetay = mysql_num_rows($dosyadetay);

mysql_select_db($database_yunusnet, $yunusnet);
$query_dersler = "SELECT * FROM dersler WHERE `aktif`='evet' ORDER BY id ASC";
$dersler = mysql_query($query_dersler, $yunusnet) or die(mysql_error());
$row_dersler = mysql_fetch_assoc($dersler);
$totalRows_dersler = mysql_num_rows($dersler);

mysql_select_db($database_yunusnet, $yunusnet);
$query_bilgiler = "SELECT * FROM bilgiler";
$bilgiler = mysql_query($query_bilgiler, $yunusnet) or die(mysql_error());
$row_bilgiler = mysql_fetch_assoc($bilgiler);
$totalRows_bilgiler = mysql_num_rows($bilgiler);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title><?php echo $row_bilgiler['isim']; ?> | <?php echo $row_bilgiler['universite']; ?></title>
<?php include('moduller/TemaSorgula.php'); ?>
<?php 
$tarayici=$_SERVER['HTTP_USER_AGENT'];
$firefox=eregi("Firefox",$tarayici);
if($firefox){?>
		<link rel="stylesheet" type="text/css" href="css/tarayici_firefox.css" /><?php } ?>
<?php  $ie9=eregi("MSIE 9.0",$tarayici);
		if($ie9){?>
		<link rel="stylesheet" type="text/css" href="css/tarayici_ie9.css" /><?php } ?>
<?php  $chrome=eregi("Chrome",$tarayici);
		if($chrome){?>
		<link rel="stylesheet" type="text/css" href="css/tarayici_chrome.css" /><?php } ?>

		<link rel="stylesheet" type="text/css" href="css/gorseller.css" />
		<link rel="stylesheet" type="text/css" href="css/dinamikler.css" />
		<link rel="icon" type="image/x-icon" href="ikon.ico" />
		
		
<?php include('eklemeler/eklemeler.php'); ?>

<style type="text/css">
<!--
.style1 {font-size: 11px}
#Layer1 {position:absolute;
	left:51px;
	top:49px;
	width:691px;
	height:83px;
	z-index:1;
}
-->
</style>
<script src="js/jquery-1.6.4.js"></script>
<script src="js/altanimasyon.jquery.js"></script>
<?php include('moduller/TemaJQSorgula.php'); ?>
</head>

<body>
<div id="cevreleyen">
  <div id="ust">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <div id="Layer1"><span class="unvan"><?php echo $row_bilgiler['isim']; ?></span><br />
      <span class="unvan2"><?php echo $row_bilgiler['universite']; ?></span></div>
  <div id="menu">
    <div id="menulinki" ><a class="jquery1" href="index.php">Anasayfa</a></div>
    <?php $i=2; do {  ?>
    <div id="menulinki"  ><a class="jquery<?=$i?>" href="dersgoster.php?ders=<?php echo $row_menudersler['kisaisim']; ?>"><?php echo $row_menudersler['dersismi']; ?></a></div>
    <?php $i++; } while ($row_menudersler = mysql_fetch_assoc($menudersler)); ?>
    <div id="menulinki" ><a class="jquery<?=$i?>" href="iletisim.php">Ýletiþim</a></div>
    <?php if($_SESSION['MM_UserGroup']!=="5"){ ?>
    <div id="menulinki"  ><a class="jquery<?=++$i?>" href="yoneticigirisi.php">Yönetici Giriþi</a></div>
    <?php } ?>
    <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
    <div id="aktifmenulinki" ><a class="jquery<?=++$i?>" href="yoneticipaneli.php">Yönetici Paneli </a></div>
    <?php  } ?>
    <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
    <div id="menulinki" ><a class="jquery<?=++$i?>" href="logout.php">Sistemden Çýkýþ</a></div>
    <?php  } ?>
  </div>
  <div id="icerik">
  <span class="style1">Dosya yüklenirken beklemeniz gerekmektedir. | Dosyayý görüntüleyemiyorsanýz Google Chrome kullanmayý deneyiniz. | <a href="<?php echo $row_dosyadetay['duyurudosyalink']; ?>">Dosyayý Kaydet</a>  </span>
  <iframe src="<?php echo $row_dosyadetay['duyurudosyalink']; ?>" scrolling="yes" width="100%" height="<?php 
  $tarayiciAl=$_SERVER['HTTP_USER_AGENT'];
  $tarayici_ie9=eregi("MSIE 9.0",$tarayiciAl);
  if($tarayici_ie9){
  echo "450px";
  }
  $tarayici_chrome=eregi("Chrome",$tarayiciAl);
  if($tarayici_chrome){
  echo "88%";
  }
  $tarayici_firefox=eregi("Firefox",$tarayiciAl);
  if($tarayici_firefox){
  echo "450px";
  }
  ?>" />
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($dosyadetay);

mysql_free_result($dersler);

mysql_free_result($bilgiler);
?>
<?php ob_end_flush(); ?>