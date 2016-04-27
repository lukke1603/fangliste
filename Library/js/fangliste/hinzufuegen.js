$(function(){
	$(document).find('input[type=datetime]').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	var files = {};
	$(document).find('input[type=file]').filer({
		changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"></div><div style="margin: 0px 0px 5px 0px;" class="jFiler-input-text"><h3>Bilder hochladen</h3> </div><a class="jFiler-input-choose-btn blue">Dateien auswählen</a></div></div>',
		showThumbs: true,
		limit: 6,
		theme: "dragdropbox",
		templates: {
			box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
			item: '<li class="jFiler-item">\
						<div class="jFiler-item-container">\
							<div class="jFiler-item-inner">\
								<div class="jFiler-item-thumb">\
									<div class="jFiler-item-status"></div>\
									<div class="jFiler-item-info">\
										<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
										<span class="jFiler-item-others">{{fi-size2}}</span>\
									</div>\
									{{fi-image}}\
								</div>\
								<div class="jFiler-item-assets jFiler-row">\
									<ul class="list-inline pull-left">\
										<li>{{fi-progressBar}}</li>\
									</ul>\
									<ul class="list-inline pull-right">\
										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
									</ul>\
								</div>\
							</div>\
						</div>\
					</li>',
			itemAppend: '<li class="jFiler-item">\
							<div class="jFiler-item-container">\
								<div class="jFiler-item-inner">\
									<div class="jFiler-item-thumb">\
										<div class="jFiler-item-status"></div>\
										<div class="jFiler-item-info">\
											<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
											<span class="jFiler-item-others">{{fi-size2}}</span>\
										</div>\
										{{fi-image}}\
									</div>\
									<div class="jFiler-item-assets jFiler-row">\
										<ul class="list-inline pull-left">\
											<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
										</ul>\
										<ul class="list-inline pull-right">\
											<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
										</ul>\
									</div>\
								</div>\
							</div>\
						</li>',
			progressBar: '<div class="balken"></div>',
			itemAppendToEnd: false,
			removeConfirmation: false,
			_selectors: {
				list: '.jFiler-items-list',
				item: '.jFiler-item',
				progressBar: '.balken',
				remove: '.jFiler-item-trash-action'
			}
		},
		onRemove: function(e, file){
			if(typeof files[file.name] !== 'undefined'){
				delete files[file.name];
				$(document).find('form').find('#bilderliste').val(JSON.stringify(files));
			}
		},
		dragDrop: {
			dragEnter: null,
			dragLeave: null,
			drop: null
		},
		uploadFile: {
			url: "./fangliste/hinzufuegen",
			data: {
				action: 'addFile'
			},
			type: 'POST',
			enctype: 'multipart/form-data',
			beforeSend: function(){},
			success: function(data, el){
				var img = JSON.parse(data);
				files[img.name] = img;
				$(document).find('form').find('#bilderliste').val(JSON.stringify(files));
				var parent = el.find(".jFiler-jProgressBar").parent();
				el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
					$("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");    
				});
			},
			error: function(el){
				var parent = el.find(".jFiler-jProgressBar").parent();
				el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
					$("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");    
				});
			},
			statusCode: null,
			onProgress: null,
			onComplete: null
		}
	});
	
	
});