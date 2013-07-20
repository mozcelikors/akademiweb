<?php
/**
 *
 * theWebBlog PHP Türkçe Fonksiyon Kütüphanesi
 *
 * @author : Mustafa Özçelikörs
 *
 * @webSite : thwebblog.net
 *
 * @contact : mozcelikors@gmail.com
 *
 */

class theWebBlog
{
	public function hataNo($hataNo){
		switch ($hataNo){
			case 1: printf("Ölümcül bir hata ile karsilasildi. Sistem kapatilacak."); exit(); break;
			case 2: printf("Veritabani hatasiyla karsilasildi."); break;
			default: printf("Sebebi bilinmeyen bir hata ile karistirildi. Kütüphane dosyalarinda bir hata var.");
			
		}
	}
}

class oturumClass extends theWebBlog
{
	public function __construct(){
		if(!$_SESSION)
			session_start() or parent::hataNo(1); // Eger oturum baslamazsa hata sayfasina yönlendiriyoruz. // parent metodu
	}
	public function __destruct(){
		if($_SESSION)
			session_destroy() or parent::hataNo(1);  // Eger oturum bitirilemezse hata sayfasina yönlendiriyoruz.
	}
	public function oturumDegiskeniKaydet($oturumDegiskeni,$verilecekDeger){
		$_SESSION[$oturumDegiskeni]=$verilecekDeger;
	}
	public function oturumDegiskeniSil($oturumDegiskeni){
		unset($_SESSION[$oturumDegiskeni]);
		if(!($_SESSION[$oturumDegiskeni]==NULL))
			$_SESSION[$oturumDegiskeni]=NULL;
	}
	public function md5OturumDegiskeniKaydet($oturumDegiskeni){ 
		try{
			self::oturumDegiskeniKaydet($oturumDegiskeni,md5(rand())); 
			if(!$oturumDegiskeni){ throw new Exception('Oturum Degiskeni yok',1); }
			}catch(Exception $error){
				trigger_error($error->getMessage(),E_USER_ERROR);
			}
	}
	public function randOturumDegiskeniKaydet($oturumDegiskeni){
		$_SESSION[$oturumDegiskeni]=rand();
	}

	public function oturumDegiskeniGoster($oturumDegiskeni){
		return $_SESSION[$oturumDegiskeni];
	}
	public function oturumBaslat(){
		if(!$_SESSION)
			session_start();
	}
	public function oturumBitir(){
		if($_SESSION)
			session_destroy();
	}
}

class xmlClass extends theWebBlog
{
	public function externalXMLGetir($extDosya){
		if(!$xml2 = simplexml_load_file($extDosya))
 			exit('Dosya Açilamadi.');
		$xml2_veri=file_get_contents($extDosya);
		return $xml2_veri;
	}
	public function internalXMLGetir($intDosya){
		if( file_exists($intDosya) ){
			$xmlveri =	simplexml_load_file($intDosya);
		}else{
			echo "Dosya Açilamadi.";	
			exit();
		}
		$xml=file_get_contents($intDosya);
		return $xml;
	}
}

class mysqlClass extends theWebBlog
{
	public function mysqlBaslat($database_baglanti, $hostname_baglanti, $username_baglanti, $password_baglanti){
		if(!$baglanti)
			$baglanti = mysql_pconnect($hostname_baglanti, $username_baglanti, $password_baglanti) or trigger_error(mysql_error(),E_USER_ERROR);
		mysql_select_db($database_baglanti,$baglanti) or parent::hataNo(2);
	}
	public function mysqlBitir($baglantiIsmi){
		mysql_close($baglantiIsmi) or parent::hataNo(2);
	}
	public function mysqlSorgu($sorgu){
		mysql_query($sorgu) or parent::hataNo(2);
	}
	public function mysqlVeriGetir($veriSorgusu){
		mysql_fetch_assoc($veriSorgusu) or parent::hataNo(2);
	}
}


class matematikClass extends theWebBlog
{
	public function ortalama($argumanlar){
	/**
	 *
	 * Kullanimi matematikClass::ortalama("sayi1,sayi2,sayi3,..");
	 *
	 */
		$sayac=0;
		$toplam=0;
		$elemanlar=explode(",", $argumanlar);
		if(is_array($elemanlar)){
			for($i=0 ; $i<count($elemanlar) ; $i++){
				$toplam += $elemanlar[$i];
				$sayac++;
			}
		}
		if(!($sayac==0)){
			return ($toplam/$sayac);
		}
	
	}
	public function faktoriyel($faktoriyelAlinacakSayi){
	/**
	 *
	 * Kullanimi matematikClass::faktoriyel(faktoriyelAlinacakSayi);
	 *
	 */
	 	$carpim=1;
		for($i=$faktoriyelAlinacakSayi ; $i>=1 ; $i--){
			$carpim *= $i;}
		return $carpim;
	}
}

class uyeLoginClass
{
	public function uyeLogin(){
		try{
			if($_SERVER['PHP_AUTH_USER']==""){
				$uyari='Lutfen kullanici kimligi giriniz';
				header('WWW-Authenticate :Basic-realm="'.$uyari.'"');
				header('HTTP/1.0 401 Unauthorized');
				echo 'Lütfen kullanici bilgilerinizi giriniz';
				exit;
			}else{
				$username='deneme';
				$sifre='deneme';
				
				if($_SERVER['PHP_AUTH_USER']==$username && $_SERVER['PHP_AUTH_PW']==$password){
					echo 'Kullanici kimligi dogru';}
				else{
					echo 'Kullanici kimligi yanlis';
					throw new Exception('Kullanici kimligi yanlis');}
			}		
		}catch(Exception $error){
				trigger_error($error->getMessage(),E_USER_ERROR); }
	}
}


class tarihClass extends theWebBlog
{
	public function tarihAl($tip){
		if($tip=="gercekZaman"){
			$timeDamgasi=time();
			$zaman = date("d/m/Y - H:i",$timeDamgasi);
			return $zaman;
		}else{
			return date("d/m/Y - H:i");
		}
	}
}


/**
 * mysqlClass::mysqlBaslat("jquery20","localhost","root","mo_2011");
 * $sorgu = mysqlClass::mysqlSorgu("SELECT * FROM `yonetici` WHERE `id`='1'");
 * $dizi = mysqlClass::mysqlVeriGetir("SELECT * FROM `yonetici` WHERE `id`='1'");
 * echo $dizi['adisoyadi']; 
 * mysqlClass::mysqlBitir(); 
 *
 */
		
	
?>