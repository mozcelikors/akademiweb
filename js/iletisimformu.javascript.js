function iletisimKontrol(){
	if(document.form1.isim.value && document.form1.mail.value && document.form1.mesaj.value){
		return true;
	}else{
		alert("L�tfen hi� bir alani bos birakmayin.");
		return false;
	}
}