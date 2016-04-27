$(function(){
	
	
	
	$(document).on("click", ".option.loeschen", function(e){
		e.preventDefault();
		var href = $(this).attr("href");
		confirm("Fang löschen", "Willst du diesen Fang wirklich widerrufen?", "Löschen", function(value){
			if(value){
				window.location.href = href;
			}
		});
		return false;
	});
	
//	$(document).on("click", ".table-heading", function(){
//		var table = $(this).closest("table");
//		if($(this).hasAttribute("data-sort")){
//			var sort = $(this).attr("data-sort");
//			if($('.form-feld[name='+sort+']').length > 0){
//				var rows = table.find('tbody').find('.row');
//				
//				rows.sort(function(a, b){
//					a = parseInt($(a).attr("timestamp"), 10);
//					b = parseInt($(b).attr("timestamp"), 10);
//
//					count += 2;
//					if(a > b) {
//						return 1;
//					} else if(a < b) {
//						return -1;
//					} else {
//						return 0;
//					}
//				});
//			}
//		}
//	});
	
});