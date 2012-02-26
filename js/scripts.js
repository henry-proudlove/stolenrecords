/*
STRIP TAGS
*/

(function( $ ) {
  jQuery.fn.stripTags = function() {
  	return this.replaceWith( this.html().replace(/<\/?[^>]+>/gi, '') );
  };
})( jQuery );

/*
DEBOUNCED RESIZE
*/

(function($,sr){
 
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;
 
      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
 
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
 
          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
 
})(jQuery,'smartresize');


/*
INITIALISING CYCLE PLUGIN
*/

jQuery.fn.sliderinit = function(){
	slidernav = '<nav class="slider-nav"><a class="prev">Previous</a><div class="pager"></div><a class="next">Next</a></nav><!--#slider-nav-->';
	$(this).each(function(){
		var c = $(this).children().length;
		var p = $(this).parent();
		if(c > 1){
			if(p.attr('id') == 'latest'){
				$(this).before(slidernav);
			}else{
				$(this).after(slidernav);	
			}
			$(this).cycle({ 
				fx:     'fade', 
				speed:  'fast', 
				timeout: 0, 
				pager:  $('.pager', p),
				next:   $('.next', p),
				prev:   $('.prev', p),
				containerResize: false,
				slideResize: false,
				fit: 1
			})
		}
	});
};

/*
MAKING SLIDES FLUID
*/

jQuery.fn.sliderheight = function() {
    $(this).each(function(){
    	o = $(this);
		var maxHeight = 0;
		el = o.children();
		el.each(function(){
			if($(this).height() > maxHeight) {
				maxHeight = $(this).height();
			}
		});
		o.height(maxHeight);
	});
};

/*jQuery.fn.loadURL = function(){
	o = $(this[0]);
	target = o.attr('href');
	$("#main").fadeTo(200 , 0.2, function(){ 
		$("#page").append('<div id="loader-holder"><div id="loader"></div></div>').fadeIn(100);
		$("#main").load(target+" #main > *", function() {
			$(".slider").sliderinit();
			$(".slider").sliderheight();
			$('a.sc-player, div.sc-player').scPlayer();
			$("#main").fadeTo(200 , 1, function(){
				$("#loader-holder").fadeOut(500 , function(){
					$(this).remove();
					//hash = target.replace($.address.baseURL(), '');
					//$.address.value(hash);
					//console.log(hash);
				});
			}); 
		});
	});
};*/
	


/*
GET LATEST FROM STOLENRECS VIMEO
*/

var apiEndpoint = 'http://vimeo.com/api/v2/';
var videosCallback = 'setupGallery';
var vimeoUsername = '3362379';

// Get the user's videos
$(document).ready(function() {
	$.getScript(apiEndpoint + vimeoUsername + '/videos.json?callback=' + videosCallback);
});

function setupGallery(videos) {

	// Add the videos to the gallery
	for (var i = 0; i < 4; i++) {	
		var html = '<li class="video vimeo"><a href="http://player.vimeo.com/video/' + videos[i].id + '?autoplay=1" class="media-thumb fancybox.iframe vimeo" rel="gallery-vid-aside"><img src="' + videos[i].thumbnail_small + '" class="media-img" />';
		html += '<div class="info"><h1 class="vid-title">' + videos[i].title + '</h1>';
		html += '<p class="vid-decription">' + videos[i].description + '</p></li></div></a>';
		
		$('#latest-videos ul').append(html);
	}
	$('.vid-decription').truncate({
			width: '250'
		});
}

/*
GET FLICKR FOR MEDIA PAGE 
*/

$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=8546357@N03&lang=en-us&format=json&jsoncallback=?", function(data){
  $.each(data.items, function(i,item){
    $("<img/>").attr("src", item.media.m).appendTo("#flickr-images")
      .wrap("<a href='" + item.link + "' class='fourcol'></a>");
      if ( i == 10 ) return false;
  });
});

/*
ISOTOPE
*/

/*var $container = $('.isotope-content')
// initialize Isotope
$container.isotope({
  // options...
  resizable: false, // disable normal resizing
  // set columnWidth to a percentage of container width
  masonry: { columnWidth: $container.innerWidth() / 3 }
});

// update columnWidth on window resize
$(window).smartresize(function(){
  $container.isotope({
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $container.innerWidth() / 3 }
  });
});*/

/*$(function(){
 $('#slider').anythingSlider({
 	expand : true,
 	resizeContents: true
 });
});*/

$(document).ready(function() {

	$( "#social-tabs" ).tabs();
	$(".slider").sliderinit()
	$(".slider").sliderheight();;
	//Tooltips
	$("a").tooltip({
		showURL: false
	});
	$(window).smartresize(function(){  
		$(".slider").sliderheight();
	});	
    //navigation
    /*$("#access a").click(function(event){
    	$(this).loadURL();
    	event.preventDefault();
	});*/
	$('.media-thumb').fancybox({
		fitToView	: false,
		width 		: '80%',
		height		: '60%',
		autoSize	: false,
		arrows		: true
	});
	
	$('#general-form').contactable({
		url: 'http://localhost/stolen/wp-content/themes/stolenrecords/library/mail.php',
		name: 'Name',
		email: 'Email',
		message : 'Message',
		subject : 'MESSAGE: stolenrecordings.co.uk',
		recievedMsg : 'Thankyou for your message',
		notRecievedMsg : 'Sorry, your message could not be sent, try again later',
		disclaimer: ''
	});
	$('#press-form').contactable({
		url: 'http://localhost/stolen/wp-content/themes/stolenrecords/library/mail.php',
		name: 'Name',
		email: 'Email',
		message : 'Message',
		subject : 'PRESS LOGIN REQUEST: stolenrecordings.co.uk',
		recievedMsg : 'Thanks for your message!',
		notRecievedMsg : 'Sorry, your message could not be sent, try again later',
		disclaimer: ''
	});
	
	/*$.address.init(function(event) {

		// Initializes the plugin
		$('#access a').address();
		
	}).change(function(event) {

		var value = $.address.state().replace(/^\/$/, '') + event.value;
		
		// Selects the proper navigation link
		$('.nav a').each(function() {
			if ($(this).attr('href') == value) {
				$(this).addClass('selected').focus();
			} else {
				$(this).removeClass('selected');
			}
		});

		// Loads and populates the page data
		$.ajax({
			cache: false,
			complete: function(XMLHttpRequest, textStatus) {
				var data = XMLHttpRequest.responseText;
				$.address.title(data.title);
				$('#content').html(data.content);
				$('#main').show();
			},
			url: value
		});
	});*/

	// Hides the page during initialization
	//document.write('<style type="text/css"> #main { display: none; } </style>');
            
        
});

