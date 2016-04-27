$(function(){
	$(document).on("click", ".option.loeschen", function(e){
		e.preventDefault();
		var href = $(this).attr("href");
		confirm("Gewässer löschen", "Willst du dieses Gewässer wirklich löschen?", "Löschen", function(value){
			if(value){
				window.location.href = href;
			}else{
				
			}
		});
		return false;
	});
});