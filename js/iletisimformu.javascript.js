function iletisimKontrol(){
	if(document.form1.isim.value && document.form1.mail.value && document.form1.mesaj.value){
		return true;
	}else{
		alert("Lütfen hiç bir alani bos birakmayin.");
		return false;
	}
}