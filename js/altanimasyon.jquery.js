//jQuery ile alt kisima animasyon yaziyoruz... 
$(document).ready(function(){
	$('#menulinki1').click(function(){
		$('#menulinki2').fadeIn(1000);
		$('#menulinkibas').fadeOut(100);
		$('#kapat').fadeIn(300);
		$("html,body").stop()
		.animate({scrollTop:"1000"},1000);		
	});
	
	$('#kapat').click(function(){
		$("html,body").stop()
		.animate({scrollBottom:"1000"},1000);	
		$('#menulinki2').fadeOut(100);
		$('#kapat').fadeOut(100);
	    $('#menulinkibas').fadeIn(1000);
	});
	
	
})