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
SLIDER HEIGHT
*/

jQuery.fn.sliderheight = function() {
    var o = $(this[0]) // It's your element
    var maxHeight = 0;
    //alert("fuckface" + o);
    el = o.children();
    //el.css('background-color' , 'red');
	el.each(function(){
		$(this).css('background-color' , 'red');
		//alert($(this).height());
		if($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
	});
	o.height(maxHeight);
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
	$('#slider') 
	.before('<nav id="slider-nav"><a id="previous">Previous</a><div id="pager"></div><a id="next">Next</a></nav><!--#slider-nav-->') 
	.cycle({ 
		fx:     'fade', 
		speed:  'fast', 
		timeout: 0, 
		pager:  '#pager',
		next:   '#next', 
    	prev:   '#previous',
    	containerResize: false,
  		slideResize: false,
  		fit: 1
	});
	
	$(function() {
		$( "#social-tabs" ).tabs();
	});
	
	$(window).smartresize(function(){  
		$("#slider").sliderheight();
	});
	
	$("#slider").sliderheight();
	
	/*function loadURL(url){
		$("#main").fadeOut(200 , function(){ 
			$("#page").append('<div id="loader-holder"><div id="loader"></div></div>').fadeIn(100);
			console.log("loadURL: " + url);
			$("#main").load(url+" #main > *", function() {
				$("#main").fadeIn(200, function(){
					$("#loader-holder").fadeOut(500 , function(){
						$(this).remove();
					});
				}); 
			});
		});
	}
	
	$.address.init(function(event) {
	        console.log("init: " + $('[rel=address:' + event.value + ']').attr('href'));
	}).change(function(event) {
				$("#main").load($('[rel=address:' + event.value + ']').attr('href'));
				console.log("change");
	})
	
	$.address.change(function(event) {  
    	console.log($.address.path());
	});  
	
     //navigation
    $("#access a").click(function(){
     	$.address.value($(this).attr('href'));
     	loadURL($(this).attr('href'));
     });*/
     
});


(function() {

'use strict';

var nav = $('#access a'),
    content = $('#content'),
    init = true,
    state = window.history.pushState !== undefined,
    handler = function (data) {
        // Response
        document.title = data.title + ' - Stolen Records';
        content.fadeTo(20, 1).removeAttr('style').html(data.content);
        $("#loader-holder").fadeOut(500 , function(){
						$(this).remove();
					});
        if ($.browser.msie) {
            content.removeAttr('filter');
        }
    };

$.address.crawlable(1).state().init(function () {
    // Initialize jQuery Address
    nav.address();
    
}).change(function (e) {
    // Select nav link
    nav.each(function () {
        var link = $(this);
        if (link.attr('href') === (($.address.state() + decodeURI(e.path)).replace(/\/\//, '/'))) {
            link.addClass('selected').focus();
        } else {
            link.removeAttr('class');
        }
    });

    if (state && init) {
        init = false;

    } else {
        // Implement timeout
        var timer = window.setTimeout(function () {
            content.html('Loading seems to be taking a while...');
        }, 3800);

        // Load API content
        $.ajax({
            type: 'GET',
            url: // '//lab.alaukstein.com/ajax-seo/'+
            'api' + (e.path.length !== 1 ? '/' + encodeURIComponent(e.path.toLowerCase().substr(1)) : ''),
            // You maight switch it to 'jsonp'
            dataType: 'json',
            // Uncomment the next line in case you use 'jsonp'
            //jsonpCallback: 'i',
            cache: false,
            beforeSend: function () {
                document.title = 'Loading...';
                content.fadeTo(200, 0.33);
                $("#page").append('<div id="loader-holder"><div id="loader"></div></div>').fadeIn(100);
            },
            success: function (data, textStatus, jqXHR) {
                window.clearTimeout(timer);
                handler(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                window.clearTimeout(timer);
                nav.removeAttr('class');
                document.title = '404 Page not found';
                content.fadeTo(20, 1).removeAttr('style').html('<h1>404 Page not found</h1>\r<p>Sorry, this page cannot be found.</p>\r');
                $("#loader-holder").fadeOut(500 , function(){
						$(this).remove();
					});
                if ($.browser.msie) {
                    content.removeAttr('filter');
                }
            }
        });
    }
});

//Optimized Google Analytics snippet by http://mathiasbynens.be/notes/async-analytics-snippet
var _gaq = [
    ['_setAccount', 'UA-11883501-1'],
    ['_setDomainName','.laukstein.com'],
    ['_addIgnoredRef','.laukstein.com']
];
(function (d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.src = '//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
}(document, 'script'));

})();


