
$(document).ready(function(){
	$('#menulinki a[class="jquery1"],#menulinki a[class="jquery2"],#menulinki a[class="jquery3"],#menulinki a[class="jquery4"],#menulinki a[class="jquery5"],#menulinki a[class="jquery6"],#menulinki a[class="jquery7"],#menulinki a[class="jquery8"],#menulinki a[class="jquery9"],#menulinki a[class="jquery10"],#menulinki a[class="jquery11"],#menulinki a[class="jquery12"],#menulinki a[class="jquery13"],#menulinki a[class="jquery14"],#menulinki a[class="jquery15"],#menulinki a[class="jquery16"],#menulinki a[class="jquery17"],#menulinki a[class="jquery18"],#menulinki a[class="jquery19"],#menulinki a[class="jquery20"]').hover(uzerinde,disinda);
	function uzerinde(){
		$(this).animate({
			fontSize:'16px',
			height:'+=5px',
			fontWeight:'bold',
			backgroundImage:'url(images/menubutonh.png)'
		},200);
		$(this).css('backgroundImage','url(images/menubuton1h.png)');
		
	}
	function disinda(){
		 $(this).css('backgroundImage','url(images/menubuton.png)');
		 $(this).animate({
			fontSize:'14px',
			height:'-=5px',
			fontWeight:'normal',
			backgroundImage:'url(images/menubutonh.png)'
		
		},200);
	}
	
	$('#aktifmenulinki a').hover(uzerinde2,disinda2);
	function uzerinde2(){
		
		
		$(this).animate({
			fontSize:'16px',
			height:'+=5px',
			fontWeight:'bold',
			backgroundImage:'url(images/menubutonapos.png)'
		},200);
		$(this).css('backgroundImage','url(images/menubutonapos.png)');
		
	}
	function disinda2(){
		 $(this).css('backgroundImage','url(images/menubutona.png)');
		 $(this).animate({
			fontSize:'14px',
			height:'-=5px',
			fontWeight:'normal',
			backgroundImage:'url(images/menubutona.png)'
		
		},200);
	}
	
	
	
/* AKORDIYON MENÜ için jQUERY 
	$('#acilanmenulinki a[class="jquery1"],#acilanmenulinki a[class="jquery2"],#acilanmenulinki a[class="jquery3"],#acilanmenulinki a[class="jquery4"],#acilanmenulinki a[class="jquery5"],#acilanmenulinki a[class="jquery6"],#acilanmenulinki a[class="jquery7"],#acilanmenulinki a[class="jquery8"],#acilanmenulinki a[class="jquery9"],#acilanmenulinki a[class="jquery10"],#acilanmenulinki a[class="jquery11"],#acilanmenulinki a[class="jquery12"],#acilanmenulinki a[class="jquery13"],#acilanmenulinki a[class="jquery14"],#acilanmenulinki a[class="jquery15"],#acilanmenulinki a[class="jquery16"],#acilanmenulinki a[class="jquery17"],#acilanmenulinki a[class="jquery18"],#acilanmenulinki a[class="jquery19"],#menulinki a[class="jquery20"]').hover(uzerinde,disinda);
	function uzerinde(){
		
		$(this).animate({
			fontSize:'16px',
			height:'+=5px',
			fontWeight:'bold',
			backgroundImage:'url(images/menubutonh.png)'
		},200);
		$(this).css('backgroundImage','url(images/menubuton1h.png)');
		
	}
	function disinda(){
		 $(this).css('backgroundImage','url(images/menubuton.png)');
		 $(this).animate({
			fontSize:'14px',
			height:'-=5px',
			fontWeight:'normal',
			backgroundImage:'url(images/menubutonh.png)'
		
		},200);
	}
	
		$('#aktifmenulinki a').hover(uzerinde2,disinda2);
	function uzerinde2(){
		
		
		$(this).animate({
			fontSize:'16px',
			height:'+=5px',
			fontWeight:'bold',
			backgroundImage:'url(images/menubutonapos.png)'
		},200);
		$(this).css('backgroundImage','url(images/menubutonapos.png)');
		
	}
	function disinda2(){
		 $(this).css('backgroundImage','url(images/menubutona.png)');
		 $(this).animate({
			fontSize:'14px',
			height:'-=5px',
			fontWeight:'normal',
			backgroundImage:'url(images/menubutona.png)'
		
		},200);
	}
	

	$('#menulinki a[class="jquery2"]').click(function (){
		$('#acilanmenu').slideToggle(300);
	}); */
	
	
	
	
	
	
/* AKORDIYON MENÜ için HTML
<div id="menu">
  <div id="aktifmenulinki" ><a class="jquery1" href="index.php">Anasayfa</a></div>
  <div id="menulinki" ><a class="jquery2">Dersler</a></div>
  <div id="acilanmenu" style="display:none";>
  <?php $i=2; do {  ?>
    <div id="acilanmenulinki"><a class="jquery<?=$i?>" href="dersgoster.php?ders=<?php echo $row_dersler['kisaisim']; ?>"><?php echo $row_dersler['dersismi']; ?></a></div>
    <?php $i++; } while ($row_dersler = mysql_fetch_assoc($dersler)); ?>
	</div>
	<div id="menulinki"><a class="jquery<?=$i?>" href="iletisim.php">Iletisim</a></div>
	<?php if($_SESSION['MM_UserGroup']!=="5"){ ?>
<div id="menulinki"  ><a class="jquery<?=++$i?>" href="yoneticigirisi.php">Yönetici Girisi</a></div>
  <?php } ?>
  <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
  <div id="menulinki" ><a class="jquery<?=++$i?>" href="yoneticipaneli.php">Yönetici Paneli </a></div>
  <?php  } ?>
  <?php if($_SESSION['MM_UserGroup']=="5"){ ?>
  <div id="menulinki" ><a class="jquery<?=++$i?>" href="logout.php">Sistemden Çikis</a></div>
  <?php  } ?>
</div>
*/
	
	
	
	
	
	
	
	
	
/* AKORDIYON MENÜ için CSS
.aktifmenulinki{
	font-size:14px;
	display:block;

	
	background:url(../images/menubuton.png);
	color:white;
	
	text-decoration:none;
	 box-shadow:1px 1px 4px #CCCCCC;
	 text-shadow:1px 1px 1px #333333;

	 font-family:Arial, Helvetica, sans-serif;
}

#menulinki a{ 
	font-size:14px;
	display:block;
	padding:10px;
	margin-bottom:-1px;
	background-image:url(../images/menubuton.png);
	color:white;
	border:1px #155678 solid;
	text-decoration:none;
	 box-shadow:1px 1px 4px #CCCCCC;
	 text-shadow:1px 1px 1px #666666;

	 font-family:Arial, Helvetica, sans-serif;
	 
}

#acilanmenulinki a{ 
	font-size:14px;
	display:block;
	padding:10px;
	margin-bottom:-1px;
	background-image:url(../images/menubuton.png);
	color:white;
	border:1px #155678 solid;
	text-decoration:none;
	 box-shadow:1px 1px 4px #CCCCCC;
	 text-shadow:1px 1px 1px #333333;

	 font-family:Arial, Helvetica, sans-serif;
	 
}
*/









/*  BAZI DIPNOTLAR ve ALTERNATIFLER
$('#nav a')
	.css( {backgroundPosition: "0 0"} )
	.mouseover(function(){
		$(this).stop().animate(
			{backgroundPosition:"(0 -250px)"}, 
			{duration:500})
		})
	.mouseout(function(){
		$(this).stop().animate(
			{backgroundPosition:"(0 0)"}, 
			{duration:500})
		})
*/
/*$('#menulinki').hover(uzerinde,disinda);
	function uzerinde(){
		
		$(this).animate({
			fontSize:'10px',
			width:'300px'
		
		},1000);
	}
	function disinda(){
		 $(this).animate({
			fontSize:'10px',
			width:'100%'
		
		},25);
	}
*/
})