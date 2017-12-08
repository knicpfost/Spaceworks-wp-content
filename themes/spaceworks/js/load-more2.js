jQuery(function($){

	$(function() {
		$('#media-filters #submit').hide();
		
		$('#media-filters select').change(function() {
			window.location = $('#media-filters select option:selected').val();
		});
	});

	var container = jQuery('#masonry-layout');
	var grid = document.querySelector('#masonry-layout');
	
		
	container.after( '<span class="load-more masonry-item"></span>' );
	var button = $('span.load-more');
	var page = 2;
	var loading = false;
	var scrollHandling = {
	    allow: true,
	    reallow: function() {
	        scrollHandling.allow = true;
	    },
	    delay: 1400 //(milliseconds) adjust to the highest acceptable value
	};

	$(window).scroll(function(){
		
		if( ! loading && scrollHandling.allow ) {
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
			var offset = $(button).offset().top - $(window).scrollTop();

			if( 1000 > offset ) {
				loading = true;
				var data = {
					action: 'be_ajax_load_more',
					nonce: beloadmore.nonce,
					page: page,
					query: beloadmore.query,
				};
				$.post(beloadmore.url, data, function(res) {
					if( res.success) {
						// container.append( res.data );
						$(res.data).each( function(index, element) {
						    var item = document.createElement('article');
						    salvattore['append_elements'](grid, [item]);
						    $(item).replaceWith(element);
						});

						page = page + 1;
						loading = false;
					} else {
						// console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					// console.log(xhr.responseText);
				});

			}
		}
	});

});