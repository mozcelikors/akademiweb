function sifremiDegistirKontrol(){
	if(document.form1.user.value && document.form1.pass.value && document.form1.pass2.value){
		if(document.form1.pass.value==document.form1.pass2.value){
			return true;
		}else{
			alert("Girdiginiz iki sifre birbirini tutmuyor. L�tfen sifrenizi tekrar kontrol ediniz.");
			return false;
		}
	}else{
		alert("L�tfen hi� bir alani bos birakmayin.");
		return false;
	}
}