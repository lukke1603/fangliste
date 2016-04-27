$(function(){
	$(document).find('#bildergalerie').galery({
//		cutPreview: true,
		navigateNextBG: './Library/images/galery/next.png',
		navigatePrevBG: './Library/images/galery/prev.png',
		loadingImage: './Library/images/galery/spinner.gif'
	});
});