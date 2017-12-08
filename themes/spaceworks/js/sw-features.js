jQuery(function($){
	
	if( $(window).scrollTop() + $(window).height() > $(document).height() - 200 ) {
		$('#page-logo').addClass('stop_scroll');
	}
	
	$( window ).scroll(function() {
		if($(window).scrollTop() + $(window).height() > $(document).height() - 155) {
			$('#page-logo').addClass('stop_scroll');
		} else {
			$('#page-logo').removeClass('stop_scroll');
		}
	});
	
	function openPopup() {
		$('.popup .popup-close').css('display','block');
		$('.popup').fadeIn();
	}
	
	$(function(){
		var checkAdmin = $('body.logged-in').length;
		if ( $('.popup').length && !checkAdmin ) {
			setTimeout( openPopup, 12000 );
		}
	});
	
	$('.popup-close').click(function() {
		$('.popup').fadeOut();
	});
	
	$('.newsletter-signup-cta.popup:after').click(function() {
		$('.popup').fadeOut();
	});
	
	/***********************/
	/*** Sub Menu Opener ***/
	/***********************/
	
	var checkMobile = '';
	
	$('#primary-menu > li > .sub-menu').parent('li').children('a:first-child').append(' &raquo;');
	
	$('#primary-menu > li > .sub-menu').parent('li').children('a:first-child').click(function(e) {
		
		checkMobile = $('#mobile-check').css('display');
		
		if ( checkMobile == 'block' ) {
			$(this).parent('li').children('.sub-menu').fadeToggle();
			e.preventDefault();
		} else {
			e.preventDefault();
			$('ul.sub-menu').removeClass('sub-menu-open');
			$(this).parent('li').children('ul.sub-menu').addClass('sub-menu-open');
		}

	});
	
		
	$('#menuToggle input').click( function() {
		if ( $('#menuToggle input').attr('class') == 'main-menu-open' ){
			$('ul.sub-menu').removeClass('sub-menu-open');
		}
		$(this).toggleClass('main-menu-open');
	});
	
	$('#content').click( function() {
		
		if ( $('#menuToggle input').attr('class') == 'main-menu-open' ){
			$('#menuToggle input').trigger('click').removeClass('main-menu-open');
			$('ul.sub-menu').removeClass('sub-menu-open');
		}

	});


	
	
	
	/***********************/
	/** Donate Page loader */
	/***********************/
	
	var iframePopin = $('<div id="popup123" class="dialog"><p id="popin-load">Loading ...</p></div>').appendTo('.donate-form-holder'); 
	iframePopin.prepend('<div class="embed-container"><iframe style="display:none" class="popin-iframe"></iframe></div>');
	var $iFrame = $('iframe');
	
	$iFrame.load(function() {
		$('.popin-iframe').show();
		$('#popin-load').hide();
	});
	
	$('.popin-iframe').attr("src", 'https://connect.clickandpledge.com/w/Organization/SpaceworksTacoma/site/site1/campaign/TacomaPierceCountyChamberFoundation17234/Donation/');

});

