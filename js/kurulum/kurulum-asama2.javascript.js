function kontrolAsama2(){
	if( (document.form2.unvanveisim.value) && (document.form2.universite.value)  && (document.form2.derssayisi.value) && (document.form2.derssayisi.value>0) ){
		return true;
	}else{
		if(document.form2.derssayisi.value<=0) alert('Ders sayisi en az 1 olmalidir.');
		else alert('Lütfen ilgili alanlari uygun sekilde doldurunuz.');
		return false;
		}		
}