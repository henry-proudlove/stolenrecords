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
			}).sliderheight();
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

jQuery.fn.loadURL = function(){
	o = $(this[0]);
	target = o.attr('href');
	$("#main").fadeTo(200 , 0.2, function(){ 
		$("#page").append('<div id="loader-holder"><div id="loader"></div></div>').fadeIn(100);
		$("#main").load(target+" #main > *", function() {
			$(".slider").sliderinit();
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
};
	


/*
GET LATEST FROM STOLENRECS VIMEO
*/

var apiEndpoint = 'http://vimeo.com/api/v2/';
var oEmbedEndpoint = 'http://vimeo.com/api/oembed.json'
var oEmbedCallback = 'switchVideo';
var videosCallback = 'setupGallery';
var vimeoUsername = '3362379';

// Get the user's videos
$(document).ready(function() {
	$.getScript(apiEndpoint + vimeoUsername + '/videos.json?callback=' + videosCallback);
});

function getVideo(url) {
	$.getScript(oEmbedEndpoint + '?url=' + url + '&width=504&height=280&callback=' + oEmbedCallback);
}

function setupGallery(videos) {

	// Add the videos to the gallery
	for (var i = 0; i < 4; i++) {	
		var html = '<li><a href="' + videos[i].url + '"><img src="' + videos[i].thumbnail_small + '" class="thumb" />';
		html += '<h3 class="vid-title">' + videos[i].title + '</h3></li>';
		html += '<span class="vid-decription">' + videos[i].description + '</span></a></li>';
		$('#latest-videos ul').append(html);
	}
	$('.vid-decription').truncate({
			width: '250'
		});

	// Switch to the video when a thumbnail is clicked
	$('#thumbs a').click(function(event) {
		event.preventDefault();
		getVideo(this.href);
		return false;
	});

}

function switchVideo(video) {
	$('#embed').html(unescape(video.html));
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
	
	$(window).smartresize(function(){  
		$(".slider").sliderheight();
	});
	
	$(".slider").sliderinit();
	
	//Tooltips
	$("a").tooltip({
		showURL: false
	});
	
    //navigation
    $("#access a").click(function(event){
    	$(this).loadURL();
    	event.preventDefault();
	});
	
	$('.media-thumb').fancybox({
		fitToView	: false,
		width 		: '80%',
		height		: '60%',
		autoSize	: false,
		arrows		: true
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

