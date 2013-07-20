/* theWebBlog.net // mozcelikors@gmail.com */

function hosgeldiniz(){
   do{
   var adiniz=prompt("Lütfen Adýnýzý Giriniz");
   }while(adiniz=="" || adiniz==null)
   if(adiniz!=""){
   alert("Hoþgeldiniz " + adiniz);
   }	
}


function yazilariBuyut(degisken){
   degisken=degisken.toUpperCase();
   document.write(degisken);
}

function pencereAc(){
	var pencere=window.open("sozlesmeler/uyeliksozlesmesi.php?javascript=oku","list","width=600,height=400,resizable=no,scrollbars=yes,dependent=no, dialog=no, minimizable=no,menubar=no, toolbar=no, location=no, centerscreen=yes, titlebar=no, status=no");
}

function pencereAc_opsiyonel(adres){
	var pencere=window.open(adres,"list","width=600,height=400,resizable=no,scrollbars=yes,dependent=no, dialog=no, minimizable=no,menubar=no, toolbar=no, location=no, centerscreen=yes, titlebar=no, status=no");
}

function pencereKapa(){
	window.close();
	}
	
function Denetle(){
	var element1=document.getElementByName("user");
	var ozellik=createAttribute("style");
	ozellik.nodeValue="background-color:red;";
	element1.setAttributeNode(ozellik);
}
		
function stilDegistir(){
	var nesne=document.getElementById("DDD");
	nesne.style.backgroundColor='red';
}
			
function stilDegistir2(){
	var nesne=document.getElementById("DDD");
	nesne.style.backgroundColor='white';
}

function divEkle(){
	var y=document.createElement("p");
	var z=document.create=TextNode("Test Yazýsýdýr");
	y.appendChild(z);
	document.body.appendChild(y);
}


function beniHatirla(){
	if(document.form1.benihatirla.value=="1"){
		document.cookie=document.form1.user.value;
		document.cookie=document.form1.pass.value;
	}
}


function iletisimKutusu(){
	for(i=0;i<=3;i++){
	if(document.styleSheets[0].cssRules){
		document.styleSheets[0].deleteRule(0);
		document.styleSheets[0].deleteRule(1);
		document.styleSheets[0].deleteRule(2);
	}else{
		document.styleSheets[0].removeRule(1);
		document.styleSheets[0].removeRule(2);
		document.styleSheets[0].removeRule(3);
	}
	document.styleSheets[0].insertRule('#iletisimKutusu{visibility:visible; padding:2px 1px 2px 1px; background-color:#DDD; border:1px dotted #666;}',0);	
	document.styleSheets[0].insertRule('#iletisimKutusu:focus{visibility:visible; background-color:#DCFAB4; color:#333333;}',0);	
	document.styleSheets[0].insertRule('#iletisimKutusu:hover{visibility:visible; background-color:#DCFAB4; color:#333333;}',0);
	}
		
}


function iletisimKutusu2(){
	document.form2.diger.value="";	
}

function iletisimKutusu3(){
	if(document.form2.diger.value==""){
		document.form2.diger.value="Buraya Konuyu Yaziniz..";	
	}
		
}

function check(){
	txt= document.forms[0].elements[user].value;
	
	if(txt==""){
	document.forms[0].elements[user].style.cssText="background-color:red; color:white;";
	return false;
	}
		
return true;
}


function addText(Text, Message) 
{ 
  var obj = document.form1.mesaj; 

  obj.focus(); 

  if (document.selection && document.selection.createRange)  // Internet Explorer 
  { 
sel = document.selection.createRange(); 
if (sel.parentElement() == obj)  sel.text = Text; 
  } 

  else if (typeof(obj) != "undefined")  // Firefox 
  { 
var longueur = parseInt(obj.value.length); 
var selStart = obj.selectionStart; 
var selEnd = obj.selectionEnd; 

obj.value = obj.value.substring(0, selStart) + Text + obj.value.substring(selEnd, longueur); 
  } 

  else obj.value += Text; 

  obj.focus(); 
} 


function addTags(Tag, fTag, Message) 
{ 
  var obj = document.form1.mesaj; 

  obj.focus(); 

  if (document.selection && document.selection.createRange)  // Internet Explorer 
  { 
sel = document.selection.createRange(); 
if (sel.parentElement() == obj)  sel.text = Tag + sel.text + fTag; 
  } 

  else if (typeof(obj) != "undefined")  // Firefox 
  { 
var longueur = parseInt(obj.value.length); 
var selStart = obj.selectionStart; 
var selEnd = obj.selectionEnd; 

obj.value = obj.value.substring(0, selStart) + Tag + obj.value.substring(selStart, selEnd) + fTag + obj.value.substring(selEnd, longueur); 
  } 

  else obj.value += Tag + fTag; 

  obj.focus(); 
} 

function uyelikOnayiKontrol(){
	
	if(document.forms[0].onay.value!=="evet"){
		alert("Üyelik Sözlesmesinin sartlarini onaylamaniz gerekmektedir.");
		return false;
	}
	
}
//-----------------------------------

function olay(e){
	
	
	

}
