( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */ 
	// elmentor js	

	$('body').on('click','.search-icon-popup',function(e){
		e.preventDefault();
		$(this).parents('.elth-search-wrap').addClass('open-search-popup');
	})
	$('body').on('click','.elth-close-search-form',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).parents('.elth-search-wrap').removeClass('open-search-popup');
	})
	$('body').on('click','.elth-account-icon',function(){
		$(this).find('.elth-popup-overlay').addClass('elth-popup-open');
	})
	$('body').on('click','.elth-close-popup',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).parents('.elth-popup-overlay').removeClass('elth-popup-open');
	})
	$('body').on('click','.elth-mini-cart-side .mini-cart-link',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).parents('.elth-mini-cart').toggleClass('open-side');		
		$(this).parents('.elth-mini-cart').find('.list-mini-cart-item').each(function(){
			var seff = $(this).parents('.mini-cart-content');
			var c_height = seff.height() - $('#wpadminbar').height() - seff.find('.mini-cart-footer').height() - seff.find('> h2').outerHeight() - 20;
			$(this).css('max-height',c_height);
		})
	})
	$('body').on('click','.mini-cart-side-overlay,.elth-close-mini-cart',function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).parents('.elth-mini-cart-side').removeClass('open-side');
	})
	// menu responsive
	function fix_menu_responsive(){
	    $('.th-navbar-nav-default').each(function(){
	    	if(!$(this).hasClass('default-icon')){
	    		var width = 751;
		    	if($(window).width() < width) $(this).addClass('menu-style-icon');	    		
		    	else $(this).removeClass('menu-style-icon');
		    }
	    })
	}

	//count down
    function final_count_down(){
		$('.final-countdown').each(function(){
			var self = $(this);
			var finalDate = self.data('countdown');
			var dtext = self.attr('data-dtext');
			var htext = self.attr('data-htext');
			var mtext = self.attr('data-mtext');
			var stext = self.attr('data-stext');
			self.countdown(finalDate, function(event) {
				self.html(event.strftime(''
					+'<div class="clock day"><span class="number">%D</span><span class="text">'+dtext+'</span></div>'
					+'<div class="clock hour"><span class="number">%H</span><span class="text">'+htext+'</span></div>'
					+'<div class="clock min"><span class="number">%M</span><span class="text">'+mtext+'</span></div>'
					+'<div class="clock sec"><span class="number">%S</span><span class="text">'+stext+'</span></div>'
				));
			});
		});
	}

	function el7up_mailchimp_fix(){
		$('.sv-mailchimp-form').each(function(){
            var placeholder = $(this).attr('data-placeholder');
            var submit = $(this).attr('data-submit');
            var icon = $(this).attr('data-icon');
            var text_pos = $(this).attr('data-textpos');
            if(placeholder) $(this).find('input[name="EMAIL"]').attr('placeholder',placeholder);
            if(icon && text_pos == 'before-icon'){
            	$(this).find('.elth-text-bt-mailchimp').append('<i class="'+icon+'"></i>');
            }
            if(submit){
            	$(this).find('input[type="submit"]').val('');
            	$(this).find('.elth-text-bt-mailchimp').append('<span>'+submit+'</span>');
            }
            if(icon && text_pos == 'after-icon'){
            	$(this).find('.elth-text-bt-mailchimp').append('<i class="'+icon+'"></i>');
            }
        })
	}

	function el7up_swiper_slider(){
		$('.elth-swiper-slider:not(.swiper-container-initialized)').each(function(){
			var seff  = $(this);
			if($(this).hasClass('elementor-section')){
				if($(this).find('> div').hasClass('swiper-container-initialized')) return false;
				$(this).find('> div.elementor-container.slider-wrap').removeClass('swiper-wrapper');
				if(!$(this).find('> div').hasClass('swiper-container')){
					$(this).find('> div.elementor-container:not(.slider-wrap)').addClass('swiper-wrapper').removeClass('elementor-container');
					$(this).find('> div > .elementor-column').addClass('swiper-slide');
					console.log($(this).attr('class'));
					$(this).find('> div.swiper-wrapper').wrap('<div class="elementor-container swiper-container slider-wrap"></div>');
					seff  = $(this).find('> div');
					var nav_html = $(this).parent().find('.section-slider-nav').html();
					seff.parent().append(nav_html);
					$(this).parent().find('.section-slider-nav').remove();
				}
				$(this).find('> div.elementor-container.slider-wrap').removeClass('swiper-wrapper');
			}
			var slidesPerView = Number($(this).attr('data-items'));
			if(!slidesPerView) slidesPerView = 1;			

			var spaceBetween = Number($(this).attr('data-space'));
			if(!spaceBetween) spaceBetween = 0;

			var slidesPerColumn = Number($(this).attr('data-column'));
			if(!slidesPerColumn) slidesPerColumn = 1;

			var loop = $(this).attr('data-loop');
			if(loop != 'yes') loop = false;
			else loop = true;

			var auto = $(this).attr('data-auto');
			if(auto != 'yes') auto = false;
			else auto = true;			
			if(auto) slidesPerView = 'auto';

			var centeredSlides = $(this).attr('data-center');
			if(centeredSlides != 'yes') centeredSlides = false;
			else centeredSlides = true;

			var effect = $(this).attr('data-effect');

			var breakpoints = {};
			var items_tablet = Number($(this).attr('data-items-tablet'));
			var items_mobile = Number($(this).attr('data-items-mobile'));
			var space_tablet = Number($(this).attr('data-space-tablet'));
			var space_mobile = Number($(this).attr('data-space-mobile'));
			var default_items_tablet;
			var default_items_mobile;
			var default_items_desktop = slidesPerView;
			if(slidesPerView >=2){
				default_items_tablet = default_items_mobile = 1;
				default_items_desktop = 1;
			}
			if(slidesPerView >=3){
				default_items_desktop = 2;
				default_items_tablet = 2;
				default_items_mobile = 1;
			}			
			if(slidesPerView >=4){
				default_items_desktop = slidesPerView-1;
				if(centeredSlides == true) default_items_desktop = slidesPerView-2;
				default_items_tablet = 2;
				default_items_mobile = 2;
			}
			if(slidesPerView >=5){
				default_items_desktop = slidesPerView-1;
				if(centeredSlides == true) default_items_desktop = slidesPerView-2;
				default_items_tablet = 3;
				default_items_mobile = 2;
			}

			if(items_tablet || items_mobile || space_tablet || space_mobile){
				if(auto) items_tablet = items_mobile = 'auto';
				if(items_tablet == '') items_tablet = default_items_tablet;
				if(items_mobile == '') items_mobile = default_items_mobile;
				if(space_tablet == '') space_tablet = spaceBetween;
				if(space_mobile == '') space_mobile = spaceBetween;
				breakpoints = {
					320: {
				      	slidesPerView: items_mobile,
				      	spaceBetween: space_mobile,
				      	centeredSlides: false,
				    },
				    768: {
				      	slidesPerView: items_tablet,
				      	spaceBetween: space_tablet
				    },
				    1024: {
				      	slidesPerView: default_items_desktop,
				      	spaceBetween: spaceBetween
				    },
				    1200: {
				      	slidesPerView: slidesPerView,
				      	spaceBetween: spaceBetween
				    }
				}
				slidesPerView = 1;
			}

			var autoplay = false;
			var speed = Number($(this).attr('data-speed'));
			if(speed){
				autoplay = {};
				autoplay.delay = speed;
			}

			var navigation = $(this).attr('data-navigation');
			if(navigation != 'yes') navigation = {};
			else navigation = {
		        	nextEl: $(this).parent().find('.swiper-button-next'),
		            prevEl: $(this).parent().find('.swiper-button-prev'),
		        };

		    var pagination = $(this).attr('data-pagination');
			if(pagination != 'yes') pagination = {};
			else pagination = {
		        	el: $(this).parent().find('.swiper-pagination'),
	        		clickable: true,
		        };

			var swiper = new Swiper(seff, {
		      	slidesPerView: slidesPerView,
		      	spaceBetween: spaceBetween,
		      	slidesPerColumn: slidesPerColumn,
		      	loop: loop,
		      	centeredSlides: centeredSlides,
		      	breakpoints: breakpoints,
		      	autoplay: autoplay,
		        navigation: navigation,
		        pagination: pagination,
		        effect: effect,
		        observer: true,
				observeParents: true,
				setWrapperSize: false
		    });	
		})
	}
	
    $(window).resize(function(){
    	$('.list-mini-cart-item').each(function(){
			var seff = $(this).parents('.mini-cart-content');
			var c_height = seff.height() - $('#wpadminbar').height() - seff.find('.mini-cart-footer').height() - seff.find('> h2').outerHeight() - 20;
			$(this).css('max-height',c_height);
		})
    });

	var WidgetHelloWorldHandler = function( $scope, $ ) {
		el7up_swiper_slider();
		final_count_down();
		//List Item Masonry
		if($('.blog-grid-view.grid-masonry .list-post-wrap').length>0){
			var $content = $('.blog-grid-view.grid-masonry .list-post-wrap');
			if(!$content.hasClass('masonry')){
				$content.imagesLoaded( function() {
				    $content.masonry();
				});
			}
		}
		if($('.product-grid-view.grid-masonry .list-product-wrap').length>0){
			var $content2 = $('.product-grid-view.grid-masonry .list-product-wrap');
			if(!$content2.hasClass('masonry')){
				$content2.imagesLoaded( function() {
				    $content2.masonry();
				});
			}
		}
		if($('.course-grid-view.list-masonry .list-post-wrap').length>0){
			var $content3 = $('.course-grid-view.list-masonry .list-post-wrap');
			if(!$content3.hasClass('masonry')){
				$content3.imagesLoaded( function() {
				    $content3.masonry();
				});
			}
		}
	};

	var WidgetMenuHandler = function( $scope, $ ) {
		fix_menu_responsive();
	};

	var WidgetMailchimpHandler = function( $scope, $ ) {
		el7up_mailchimp_fix();
	};

	var WidgetSection = function( $scope, $ ) {
		$('.curve-top-left').each(function(){
			if(!$(this).find('.curve-wrap').length > 0) $(this).append('<div class="curve-wrap"><svg viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path stroke="none" fill="#fff" d="M 0,100 0,50 0,0 100,0 C 100,0 0,0 0,100"></path></svg></div>');
		})
		$('.curve-bottom-right').each(function(){
			if(!$(this).find('.curve-wrap').length > 0) $(this).append('<div class="curve-wrap"><svg viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path stroke="none" fill="#fff" d="M 200,0 200,50 200,100 100,100 C 100,100 200,100 200,0"></path></svg></div>');
		})
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-slider.default', WidgetHelloWorldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-courses.default', WidgetHelloWorldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-posts.default', WidgetHelloWorldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-events.default', WidgetHelloWorldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-products.default', WidgetHelloWorldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-instagram.default', WidgetHelloWorldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-mailchimp.default', WidgetMailchimpHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/th-mennu.default', WidgetMenuHandler );
	} );
} )( jQuery );
