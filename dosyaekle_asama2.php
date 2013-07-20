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
<?php include('Connections/YoneticiOnaylama.php') ;?>
<?php require_once('Connections/yunusnet.php'); ?><?php
// Oturumu Baþlatýyoruz

$ders=strip_tags($_GET['ders']);
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO dersicerik (dosyabasligi, dosyaaciklamasi, did, ders, dosyalinki) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['dosyabasligi'], "text"),
                       GetSQLValueString($_POST['dosyaaciklamasi'], "text"),
					   GetSQLValueString($_POST['did'], "text"),
					   GetSQLValueString($ders, "text"),
                       GetSQLValueString($_POST['dosyalinki'], "text"));
/*	
	Duyuru Ekleme Opsiyonudur.	   
	$duyurudid=strip_tags($_POST['did']);
	$duyurulink="duyurular_dosyadetay.php?did=".$duyurudid; 
	$duyuruaciklamasi=strip_tags($_POST['dosyabasligi']);
	$duyuruDosyaLink=strip_tags($_POST['dosyalinki']);	
	$tarih=date(d.".".m.".".Y)." ".date(H.":".i);	   
	$duyuruekle =mysql_query("INSERT INTO duyurular (duyurulink, duyuruaciklamasi, tarih, duyurudosyalink, did) VALUES ('$duyurulink','$duyuruaciklamasi','$tarih','$duyuruDosyaLink','$duyurudid')");
*/	


  mysql_select_db($database_yunusnet, $yunusnet);
  $Result1 = mysql_query($insertSQL, $yunusnet) or die(mysql_error());

  $insertGoTo = "yoneticipaneli.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
.style3 {font-size: 12px; font-weight: bold; }
#Layer1 {position:absolute;
	left:51px;
	top:49px;
	width:691px;
	height:83px;
	z-index:1;
}
.style1 {font-size: 12px}
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
<br />
<?php 
$kaynak = $_FILES["dosya"]["tmp_name"];
$dosyaadi = $_FILES["dosya"]["name"];
$dosyatipi = $_FILES["dosya"]["type"];
$dboyut	= $_FILES["dosya"]["size"];
$hedef = "dosyalar/dersicerik";

/* Dosya tiplerini engelliyoruz */
$fileName = strtolower($_FILES['dosya']['name']);
$whitelist = array('jpg', 'png', 'gif', 'jpeg','pdf','doc','xls','ppt','pptx','docx'); #example of white list
$backlist = array('php', 'php3', 'php4', 'phtml','exe','txt'); #example of black list
if(!in_array(end(explode('.', $fileName)), $whitelist))
{
        echo 'Dosya türü desteklenmiyor';
        exit(0);
}
if(in_array(end(explode('.', $fileName)), $backlist))
{
        echo 'Dosya türü desteklenmiyor';
        exit(0);
}
/*----------------------*/

$uzanti	= substr($dosyaadi, -4);


$yeniad = substr(md5(uniqid(rand())), 0,10);

$yeniresimadi = $ders.$yeniad.".".$uzanti;

$yukle = move_uploaded_file($kaynak,$hedef.'/'.$yeniresimadi);

if($yukle){
	echo "<h1>Dosya baþarýyla yuklendi<br></h1><br>";
	
	}else{
	echo "<h1>Dosya Yuklenemedi</h1><br><br>";
	
	}
	
// echo "Dosyanýn Geldiði yer : ".$kaynak."<br>";
echo "Dosyanýn adý : ".$dosyaadi."<br>";
echo "Dosyanýn tipi : ".$dosyatipi."<br>";
echo "Dosyanýn boyutu :".$dboyut." byte.<br>";


?>
<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <table class="innerIcerik" width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="20%" height="30"><span class="unvan2">Dosya Baþlýðý </span></td>
      <td width="47%"><input name="dosyabasligi" type="text" class="giris" id="dosyabasligi" value=" " /></td>
      </tr>
    <tr>
      <td height="27" valign="top"><span class="unvan2">Dosya Açýklamasý </span></td>
      <td><textarea name="dosyaaciklamasi" cols="50" rows="6"  class="giris" id="dosyaaciklamasi"> </textarea></td>
      </tr>
    <tr>
      <td height="52">&nbsp;</td>
      <td><input name="dosyalinki" type="hidden" id="dosyalinki" value="<?php echo $hedef.'/'.$yeniresimadi; ?>" />
        <input name="did" type="hidden" id="did" value="<?php echo md5(rand(0,10000)); ?>" />
        <input type="submit" name="Submit" id="formGonder" value="Dosyayý Kaydet" /></td>
      </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>

  

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
mysql_free_result($bilgiler);

mysql_free_result($menudersler);
?>
<?php ob_end_flush(); ?>