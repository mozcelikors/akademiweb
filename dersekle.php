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
<?php require_once('Connections/yunusnet.php'); ?>
<?php require_once('Connections/yunusnet1.php'); ?>
<?php
	/*   & (AND) iþaretini kabul etmiyor, elimine ediyoruz...
		 function etiketSakla html etiketlerini silip deðeri geri döndürür..
	}*/
	function etiketSakla ($metin){
		$metin = strip_tags ($metin);
	}
	etiketSakla($_POST['dersismi']);
	etiketSakla($_POST['kisaisim']);
	if(isset($_POST['dersismi']) || isset($_POST['kisaisim'])){
		$str     = (string) $_POST['kisaisim'];
		$str2     = (string) $_POST['dersismi'];
		$order   = array("&", "&", "&");
		$replace = ' ';
		$_POST['dersismi'] = str_replace($order, $replace, $str2);
		$_POST['kisaisim'] = str_replace($order, $replace, $str);
	}
   ?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO dersler (dersismi, kisaisim, aktif) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['dersismi'], "text"),
                       GetSQLValueString($_POST['kisaisim'], "text"),
					   GetSQLValueString('evet', "text"));

  mysql_select_db($database_yunusnet1, $yunusnet1);
  $Result1 = mysql_query($insertSQL, $yunusnet1) or die(mysql_error());

  $insertGoTo = "yoneticipaneli.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
.style3 {font-size: 17px}
-->
</style>
<script type="text/javascript" language="javascript">
	function kontrol(){
		if(document.form1.dersismi.value==""){
			alert("Lütfen hiç bir alaný boþ býrakmayýn.. ");
			return false;
			
		}
		if(document.form1.kisaisim.value==""){
			alert("Lütfen hiç bir alaný boþ býrakmayýn.. ");
			return false;
			
		}

		return true;

	}
</script>
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
      <h1>Ders Ekle</h1>
      <form id="form1" onsubmit="return kontrol()" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <table class="innerIcerik" width="504" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="223" height="34" class="unvan2 style3">Dersin Ýsmi </td>
            <td width="279"><input name="dersismi" type="text" class="giris" id="dersismi" style="padding:5px 5px 5px 5px;" /></td>
          </tr>
          <tr>
            <td height="34" class="unvan2 style3">Dersin Ýsmini Onayla </td>
            <td><input name="kisaisim" type="text" class="giris" id="kisaisim" style="padding:5px 5px 5px 5px;" /></td>
          </tr>
          <tr>
            <td height="27">&nbsp;</td>
            <td><input type="submit" name="Submit" id="formGonder" value="Dersi Ekle" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1">
    </form>
      <p><br />
          <br />
          <br />
          <br />
          <br />
          <br />
    </p>
      <p>&nbsp;</p>
    <p><br />
          <br />
          <br />
    </p>
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
?>
<?php ob_end_flush(); ?>