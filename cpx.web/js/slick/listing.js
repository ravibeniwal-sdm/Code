_mg_listing = new _initMGLISTING();
_mg_listing.init();

function _initMGLISTING() {
	
	this.map = null;
	
	this.init = function() {
		$(document).ready( function() {
		    _mg_listing.bindEvents();
		    _mg_listing.resize();
		    
		});
		
		$(window).load( function() {
		    $('#_mg_listing_gallery .slick-frame').on('init', function (event, slick) {
		       
				$(this).animate({opacity: 1});
			});
			
		/*	$('#_mg_listing_gallery .slick-frame').slick({
			    centerMode: true,
			    slidesToShow: 1,
			    arrows: false,
			    dots: true,
			    variableWidth: true,

			});
	*/
			//_mg_listing.map = _mg.initMap('#_mg_listing_map', -33.8828039, 151.2480531);
			//_mg.insertPin(_mg_listing.map, -33.8828039, 151.2480531);
			
			$('#_mg_listing_detail .show-stamp').on('click', function() {
				$.get('/listing-details-calculator?unwrapped', function(data) {
					var html = $(data);
					var popups = html.find('._mg_popup');
					_mg.enablePopup(popups);
					_mg.openModal(html, 'grey');
				});
			});
		});
	};

	this.resize = function () {
	    var mq = window.matchMedia("(max-width: 300px)");
	    if (mq.matches) {
	        
	   
    	    $('#_mg_listing_gallery .slick-frame .frame img').each(function () {
    	       
    	        var ratio = 0;  // Used for aspect ratio
    	        //var width = $(this).width();    // Current image width
    	        var height = $(this).height();  // Current image height
    
    	        var realwidth = window.innerWidth;
    	       
                    ratio = realwidth / width;   // get ratio for scaling image
    	            $(this).css("width", realwidth); // Set new width
    	            $(this).css("height", height * ratio);  // Scale height based on ratio
    	            height = height * ratio;    // Reset height to match scaled image
    	            width = width * ratio;    // Reset width to match scaled image
    	        
    
    	        
    	    });
	    }
	};

	this.bindEvents = function() {
		$('#_mg_listing_gallery .frame').hover(
			function() {
				if ($(this).next().hasClass('slick-center')) {
					$(this).css({cursor: 'w-resize'});
					$(this).on('click', function() {
						$(this).parents('.slick-frame').slick('prev');
					});
				} else if ($(this).prev().hasClass('slick-center')) {
					$(this).css({cursor: 'e-resize'});
					$(this).on('click', function() {
						$(this).parents('.slick-frame').slick('next');
					});
				}
			}, function() {
				$(this).css({cursor: ''});
				$(this).off('click');
			}
		);
	};
}