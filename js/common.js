// Changing main images
$(document).ready(function(){

	
	// table, smartphone -> iframe size 
	var win_width = $(window).width();	
		if ( win_width < 737)	{
			$('#iframe_face').attr('width','80%');
		} 



	
	// checkbox_reset 
	$("#checkbox_personal").prop('checked', false) ;

	$(".sm_left").insertAfter(".sm_right");


	// slider
	$('.bxslider').bxSlider({
	  auto: true,
    speed: 1200,
	  autoControls: true,
	  pager: true,
	  controls : true,
	  nextText: '▶',
	  prevText: '◀'
	});

	// ヘッダーの高さを取得する
	$(window).on('load resize', function(){
		var header_height = $("header").height();
		var win_width = $(window).width();	

		
		if(header_height < 480) {
			header_height = "100%";
		}
		$("#title_wrap").css('height', header_height);
	
		// responsive - iframe size
		if ( win_width < 737 ) {
			$('#iframe_face').attr('width','80%');
		} else {
			$('#iframe_face').attr('width','100%');
		}
	
	
	});
	// main_title
	$("#main_title").fadeIn(3000).css('display','block');

	// loading images following scroll
	$("img.lazy").lazyload({
		 effect : "fadeIn"
	 });

	//main_imgages
	setInterval(change_img,50);
	var num = $("#main_img").attr("src").substr(-5,1);

	function change_img(){
		if ( num >=4 ) {
			num = 1;
			$("#main_img").attr("src","img/main1.png")

		} else {
			num++;
			$("#main_img").attr("src","img/main"+num+".png")
		}
	}

});

function checkbox_personal() {

	var check_validate = 	$("#checkbox_personal").prop("checked");

	if (check_validate) {
		$("#submit_btn").addClass("personal");
		$('#submit_btn').css('background-color', '#900');
		$('#submit_btn').css('color', '#fff');
	} else {
		$("#submit_btn").removeClass("personal");
		$('#submit_btn').css('background-color', 'gray');
		$('#submit_btn').css('color', '#666');
	}
}

function check_personal(){
	
	$("#checkbox_personal").prop('checked', true) ;
	$("#submit_btn").addClass("personal");
	$('#submit_btn').css('background-color', '#900');
	$('#submit_btn').css('color', '#fff');

	var url = "../file/A01-01toriatsukai_170616.pdf";
	window.open(url, "_blank");

}

function button_able() {

	var p_validate = $("#submit_btn").hasClass("personal");

	if (p_validate) {
		$('#submit_btn').attr('href','contact.php'); 
	} else {
		alert("個人情報の取り扱いページ必ずお読みの上、イベント申込にお進みください。");
	}

}
