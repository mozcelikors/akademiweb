<?php
// @author : Mustafa Özçelikörs
// @webSite : www.thewebblog.net
// @contact : mozcelikors@gmail.com

class ButonOlustur{
	private function filtrele($bunu){
		return strip_tags(addslashes($bunu));
	}
	public function __construct(){
		header("Content-type: image/png");
		self::verileriAl();
		self::opsiyonlar();
		self::butonOlustur();
		self::degiskeniDegistir();
		self::bitis();
	}
	public function verileriAl(){
		global $veriler;
		$veriler = array(self::filtrele($_GET['ders']),self::filtrele($_GET['ozellik']),self::filtrele($_GET['yapilanIs']));
	}
	public function opsiyonlar(){
			global $yapilanIs,$ozellik,$rm;
			switch($yapilanIs){
				case "ekle":
					switch($ozellik){
						case "varsayilan":  $rm=imagecreatefrompng("../images/bosbutonekle.png"); break;
						case "hover": $rm=imagecreatefrompng("../images/bosbutonhekle.png"); break;
					} break;
			
				case "cikar":
					switch($ozellik){
						case "varsayilan":  $rm=imagecreatefrompng("../images/bosbutoncikar.png"); break;
						case "hover": $rm=imagecreatefrompng("../images/bosbutonhcikar.png"); break;
					} break;
			}
	}
	public function butonOlustur(){
		global $rm1,$rm,$ders,$KISAISIM,$siyah;
		$rm1=imagecreate(250,80);
		imagecolorallocate($rm1,100,100,100);
		$KISAISIM=$ders;
	}
	
	public function degiskeniDegistir(){
		global $KISAISIM,$ilkDizi,$ikinciDizi;
		$ilkDizi = array(" ","i","Ý","ý","Ö","Ü","Ç","ç","ü","g","&","ö");
		$ikinciDizi = array(" ","i","I","i","O","U","C","c","u","g"," ","o");
		if(count($ilkDizi) == count($ikinciDizi)){
			for($i=0; $i<=count($ilkDizi) ; $i++ ){
				$KISAISIM = strtr($KISAISIM,$ilkDizi[$i],$ikinciDizi[$i]);
			}
		}
	}
	public function bitis(){
		global $rm1,$rm,$siyah,$KISAISIM;
		imagecopy($rm1,$rm,0,0,0,0,250,80);
		imagettftext($rm1,12,0,68,36,$siyah,"DersButonu_ttf/calibri.ttf",$KISAISIM);
		imagepng($rm1);
	}

}


$getir      =          new ButonOlustur;





?>