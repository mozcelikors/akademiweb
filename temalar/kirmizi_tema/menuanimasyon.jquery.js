$(document).ready(function(){
	$('#menulinki a[class="jquery1"],#menulinki a[class="jquery2"],#menulinki a[class="jquery3"],#menulinki a[class="jquery4"],#menulinki a[class="jquery5"],#menulinki a[class="jquery6"],#menulinki a[class="jquery7"],#menulinki a[class="jquery8"],#menulinki a[class="jquery9"],#menulinki a[class="jquery10"],#menulinki a[class="jquery11"],#menulinki a[class="jquery12"],#menulinki a[class="jquery13"],#menulinki a[class="jquery14"],#menulinki a[class="jquery15"],#menulinki a[class="jquery16"],#menulinki a[class="jquery17"],#menulinki a[class="jquery18"],#menulinki a[class="jquery19"],#menulinki a[class="jquery20"]').hover(uzerinde,disinda);
	function uzerinde(){
		$(this).animate({
			opacity:0.6,
			fontSize:'16px',
			height:'+=5px',
			fontWeight:'bold',
			backgroundImage:'url(temalar/kirmizi_tema/menubutonh.png)'
		},200);
		
		
	}
	function disinda(){
		 $(this).css('backgroundImage','url(temalar/kirmizi_tema/menubuton.png)');
		 $(this).animate({
			 opacity:1,
			fontSize:'14px',
			height:'-=5px',
			fontWeight:'normal',
			backgroundImage:'url(temalar/kirmizi_tema/menubutonh.png)'
		
		},200);
	}
	
	$('#aktifmenulinki a').hover(uzerinde2,disinda2);
	function uzerinde2(){
		
		
		$(this).animate({
			opacity:0.7,
			fontSize:'16px',
			height:'+=5px',
			fontWeight:'bold',
			backgroundImage:'url(temalar/kirmizi_tema/menubutonapos.png)'
		},200);
		
	}
	function disinda2(){
		 $(this).animate({
			 opacity:1,
			fontSize:'14px',
			height:'-=5px',
			fontWeight:'normal',
			backgroundImage:'url(temalar/kirmizi_tema/menubutona.png)'
		
		},200);
	}
	
})
