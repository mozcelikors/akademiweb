$(document).ready(function(){
	$('#tema').change(
	function (){
	var a=$(this).val();
	if(document.form1.tema.value=='Kirmizi'){
		$('#Yesil').fadeOut(1);
		$('#Mavi').fadeOut(1);
  		$('#Kirmizi').delay(200).fadeIn(400);	
	}
	if(document.form1.tema.value=='Mavi'){
		$('#Kirmizi').fadeOut(1);
		$('#Yesil').fadeOut(1);
  		$('#Mavi').delay(200).fadeIn(400);
	}
	if(document.form1.tema.value=='Yesil'){
		$('#Mavi').fadeOut(1);
		$('#Kirmizi').fadeOut(1);
  		$('#Yesil').delay(200).fadeIn(400);	
	}
	if(!(document.form1.tema.value=='')){
		$('#temathumbnailGosterMetin').show();
	}
	})

})
