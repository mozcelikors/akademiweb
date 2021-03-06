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
<?php include('Connections/YoneticiOnaylama.php') ;?>
<?php require_once('Connections/yunusnet.php'); ?><?php
// Oturumu Ba�lat�yoruz

$ders=strip_tags($_GET['ders']);

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
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "5";
$MM_donotCheckaccess = "false";

// �ye Giri�i: Y�netici harici giri�leri engelleme
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // En ba�ta g�venlik i�in �yenin yetkilerini tamamen k�s�tl�yoruz. 
  $isValid = False; 

// �ye giri� yapt���nda $_SESSION['MM_Username'] Oturum de�i�kenine atanacak. Bu �ekilde bu de�i�keni denetleyerek �yenin giri� yap�p yapmad���n� �l�ece�iz.
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO dersicerik (dosyabasligi, dosyaaciklamasi, ders, dosyalinki) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['dosyabasligi'], "text"),
                       GetSQLValueString($_POST['dosyaaciklamasi'], "text"),
					   GetSQLValueString($ders, "text"),
                       GetSQLValueString($_POST['dosyalinki'], "text"));

  mysql_select_db($database_yunusnet, $yunusnet);
  $Result1 = mysql_query($insertSQL, $yunusnet) or die(mysql_error());
}

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

$colname_dersbilgileri = "-1";
if (isset($_GET['ders'])) {
  $colname_dersbilgileri = (get_magic_quotes_gpc()) ? $_GET['ders'] : addslashes($_GET['ders']);
}
mysql_select_db($database_yunusnet, $yunusnet);
$query_dersbilgileri = sprintf("SELECT * FROM dersler WHERE kisaisim = '%s'", $colname_dersbilgileri);
$dersbilgileri = mysql_query($query_dersbilgileri, $yunusnet) or die(mysql_error());
$row_dersbilgileri = mysql_fetch_assoc($dersbilgileri);
$totalRows_dersbilgileri = mysql_num_rows($dersbilgileri);
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
    <div id="menulinki" ><a class="jquery<?=$i?>" href="iletisim.php">�leti�im</a></div>
    <?php if($_SESSION['MM_UserGroup']!=="5"){ ?>
    <div id="menulinki"  ><a class="jquery<?=++$i?>" href="yoneticigirisi.php">Y�netici Giri�i</a></div>
    <?php } ?>
    <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
    <div id="aktifmenulinki" ><a class="jquery<?=++$i?>" href="yoneticipaneli.php">Y�netici Paneli </a></div>
    <?php  } ?>
    <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
    <div id="menulinki" ><a class="jquery<?=++$i?>" href="logout.php">Sistemden ��k��</a></div>
    <?php  } ?>
  </div>
  <div id="icerik"><?php if(strip_tags($_GET['asama'])=="1"){ ?>
  <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="dosyaekle_asama2.php?ders=<?=$ders?>">
    <table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="46"><h1><strong><?php echo $row_dersbilgileri['dersismi']; ?> - Dosya Ekle</strong></h1></td>
      </tr>
      <tr>
        <td><table class="innerIcerik" width="444" height="55" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="425"><input style="padding:20px 20px 20px 20px; font-family:'Calibri', Arial, Times, serif; border:#999999 1px solid;" type="file" id="formalani" name="dosya" size="40">
		  <input name="submit" type="submit" id="formGonder" value="Y�kle" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>�</td>
        </tr>
    </table>
  </form><?php }else{echo "<br /><h1><font color=\"red\">BU ALANA BU �EK�LDE ULA�AMAZSINIZ !</font></h1>";
  exit;} ?>
  <?php if(strip_tags($_GET['asama'])=="2"){ ?>
<?php 
$kaynak = $_FILES["dosya"]["tmp_name"];
$dosyaadi = $_FILES["dosya"]["name"];
$dosyatipi = $_FILES["dosya"]["type"];
$dboyut	= $_FILES["dosya"]["size"];
$hedef = "dosyalar/dersicerik/";

$uzanti	= substr($dosyaadi, -4);

?><?php 

chmod("dosyalar/dersicerik/",0777);


?><?php 


$yeniad = $ders.substr(md5(uniqid(rand())), 0,10);

$yeniresimadi = $yeniad.$uzanti;

$yukle = move_uploaded_file($kaynak,$hedef.'/'.$yeniresimadi);

if($yukle){
	echo "<br><center>Dosya ba�ar�yla yuklendi<br></center><br>";
	
	}else{
	echo "<br><center>Dosya Yuklenemedi<br></center><br>";
	
	}
	
// echo "Dosyan�n Geldi�i yer : ".$kaynak."<br>";
echo "Dosyan�n ad� : ".$dosyaadi."<br>";
echo "Dosyan�n tipi : ".$dosyatipi."<br>";
echo "Dosyan�n boyutu :".$dboyut." byte.<br>";


?>
<form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="99%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="19%">&nbsp;</td>
      <td width="48%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td height="30" class="unvan2">Dosya Ba�l��� </td>
      <td><input name="dosyabasligi" type="text" class="giris" id="dosyabasligi" value=" " /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="27"><span class="unvan2">Dosya A��klamas� </span></td>
      <td><textarea name="dosyaaciklamasi" cols="50" rows="6" id="dosyaaciklamasi" class="giris"> </textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="27">&nbsp;</td>
      <td><input name="dosyalinki" type="hidden" id="dosyalinki" value="<?php echo $hedef.'/'.$yeniresimadi; ?>" />
        <input type="submit" name="Submit" id="formGonder" value="Dosyay� Kaydet" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="20">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>


<?php } ?>
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
</body>
</html>
<?php
mysql_free_result($bilgiler);

mysql_free_result($menudersler);

mysql_free_result($dersbilgileri);
?>
<?php ob_end_flush(); ?>