$(document).ready(function(){
var nesne_ismi=new Array("Isim","Mail","Mesaj");
var nesneler=$('input[type="text"],textarea');						   
nesneler.blur(function(){
	if ($(this).val()=="")
	{
	var t=nesneler.index($(this));
$(".bilgi")
.eq(t).empty().addClass('kirmizi')
.html(nesne_ismi[t]+' bos geçildi');
	}
	else
	{
	var t=nesneler.index($(this));
	$(".bilgi").eq(t).empty().addClass('yesil');
	}
	})
	
$("#isim").keydown(function(e){
 if ((e.which>=48)&&(e.which<=57))
  e.preventDefault();
})

$("#telefon").keydown(function(e){
  if ((e.which>=48)&&(e.which<=57))
   return true;
  else
   e.preventDefault();
  })

$("#formGonder").click(function(){	 
var desen=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i
var netice=desen.test($('#mail').val())
if (netice==false){
 $(".bilgi:eq(1)").empty().addClass('kirmizi').html('Email hatali');
$('#mail').focus();
}
return netice;
})

$("#telefon").keydown(function(){
var yaz = new String();
var numaralar = "0123456789 ";
var chars = $(this).val().split("");	
for (i = 0; i < chars.length; i++) 
{
if (numaralar.indexOf(chars[i])!=-1) 
yaz += chars[i];
}
if ($(this).val()!=yaz) 
$(this).val(yaz);
})

      });