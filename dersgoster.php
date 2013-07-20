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
<?php require_once('Connections/yunusnet.php'); ?>
<?php require_once('Connections/yunusnet.php'); ?><?php
// Oturumu Baþlatýyoruz
//------------------------

  $_POST['aranacak'] = addslashes(strip_tags($_POST['aranacak']));
  $_POST['aranacak'] = preg_replace("/\<\?php.+\?\>/isUe", "", $_POST['aranacak']);
  $_POST['aranacak'] = preg_replace("/\<\?.+\?\>/isUe", "", $_POST['aranacak']);
  $_POST['aranacak'] = preg_replace("/<script[^>]*>.*?< *script[^>]*>/i", "", $_POST['aranacak']);
  $_POST['aranacak'] = preg_replace("/<script[^>]*>.*<*script[^>]*>/i", "", $_POST['aranacak']);
  $_POST['aranacak'] = preg_replace("/<script[^>]*>/i", "", $_POST['aranacak']);
  $_POST['aranacak'] = preg_replace("/<style[^>]*>.*<*style[^>]*>/i", "", $_POST['aranacak']);
  $_POST['aranacak'] = preg_replace("/<style[^>]*>/i", "", $_POST['aranacak']);
  
  $_GET['ders'] = addslashes(strip_tags(mysql_real_escape_string($_GET['ders'])));
  $ders=$_GET['ders'];

//-----------------------

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
$currentPage = $_SERVER["PHP_SELF"];

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

if ((isset($_POST['dosyaID'])) && ($_POST['dosyaID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM dersicerik WHERE dosyaID=%s",
                       GetSQLValueString($_POST['dosyaID'], "int"));
					   
					   


  mysql_select_db($database_yunusnet, $yunusnet);
  $Result1 = mysql_query($deleteSQL, $yunusnet) or die(mysql_error());
}

$maxRows_dersicerik = 10;
$pageNum_dersicerik = 0;
if (isset($_GET['pageNum_dersicerik'])) {
  $pageNum_dersicerik = $_GET['pageNum_dersicerik'];
}
$startRow_dersicerik = $pageNum_dersicerik * $maxRows_dersicerik;

$colname_dersicerik = "-1";
if (isset($_GET['ders'])) {
  $colname_dersicerik = (get_magic_quotes_gpc()) ? $_GET['ders'] : addslashes($_GET['ders']);
}
mysql_select_db($database_yunusnet, $yunusnet);
$query_dersicerik = sprintf("SELECT * FROM dersicerik WHERE ders = '%s' ORDER BY dosyaID DESC", $colname_dersicerik);
$query_limit_dersicerik = sprintf("%s LIMIT %d, %d", $query_dersicerik, $startRow_dersicerik, $maxRows_dersicerik);
$dersicerik = mysql_query($query_limit_dersicerik, $yunusnet) or die(mysql_error());
$row_dersicerik = mysql_fetch_assoc($dersicerik);

if (isset($_GET['totalRows_dersicerik'])) {
  $totalRows_dersicerik = $_GET['totalRows_dersicerik'];
} else {
  $all_dersicerik = mysql_query($query_dersicerik);
  $totalRows_dersicerik = mysql_num_rows($all_dersicerik);
}
$totalPages_dersicerik = ceil($totalRows_dersicerik/$maxRows_dersicerik)-1;

$colname_bulunanlar = "-1";
if (isset($_POST['aranacak'])) {
  $colname_bulunanlar = (get_magic_quotes_gpc()) ? $_POST['aranacak'] : addslashes($_POST['aranacak']);
}
mysql_select_db($database_yunusnet, $yunusnet);
$query_bulunanlar = sprintf("SELECT * FROM dersicerik WHERE dosyabasligi LIKE '%%%s%%' ORDER BY dosyaID DESC", $colname_bulunanlar);
$bulunanlar = mysql_query($query_bulunanlar, $yunusnet) or die(mysql_error());
$row_bulunanlar = mysql_fetch_assoc($bulunanlar);
$totalRows_bulunanlar = mysql_num_rows($bulunanlar);

$colname_dersbilgi = "-1";
if (isset($_GET['ders'])) {
  $colname_dersbilgi = (get_magic_quotes_gpc()) ? $_GET['ders'] : addslashes($_GET['ders']);
}
mysql_select_db($database_yunusnet, $yunusnet);
$query_dersbilgi = sprintf("SELECT * FROM dersler WHERE kisaisim = '%s'", $colname_dersbilgi);
$dersbilgi = mysql_query($query_dersbilgi, $yunusnet) or die(mysql_error());
$row_dersbilgi = mysql_fetch_assoc($dersbilgi);
$totalRows_dersbilgi = mysql_num_rows($dersbilgi);

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

$queryString_dersicerik = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_dersicerik") == false && 
        stristr($param, "totalRows_dersicerik") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_dersicerik = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_dersicerik = sprintf("&totalRows_dersicerik=%d%s", $totalRows_dersicerik, $queryString_dersicerik);
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
.style1 {font-size: 12px}
.style3 {font-size: 13px}
#Layer1 {position:absolute;
	left:51px;
	top:49px;
	width:691px;
	height:83px;
	z-index:1;
}
.style4 {font-size: 25px}
.style6 {font-size: 25px; color: #999999; }
.style7 {font-size: 15px}
.style11 {font-size: 11px; color: #333333; }
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
  <?php 
  	if($ders==$row_menudersler['kisaisim']) $menuStil="id=\"aktifmenulinki\""; else $menuStil="id=\"menulinki\"";
  ?>
    <div <?=$menuStil?>><a class="jquery<?=$i?>" href="dersgoster.php?ders=<?php echo $row_menudersler['kisaisim']; ?>"><?php echo $row_menudersler['dersismi']; ?></a></div>
    <?php $i++; } while ($row_menudersler = mysql_fetch_assoc($menudersler)); ?>
	<div id="menulinki" ><a class="jquery<?=$i?>" href="iletisim.php">Ýletiþim</a></div>
	<?php if($_SESSION['MM_UserGroup']!=="5"){ ?>
<div id="menulinki"  ><a class="jquery<?=++$i?>" href="yoneticigirisi.php">Yönetici Giriþi</a></div>
  <?php } ?>
  <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
  <div id="menulinki" ><a class="jquery<?=++$i?>" href="yoneticipaneli.php">Yönetici Paneli </a></div>
  <?php  } ?>
  <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
  <div id="menulinki" ><a class="jquery<?=++$i?>" href="logout.php">Sistemden Çýkýþ</a></div>
  <?php  } ?>
</div>
<div id="icerik">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="73%"><h1><?php echo $row_dersbilgi['dersismi']; ?>
        <?php if ($totalRows_dersicerik == 0) { // Show if recordset empty ?>
            <span class="style6">
          bölümüne henüz dosya eklenmemiþtir. </span>
              <?php } // Show if recordset empty ?>
        <span class="style4">        </span></h1></td>
      <td width="1%">&nbsp;</td>
      <td width="26%" align="right"><form id="form1" name="form1" method="post" action="">
        <input class="giris" id="formalani" style="padding:8px 5px 8px 5px;" name="aranacak" type="text"  />
        <input type="submit" name="Submit" id="formGonder" value="Ara" />
      </form>      </td>
    </tr>
  </table>
     <?php if ($totalRows_dersicerik > 0) { // Show if recordset not empty ?>
       <?php if ($totalRows_bulunanlar > 0) { // Show if recordset not empty ?>
         <?php do { ?>
           <table width="99%" border="0" cellpadding="0" cellspacing="0" background="images/dersarkaplan.png" style=" -webkit-border-top-left-radius:6px;
	 -webkit-border-top-right-radius:6px;
	 -webkit-border-bottom-right-radius:6px;
	 -webkit-border-bottom-left-radius:6px;
	 -moz-border-top-left-radius:6px;
	 -moz-border-top-right-radius:6px;
	 -moz-border-bottom-right-radius:6px;
	 -moz-border-bottom-left-radius:6px; padding:10px;
	 border:1px solid #999999;
	 box-shadow:1px 1px 2px white;">
             <tr>
               <td width="89%" height="48" style="padding-left:5px; " ><span class="style1"><span class="style3"><a href="dosyadetay.php?dosyaID=<?php echo $row_bulunanlar['dosyaID']; ?>" class="style7"><?php echo $row_bulunanlar['dosyabasligi']; ?></a></span><br />
               <span class="style11"><?php echo $row_bulunanlar['dosyaaciklamasi']; ?></span></span></td>
               <td width="5%" align="center" ><?php if($_SESSION['MM_UserGroup']=="5"){ ?>
                   <a href="dosyaguncelle.php?dosyaID=<?php echo $row_bulunanlar['dosyaID']; ?>"><span class="style1">[düzenle]</span></a>
                 <?php } ?></td>
               <td width="6%" align="center" ><?php if($_SESSION['MM_UserGroup']=="5"){ ?>
                   <form id="form2" name="form2" method="post" action="">
                     <input name="dosyaID" type="hidden" id="dosyaID" value="<?php echo $row_bulunanlar['dosyaID']; ?>" />
                     <input id="formGonder" type="submit"  name="Submit" value="Sil" />
                   </form>
                 <?php } ?></td>
             </tr>
          </table>
           <br/>
           <?php } while ($row_bulunanlar = mysql_fetch_assoc($bulunanlar)); ?>
         <?php } // Show if recordset not empty ?>
      <?php do { ?>
        <br/>
        <?php if ($totalRows_bulunanlar == 0) { // Show if recordset empty ?>
          <table width="99%" border="0" cellpadding="0" cellspacing="0" background="images/dersarkaplan.png" style=" -webkit-border-top-left-radius:6px;
	 -webkit-border-top-right-radius:6px;
	 -webkit-border-bottom-right-radius:6px;
	 -webkit-border-bottom-left-radius:6px;
	 -moz-border-top-left-radius:6px;
	 -moz-border-top-right-radius:6px;
	 -moz-border-bottom-right-radius:6px;
	 -moz-border-bottom-left-radius:6px; padding:10px;
	 border:1px solid #999999;
	 box-shadow:1px 1px 2px white;">
            <tr>
              <td width="89%" height="48" style="padding-left:5px; "><span class="style1"><span class="style7"><a href="dosyadetay.php?dosyaID=<?php echo $row_dersicerik['dosyaID']; ?>"><?php echo $row_dersicerik['dosyabasligi']; ?></a></span><br />
              <span class="style11"><?php echo $row_dersicerik['dosyaaciklamasi']; ?></span></span></td>
              <td width="5%" align="center" ><?php if($_SESSION['MM_UserGroup']=="5"){ ?>
                <a id="formGonder" style="text-decoration:none; color:#FFFFFF;" href="dosyaguncelle.php?dosyaID=<?php echo $row_dersicerik['dosyaID']; ?>&amp;ders=<?=$ders?>">Düzenle</a>
              <?php } ?></td>
              <td width="6%" align="center" ><?php if($_SESSION['MM_UserGroup']=="5"){ ?>
                <form id="form2" name="form2" method="post" action="">
                  <input name="dosyaID" type="hidden" id="dosyaID" value="<?php echo $row_dersicerik['dosyaID']; ?>" />
                  <input type="submit" id="formGonder" name="Submit2" value="Sil" />
                </form>
              <?php } ?></td>
            </tr>
          </table>
          <?php } // Show if recordset empty ?>
        <?php } while ($row_dersicerik = mysql_fetch_assoc($dersicerik)); ?>
       <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_bulunanlar > 0) { // Show if recordset not empty ?>
     
        <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_bulunanlar > 0) { // Show if recordset not empty ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="0%"><p>&nbsp;</p></td>
            
          </tr>
        </table>
        <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_bulunanlar == 0) { // Show if recordset empty ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="0%"><p>&nbsp;</p> </td>
            <td width="10%"><?php if ($pageNum_dersicerik > 0) { // Show if not first page ?>
                  <p class="style3"><a  id="formGonder" style="color:#FFFFFF; text-decoration:none;" href="<?php printf("%s?pageNum_dersicerik=%d%s", $currentPage, max(0, $pageNum_dersicerik - 1), $queryString_dersicerik); ?>">&lt;&lt; Önceki</a> </span></p>
                      <?php } // Show if not first page ?>            </td>
            <td width="10%"><?php if ($pageNum_dersicerik < $totalPages_dersicerik) { // Show if not last page ?>
                 <p><span class="style3"><a  id="formGonder" style="color:#FFFFFF; text-decoration:none;" href="<?php printf("%s?pageNum_dersicerik=%d%s", $currentPage, min($totalPages_dersicerik, $pageNum_dersicerik + 1), $queryString_dersicerik); ?>">Sonraki &gt;&gt; </a></span></p>
                  <?php } // Show if not last page ?>            </td>
            <td width="10%">&nbsp;</td>
            <td width="70%" align="right"><span class="style3">&nbsp;<?php echo $totalRows_dersicerik ?> dosya var.<br />
            <?php echo ($startRow_dersicerik + 1) ?>- <?php echo min($startRow_dersicerik + $maxRows_dersicerik, $totalRows_dersicerik) ?> arasý gösteriliyor.</span> </td>
          </tr>
      </table>
          <?php } // Show if recordset empty ?><p>&nbsp;</p>
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
mysql_free_result($dersicerik);

mysql_free_result($bulunanlar);

mysql_free_result($dersbilgi);

mysql_free_result($bilgiler);

mysql_free_result($menudersler);
?>
<?php ob_end_flush(); ?>