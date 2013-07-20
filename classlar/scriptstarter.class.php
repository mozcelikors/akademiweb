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
interface Arayuz
{

}
class theWebBlogNetClass implements Arayuz
{
	public function hataNo($hataNo){
		switch ($hataNo){
			case 1: printf("Ölümcül bir hata ile karsilasildi. Sistem kapatilacak."); exit(); break;
			case 2: printf("Veritabani hatasiyla karsilasildi."); break;
			default: printf("Sebebi bilinmeyen bir hata ile karistirildi. Kütüphane dosyalarinda bir hata var.");
			
		}
	}
}

class scriptStarter extends theWebBlogNetClass implements Arayuz
{
	const sessionName='ASD';
	const host='localhost';
	const user='root';
	const pass='mo_2011';
	public function __construct(){
		ob_start() or parent::hataNo(1);
		if(!$_SESSION){ session_start() or parent::hataNo(1); }
		$sessionId = self::getSessionId();
		self::setSessionName();
		$sessionName = self::getSessionName();
		self::mysqlStart(self::host,self::user,self::pass);
	}
	public function __destruct(){
		mysql_close();
		session_destroy() or parent::hataNo(1);
		ob_end_flush() or parent::hataNo(1);	
	}
	private static function setSessionName(){
		return session_name(self::sessionName);
	}
	public static function getSessionName(){
		session_name(self::sessionName);
	}
	private static function getSessionId(){
		$val=session_id();
		return $val;
	}
	public function mysqlStart($host,$user,$pass){
		$mysqlConnection=mysql_connect($host,$user,$pass);
	}
}
$getir = new scriptStarter;
$_SESSION['A']='ASD';
echo $_SESSION['A'];
mysql_select_db("jquery20");
$sorgu=mysql_query("SELECT * FROM `yonetici` WHERE `id`='1'");
$dizi=mysql_fetch_assoc($sorgu);
echo  $dizi['pass'];
?>