// JavaScript Document
$(function(){
    $("#acrbtn").click(function () {
      //$("#commentDescription").fadeIn(1000);
      $("#commentDescription").toggle("normal");
	  
    });
  });

//透明度を下げる
$(function(){
	$("li.no_disp img").fadeTo(0, 0.3);
});

function check(){
	if(document.form.upfile.value == ""){
		window.alert('画像を選択してください');
		return false;
	}else{
		return true;
	}
}

function f5(){
  location.reload();
}

//並び替え
$(function(){ 
		$('.gallery_list_order').sortable();
});

//lightbox
$(function() {
	$('a.photo').lightBox();
});

$(function(){
　$(".message_com").delay(2000).fadeOut("slow");
});
