<!--
/**********
 * AkademiWeb A��k Kaynak Kodlu Dosya ve ��erik Y�netim Sistemi
 * Resmi web sayfas� http://akademiweb.thewebblog.net
 * @author mozcelikors
 *****/
-->


<?php ob_start(); ?>
<?php if (!isset($_SESSION)) {
  session_start();
}
?>
<?php require_once('Connections/yunusnet.php'); ?><?php
// Oturumu Ba�lat�yoruz


//------------------

  $_GET['dosyaID']=addslashes(mysql_real_escape_string(trim(strip_tags($_GET['dosyaID']))));
  $_GET['dosyaID'] = preg_replace("/\<\?php.+\?\>/isUe", "", $_GET['dosyaID']);
  $_GET['dosyaID'] = preg_replace("/\<\?.+\?\>/isUe", "", $_GET['dosyaID']);
  $_GET['dosyaID'] = preg_replace("/<script[^>]*>.*?< *script[^>]*>/i", "", $_GET['dosyaID']);
  $_GET['dosyaID'] = preg_replace("/<script[^>]*>.*<*script[^>]*>/i", "", $_GET['dosyaID']);
  $_GET['dosyaID'] = preg_replace("/<script[^>]*>/i", "", $_GET['dosyaID']);
  $_GET['dosyaID'] = preg_replace("/<style[^>]*>.*<*style[^>]*>/i", "", $_GET['dosyaID']);
  $_GET['dosyaID'] = preg_replace("/<style[^>]*>/i", "", $_GET['dosyaID']);


//----------------



// ** Giri� yapm�� �ye i�in �ye ��k��� yap�yoruz**
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  // �ye ve Oturum de�i�kenlerini temizliyoruz
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
if (isset($_GET['dosyaID'])) {
  $colname_dosyadetay = (get_magic_quotes_gpc()) ? $_GET['dosyaID'] : addslashes($_GET['dosyaID']);
}
mysql_select_db($database_yunusnet, $yunusnet);
$query_dosyadetay = sprintf("SELECT * FROM dersicerik WHERE dosyaID = %s", $colname_dosyadetay);
$dosyadetay = mysql_query($query_dosyadetay, $yunusnet) or die(mysql_error());
$row_dosyadetay = mysql_fetch_assoc($dosyadetay);
$totalRows_dosyadetay = mysql_num_rows($dosyadetay);

mysql_select_db($database_yunusnet, $yunusnet);
$query_bilgiler = "SELECT * FROM bilgiler";
$bilgiler = mysql_query($query_bilgiler, $yunusnet) or die(mysql_error());
$row_bilgiler = mysql_fetch_assoc($bilgiler);
$totalRows_bilgiler = mysql_num_rows($bilgiler);

mysql_select_db($database_yunusnet, $yunusnet);
$query_menudersler = "SELECT * FROM dersler WHERE `aktif`='evet' ORDER BY id ASC";
$menudersler = mysql_query($query_menudersler, $yunusnet) or die(mysql_error());
$row_menudersler = mysql_fetch_assoc($menudersler);
$totalRows_menudersler = mysql_num_rows($menudersler);
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
.style2 {font-size: 12px}
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
    <div id="menulinki" ><a class="jquery<?=$i?>" href="iletisim.php">�leti�im</a></div>
    <?php if($_SESSION['MM_UserGroup']!=="5"){ ?>
    <div id="menulinki"  ><a class="jquery<?=++$i?>" href="yoneticigirisi.php">Y�netici Giri�i</a></div>
    <?php } ?>
    <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
    <div id="menulinki" ><a class="jquery<?=++$i?>" href="yoneticipaneli.php">Y�netici Paneli </a></div>
    <?php  } ?>
    <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
    <div id="menulinki" ><a class="jquery<?=++$i?>" href="logout.php">Sistemden ��k��</a></div>
    <?php  } ?>
  </div>
  <div id="icerik">
  <span class="style1">Dosya y�klenirken beklemeniz gerekmektedir. | Dosyay� g�r�nt�leyemiyorsan�z Google Chrome kullanmay� deneyiniz. | <a href="<?php echo $row_dosyadetay['dosyalinki']; ?>">Dosyay� Kaydet</a>  </span>
  <iframe src="<?php echo $row_dosyadetay['dosyalinki']; ?>" scrolling="yes" width="100%" height="<?php 
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
  <div style="padding:20px; font-size:12px;" id="altkisim">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="67%" class="unvan2" style="font-size:14px;" align="left"><div id="menulinkibas"><?php echo $row_bilgiler['isim']; ?> | Ki�isel Web Sayfas�</div><div id="menulinki2" style="display:none;" >
        <table style="padding:20px; border:#999999 1px dotted; margin:10px;" width="689" border="0" cellspacing="0" cellpadding="0">
          <tr><td width="301" rowspan="3"><img src="images/logo.png" width="300" height="70" /></td>
            <td><span class="style9">Sistem Geli�tirme ve Tasar�m</span></td>
			<td width="177" height="24"><span class="style1">Mustafa �z�elik�rs </span></td>
            
            
            <td width="18" align="right"><img  style="display:none;" id="kapat" src="images/X-Icon.gif" width="18" height="18" /></td>
          </tr>
          <tr>
            <td width="191"><span class="style9">Kullan�lan Teknolojiler</span></td>
			<td height="24" colspan="2"><span class="style1">PHP, mySQL, jQUERY, AJAX, XML, JavaScript, CSS</span></td>
            </tr>
          <tr>
            <td><span class="style9">S�r�m</span></td>
			<td height="24" colspan="2"><span class="style1"><?php 
/* Simple XML ile s�r�m al�yoruz. */
if( file_exists('xml/surum.xml') ){
	$xmlveri =	simplexml_load_file('xml/surum.xml');
}else{
	echo "Dosya A��lamad�.";	
	exit();
}

$xml=file_get_contents('xml/surum.xml');

	echo $xml;
?></span></td>
           </tr>
        </table>
        </div></td>
      <td width="1%" class="unvan2" style="font-size:14px;" align="center"></td>
      <td width="32%" align="right"><span class="style1">Bu web sitesi <a href="http://akademiweb.thewebblog.net" target="_blank" class="link"><em>AkademiWeb</em></a> i�erik y�netim sistemi ile olu�turulmu�tur. <br />
          <br />
          <input id="menulinki1" type="submit"  name="Submit2" value="AkademiWeb A��k Kaynak Kodlu Dinamik Web Sistemi" />
      </span></td>
    </tr>
  </table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($dosyadetay);

mysql_free_result($bilgiler);

mysql_free_result($menudersler);
?>
<?php ob_end_flush(); ?>