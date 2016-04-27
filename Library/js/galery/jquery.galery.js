(function($){
	
	
	
	

	$.fn.galery = function(params){
	
		return this.each(function(t, element){
			
			var e = $(element);
			var c = $();
			var p = $();
			
			var g = {
				init: function(){
					e.find('*:not(img)').addClass("hidden");
					e.addClass(bezeichner.galery.class);
					
					g.container.init();
					g.images.init();
					g.preview.init();
					g.container.initMousewheel();
				},
				preview: {
					init: function(){
						p = $('<div>', {
							class: bezeichner.preview.previewWrapper.class
						}).append($('<div>', { 
							class: bezeichner.preview.loadingLayer.class 
						}).css({
							backgroundImage: 'url('+conf.loadingImage+')'
						})).append($('<span>', {
							class: bezeichner.preview.navigatorPrev.class
						}).css({
							backgroundImage: 'url('+conf.navigatePrevBG+')'
						}).bind('click', g.preview._navigatePrev)).append($('<span>', {
							class: bezeichner.preview.navigatorNext.class
						}).css({
							backgroundImage: 'url('+conf.navigateNextBG+')'
						}).bind('click', g.preview._navigateNext));
						
						e.prepend(p);
						
						g.images.activate(c.find('.'+bezeichner.images.class).eq(0), true, true);
						p.find('.passiv').addClass("aktiv").removeClass("passiv");
						
						p.find('.'+bezeichner.preview.previewImage.class).on("load", function(){
							p.find('.'+bezeichner.preview.loadingLayer.class).animate({
								opacity: 0
							}, 600,function(){
								$(this).remove();
							});
						});
						
					},
					clear: function(){
						p.find('.'+bezeichner.preview.class).remove();
					},
					_navigatePrev: function(e){
						var position = parseInt(p.find('.'+bezeichner.preview.previewImage.class).attr("data-position"));
						var hits = p.find('.'+bezeichner.preview.class+'.passiv').length;
						if(position > 1 && hits === 0){
							//g.images.activate(c.find('.'+bezeichner.images.imageWindow.class+'[data-position='+(position-1)+']').find('.'+bezeichner.images.class));
							g.images.activate(c.find('.'+bezeichner.images.imageWindow.class+'[data-position='+(position-1)+']').find('.'+bezeichner.images.class), false, false);
							
							var marginLeft =  (parseInt(p.css("padding-left")) * 2) + parseInt(p.width());
							var marginRight = parseInt(p.css("padding-left")) * 2;
							p.find('.'+bezeichner.preview.class+'.passiv').css({
								'margin-left' : '-'+marginLeft+"px",
								'margin-right' : marginRight+"px",
								'transition': 'all 0s'
							});
							
							window.setTimeout(function(){
								var newMarginLeft = 0;
								
								p.find('.'+bezeichner.preview.class+'.passiv').css({
									'transition' : 'all 1s',
									'margin-left' : newMarginLeft+"px",
									// 'margin-right' : '0px'
								});
								window.setTimeout(function(){
									p.find('.'+bezeichner.preview.class+'.aktiv').remove();
									p.find('.'+bezeichner.preview.class+'.passiv').addClass("aktiv").removeClass("passiv").css("margin-left", "0px");
									p.find('.'+bezeichner.preview.class).css("transition", "all 0s");
								}, 1000);
							}, 20);
							
							
							
						}
					},
					_navigateNext: function(e){
						var position = parseInt(p.find('.'+bezeichner.preview.previewImage.class).attr("data-position"));
						var hits = p.find('.'+bezeichner.preview.class+'.passiv').length;
						if(position < c.find('.'+bezeichner.images.class).length && hits === 0){
							//g.images.activate(c.find('.'+bezeichner.images.imageWindow.class+'[data-position='+(position+1)+']').find('.'+bezeichner.images.class));
							g.images.activate(c.find('.'+bezeichner.images.imageWindow.class+'[data-position='+(position+1)+']').find('.'+bezeichner.images.class),true, false);
							
							var marginLeft = parseInt(p.css("padding-left")) * 2;
							p.find('.'+bezeichner.preview.class+'.passiv').css({
								'margin-left' : marginLeft+"px"
							});
							
							var newMarginLeft = parseInt(p.width()) + parseInt(p.find('.'+bezeichner.preview.class+'.passiv').css("margin-left"));
							p.find('.'+bezeichner.preview.class+'.aktiv').css({
								'transition' : 'all 1s',
								'margin-left' : '-'+newMarginLeft+"px",
								"margin-right": "0px"
							});
							window.setTimeout(function(){
								p.find('.'+bezeichner.preview.class+'.aktiv').remove();
								p.find('.'+bezeichner.preview.class+'.passiv').addClass("aktiv").removeClass("passiv").css({
									"margin-left": "0px"
								});
								p.find('.'+bezeichner.preview.class).css("transition", "all 0s");
							}, 1000);
							
							
						}
					},
					calcHeight: function(){
						var height = parseInt(p.width()) / conf.previewRatio;  
						return height;
					}
				},
				container: {
					init: function(){
						
						c = $('<div>', { class: bezeichner.container.class }).append($('<div>', { class: bezeichner.container.scrollWrapper.class }));
						e.append(c);
					},
					initMousewheel: function(){
						if (c.find('.'+bezeichner.container.scrollWrapper.class).get(0).addEventListener){
							c.find('.'+bezeichner.container.scrollWrapper.class).bind("mousewheel", g.container._scroll);		// IE9, Chrome, Safari, Opera
							c.find('.'+bezeichner.container.scrollWrapper.class).bind("DOMMouseScroll", g.container._scroll);	// Firefox
						}else{
							c.find('.'+bezeichner.container.scrollWrapper.class).bind("onmousewheel", g.container._scroll);	
						}
						
					},
					_scroll: function(e){
						var e = window.event || e; // old IE support
						e.preventDefault();
						
						var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
						
						var wrapper = { 
							left: parseInt($(this).css("margin-left")),
							width: parseInt($(this).width()),
							height: parseInt($(this).height())
						};

						var distance = Math.abs(delta) * conf.scrollSpeed;
								
						if(delta > 0){	//	zurückscrollen
							var ampli = Math.abs(wrapper.left);
							if(wrapper.left <= -1 * distance ){
								$(this).css({ marginLeft: wrapper.left + distance+'px' });
							}else if(ampli < 100 && ampli > 0){
								$(this).css({ marginLeft: '0px' });
							}
						}else{		//	vorscrollen
							var ampli = Math.abs(wrapper.width - parseInt(c.width()) - Math.abs(wrapper.left));
							if(wrapper.left >= (wrapper.width - parseInt(c.width()) - distance) * -1 ){
								$(this).css({ marginLeft: wrapper.left - distance+'px' });
							}else if(ampli < 100 && ampli > 0){
								$(this).css({ marginLeft: -1 * (wrapper.width - parseInt(c.width()))+'px' });
							}
						}
					}
				},
				images: {
					init: function(){
						e.children('img').each(function(t, element){
							c.children('.'+bezeichner.container.scrollWrapper.class).css({
								display: 'inline-block'
							}).append($('<div>',{
								class: bezeichner.images.imageWindowWrapper.class
							}).append($('<div>', { 
								class: bezeichner.images.loadingLayer.class 
							}).css({
								backgroundImage: 'url('+conf.loadingImage+')'
							})).css({
								display: 'inline-block'
							}).append($('<div>', {
								class: bezeichner.images.imageWindow.class,
								'data-position': t+1
							}).append($(element).addClass(bezeichner.images.class).bind('click', g.images._click))).append($('<div>', {
								class: bezeichner.images.imageInfo.class
							})));
							g.images.setPosition($(this), true);
							
							$(this).on("load", function(){
								$(this).closest('.'+bezeichner.images.imageWindowWrapper.class).find('.'+bezeichner.images.loadingLayer.class).animate({
									opacity: 0
								}, 600,function(){
									$(this).remove();
								});
							})
						});
					},
					activate: function(element, append, clear){
						if(clear !== false){ g.preview.clear(); }
						var img = $(element).addClass("passiv").clone().removeAttr("style");
						var previewHeight = g.preview.calcHeight();
						console.log(previewHeight);
						if(append){
							$('<div>', { class: bezeichner.preview.class + " passiv" }).css({'height': previewHeight+"px"}).append(img.addClass(bezeichner.preview.previewImage.class).attr("data-position", $(element).closest('.'+bezeichner.images.imageWindow.class).attr("data-position"))).appendTo(p);
						}else{
							$('<div>', { class: bezeichner.preview.class + " passiv" }).css({'height': previewHeight+"px"}).append(img.addClass(bezeichner.preview.previewImage.class).attr("data-position", $(element).closest('.'+bezeichner.images.imageWindow.class).attr("data-position"))).prependTo(p);
						}
						
						g.images.setPosition(img, conf.cutPreview);
					},
					setPosition: function(img, fillout){
						img.one("load", function(){
							if(typeof fillout === 'undefined'){
								fillout = true;
							}
							
							var image = { width: img.get(0).naturalWidth, height: img.get(0).naturalHeight, ratio: img.get(0).naturalWidth / img.get(0).naturalHeight };
							var wrap = { width: img.parent().get(0).clientWidth, height: img.parent().get(0).clientHeight, ratio: img.parent().get(0).clientWidth / img.parent().get(0).clientHeight };

							if(image.ratio > wrap.ratio){			//	breiter
								if(fillout){
									img.css({ height: "100%" });
									image = { width: img.get(0).clientWidth, height: img.get(0).clientHeight, ratio: img.get(0).clientWidth / img.get(0).clientHeight };
									var dif = wrap.width - image.width;
									img.css({ marginLeft: (dif/2) + "px" });
								}else{
									img.css({ width: "100%" });
									image = { width: img.get(0).clientWidth, height: img.get(0).clientHeight, ratio: img.get(0).clientWidth / img.get(0).clientHeight };
									var dif = wrap.height - image.height;
									img.css({ marginTop: (dif/2) + "px" });
								}
							}else if(image.ratio < wrap.ratio){		//	höher
								if(fillout){
									img.css({ width: "100%" });
									image = { width: img.get(0).clientWidth, height: img.get(0).clientHeight, ratio: img.get(0).clientWidth / img.get(0).clientHeight };
									var dif = wrap.height - image.height;
									img.css({ marginTop: (dif/2) + "px" });
								}else{
									img.css({ height: "100%" });
									image = { width: img.get(0).clientWidth, height: img.get(0).clientHeight, ratio: img.get(0).clientWidth / img.get(0).clientHeight };
									var dif = wrap.width - image.width;
									img.css({ marginLeft: (dif/2) + "px" });
								}
							}else{		//	gleich groß
								img.css({ height: "100%", width: "100%" });
							}
							
						}).each(function(){
							if(this.complete) $(this).load();
						});
					},
					_click: function(e){
						g.images.activate($(this),true, true);
						p.find('.passiv').addClass("aktiv").removeClass("passiv");
					}
				}
			};
			
			
			var bezeichner = {
				galery: {
					class: 'g-galery'
				},
				images: {
					class: 'g-image',
					imageWindow: {
						class: 'g-image-window'
					},
					imageWindowWrapper: {
						class: 'g-image-wrapper'
					},
					imageInfo: {
						class: 'g-image-info'
					},
					loadingLayer: {
						class: 'loading-layer'
					}
				},
				container: {
					class: 'g-image-container',
					scrollWrapper: {
						class: 'scroll-wrapper'
					},
					wrapper: {
						class: 'container-wrapper'
					}
				},
				preview: {
					class: 'g-preview',
					previewImage: {
						class: 'preview-image'
					},
					previewWrapper: {
						class: 'g-preview-wrapper'
					},
					navigatorPrev: {
						class: 'g-navigate-prev'
					},
					navigatorNext: {
						class: 'g-navigate-next'
					},
					loadingLayer: {
						class: 'loading-layer'
					}
				}
			};
			
			
			
			var conf = $.extend({
				scrollSpeed: 100,
				previewRatio: 1.33,
				cutPreview: false,
				navigatePrevBG: './img/prev.png',
				navigateNextBG: './img/next.png',
				loadingImage: './img/spinner.gif'
			}, params);
			
			
			g.init();
			return this;
		});
		
	};
	
	
	
	
})(jQuery);