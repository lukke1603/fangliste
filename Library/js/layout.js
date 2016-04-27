$(function(){
	$(document).on("click", ".mobile-menu-button", function(){
		$("#navigation").animate({width:'toggle'},340);
		
//		$("#navigation").css({'display':'block'});
//		
//		$("#navigation").css({
//			
//			'transition': 'width 0.5s',
//			'width' : '75%'
//		});
	});
	
	$(document).on("swiperight", "#navigation", function(){
		$("#navigation").animate({width:'toggle'},450);
	});
	$(document).on("click", "#navigation-top", function(){
		$("#navigation").animate({width:'toggle'},450);
	});
	
});