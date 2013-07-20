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
<?php require_once('Connections/YoneticiOnaylama.php'); ?>
<?php require_once('Connections/yunusnet.php'); ?>
<?php require_once('Connections/yunusnet2.php'); ?><?php
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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "5";
$MM_donotCheckaccess = "false";

// Üye Giriþi: Yönetici harici giriþleri engelleme
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // En baþta güvenlik için üyenin yetkilerini tamamen kýsýtlýyoruz. 
  $isValid = False; 

// Üye giriþ yaptýðýnda $_SESSION['MM_Username'] Oturum deðiþkenine atanacak. Bu þekilde bu deðiþkeni denetleyerek üyenin giriþ yapýp yapmadýðýný ölçeceðiz.
  if (!empty($UserName)) { 
    
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "hata.php?hatakodu=1";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

if ((isset($_POST['id'])) && ($_POST['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM gelenmesajlar WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_yunusnet2, $yunusnet2);
  $Result1 = mysql_query($deleteSQL, $yunusnet2) or die(mysql_error());

  $deleteGoTo = "gelenkutusu.php?onayla=mesajsil";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_yunusnet, $yunusnet);
$query_menudersler = "SELECT * FROM dersler WHERE `aktif`='evet' ORDER BY id ASC";
$menudersler = mysql_query($query_menudersler, $yunusnet) or die(mysql_error());
$row_menudersler = mysql_fetch_assoc($menudersler);
$totalRows_menudersler = mysql_num_rows($menudersler);

mysql_select_db($database_yunusnet, $yunusnet);
$query_bilgiler = "SELECT * FROM bilgiler";
$bilgiler = mysql_query($query_bilgiler, $yunusnet) or die(mysql_error());
$row_bilgiler = mysql_fetch_assoc($bilgiler);
$totalRows_bilgiler = mysql_num_rows($bilgiler);

mysql_select_db($database_yunusnet, $yunusnet);
$query_yoneticidersler = "SELECT * FROM dersler WHERE `aktif`='evet' ORDER BY id ASC";
$yoneticidersler = mysql_query($query_yoneticidersler, $yunusnet) or die(mysql_error());
$row_yoneticidersler = mysql_fetch_assoc($yoneticidersler);
$totalRows_yoneticidersler = mysql_num_rows($yoneticidersler);

mysql_select_db($database_yunusnet2, $yunusnet2);
$query_gelenmesajlar = "SELECT * FROM gelenmesajlar ORDER BY id DESC";
$gelenmesajlar = mysql_query($query_gelenmesajlar, $yunusnet2) or die(mysql_error());
$row_gelenmesajlar = mysql_fetch_assoc($gelenmesajlar);
$totalRows_gelenmesajlar = mysql_num_rows($gelenmesajlar);
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
.style1 {font-size: 10px}
#Layer1 {position:absolute;
	left:51px;
	top:49px;
	width:691px;
	height:83px;
	z-index:1;
}
.style5 {color: #FFFFFF}
.style6 {font-family: 'Calibri', Arial, Helvetica, sans-serif}
.style7 {
	font-size: 24px;
	color: #999999;
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
    <h1>Gelen Kutusu<span class="style7">
      <?php if ($totalRows_gelenmesajlar == 0) { // Show if recordset empty ?>
        <br />
        Gelen kutusunda þu anda hiç
        mesaj bulunmamaktadýr.
        <?php } // Show if recordset empty ?></span></h1>
    <?php if ($totalRows_gelenmesajlar > 0) { // Show if recordset not empty ?>
      <table  class="innerIcerik" width="99%" height="99" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="38" background="images/mail_bg.png"><span style="padding-left:5px; font-weight:bold; font-size:14px;" class="style5">Gönderen</span></td>
          <td  background="images/mail_bg.png"><span class="style5" style="font-weight:bold; font-size:14px;">Mesaj</span></td>
          <td  background="images/mail_bg.png"><span style="font-weight:bold; font-size:14px;"class="style5">Tarih</span></td>
          <td  background="images/mail_bg.png"><span style="font-weight:bold; font-size:14px;"class="style5">Mesajý Sil </span></td>
        </tr>
        <tr>
          <?php do { ?>
          <?php if($row_gelenmesajlar['okunmus']==0){
		  	$tag1="<strong>";
		  	$tag2="</strong>";
		  }else{
		  unset($tag1);
		  unset($tag2);
		  	$tag1=NULL;
		 	 $tag2=NULL;
		  }
		  
		   ?>
          <td width="15%" height="40"><span style="padding-left:5px;"class="style6"><?php echo $row_gelenmesajlar['isim']; ?></span></td>
          <td width="60%"><span class="style6"><?=$tag1?><a href="mesajoku.php?mesajID=<?php echo $row_gelenmesajlar['id']; ?>"><?php echo substr($row_gelenmesajlar['mesaj'],0,60)."..."; ?></a><?=$tag2?>
          </span></td>
          <td width="15%"><span class="style6"><?php echo $row_gelenmesajlar['tarih']; ?></span></td>
          <td width="10%"><form id="form1" name="form1" method="post" onSubmit="
			if(confirm('Devam etmek istediðinize emin misiniz? Bu iþlem mesajý kalýcý olarak veritabanýndan silecektir.'))
				return true;
			else return false;
"action="">
            <input name="id" type="hidden" id="id" value="<?php echo $row_gelenmesajlar['id']; ?>" />
            <input name="onay" type="hidden" id="onay" value="evet" />
            <input type="submit" id="formGonder" name="Submit" value="Sil" />
          </form></td>
        </tr>
        <?php } while ($row_gelenmesajlar = mysql_fetch_assoc($gelenmesajlar)); ?>
</table>
      <?php } // Show if recordset not empty ?><p><br />
    </p>
      <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p><br />
    <br />
    <br />
    <br />
    <br />
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp; </p>
  </div>
</div>
<div style="padding:20px; font-size:12px;" id="altkisim">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="67%" class="unvan2" style="font-size:14px;" align="left"><div id="menulinkibas"><?php echo $row_bilgiler['isim']; ?> | Kiþisel Web Sayfasý</div><div id="menulinki2" style="display:none;" >
        <table style="padding:20px; border:#999999 1px dotted; margin:10px;" width="689" border="0" cellspacing="0" cellpadding="0">
          <tr><td width="301" rowspan="3"><img src="images/logo.png" width="300" height="70" /></td>
            <td><span class="style9">Sistem Geliþtirme ve Tasarým</span></td>
			<td width="177" height="24"><span class="style1">Mustafa Özçelikörs </span></td>
            
            
            <td width="18" align="right"><img  style="display:none;" id="kapat" src="images/X-Icon.gif" width="18" height="18" /></td>
          </tr>
          <tr>
            <td width="191"><span class="style9">Kullanýlan Teknolojiler</span></td>
			<td height="24" colspan="2"><span class="style1">PHP, mySQL, jQUERY, AJAX, XML, JavaScript, CSS</span></td>
            </tr>
          <tr>
            <td><span class="style9">Sürüm</span></td>
			<td height="24" colspan="2"><span class="style1"><?php 
/* Simple XML ile sürüm alýyoruz. */
if( file_exists('xml/surum.xml') ){
	$xmlveri =	simplexml_load_file('xml/surum.xml');
}else{
	echo "Dosya Açýlamadý.";	
	exit();
}

$xml=file_get_contents('xml/surum.xml');

	echo $xml;
?></span></td>
           </tr>
        </table>
        </div></td>
      <td width="1%" class="unvan2" style="font-size:14px;" align="center"></td>
      <td width="32%" align="right"><span class="style1">Bu web sitesi <a href="http://akademiweb.thewebblog.net" target="_blank" class="link"><em>AkademiWeb</em></a> içerik yönetim sistemi ile oluþturulmuþtur. <br />
          <br />
          <input id="menulinki1" type="submit"  name="Submit2" value="AkademiWeb Açýk Kaynak Kodlu Dinamik Web Sistemi" />
      </span></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($menudersler);

mysql_free_result($bilgiler);

mysql_free_result($yoneticidersler);

mysql_free_result($gelenmesajlar);
?>
<?php ob_end_flush(); ?>