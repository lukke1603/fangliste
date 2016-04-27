$(function(){
	
	var theHeaders = {}
    $(this).find('.table-heading.noSort').each(function(i,el){
        theHeaders[$(this).index()] = { sorter: false };
    });
	$(document).find('.table.sort').tablesorter({
		dateFormat: 'ddmmYYYY',
		headers: theHeaders
	});
	
	
	
	$(document).find('select.form-feld').selectmenu({
		appendTo: "#selectmenu-wrapper"
	});
	
	
	
	$(document).on("submit", "form", function(){
		checkFormular($(this));
		return;
	});
	
	
	
	
	
});


function checkFormular(form){
	form = form[0];
	for(var i=0 ; i<form.length ; i++){
		var feld = form[i];
		
		if(feld.hasAttribute("data-regex")){
			
		}
	}
}


window.confirm = function(title, message, buttonTitle, callback){
	$('#dialog-wrapper').css("z-index","1000");
	$('#dialog-wrapper').css("display","block");
	
	$( "#dialog-confirm" ).dialog({
		title: title,
		draggable: false,
		resizable: false,
		modal: true,
		appendTo: "#dialog-wrapper",
		position: {
			my: "center",
			at: "center",
			of: "#dialog-wrapper"
		},
		open: function(event, ui) {
			$(event.target).find('.message').html(message);
			$(event.target).parent().css('position', 'fixed');
			$(event.target).parent().css('top', '150px');
		},
		close: function(event, ui){
			$('#dialog-wrapper').css("z-index","-1");
			$('#dialog-wrapper').css("display","none");
		},
		buttons: [
			{
				text: buttonTitle,
				click: function(){
					$( this ).dialog( "close" );
					callback(true);
				}
			},{
				text: "Abbrechen",
				click: function(){
					$( this ).dialog( "close" );
					callback(false);
				}
			}
		]
	});
};