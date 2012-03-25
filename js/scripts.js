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
 
          timeout = setTimeout(delayed, threshold || 10); 
      };
  }
	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
 
})(jQuery,'smartresize');

/*
DEBOUNCED SCROLL
*/

(function($,sr){
 
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
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('scroll', debounce(fn)) : this.trigger(sr); };
 
})(jQuery,'smartscroll');

var shows = []; //global array of section offsetTops for the page.

jQuery.fn.borderScroll = function(currentPos) {
        var currentBubble = 1; //Init the current bubble var.
		var $articles = $('.post-type-archive-show #shows article');
        if ($('.expanded').length > 0) {            
            currentBubble = $('.expanded').offsetTop;            
        }
        else {            
            $articles.first().addClass('expanded');
        }
        function closestSection() {
            yPos = currentPos;
            var checks = [];
            $.each(shows, function(){
                checks.push(Math.abs(this - yPos));       
            })
            min = Math.min.apply( Math, checks );
            return $.inArray(min, checks);
        }
        var  closestArrPos = closestSection();
        var closest = shows[closestArrPos];
        function changeSection() {
        	$articles.removeClass('invisible')
        		
            $('.expanded')
            	.removeClass('expanded')
            	.find('.info').removeAttr('style');
	
            $articles
            	.eq(closestArrPos)
            	.addClass('expanded')
            	.find('.info').vertCenter();
            	
            if(closestArrPos > 0){
            	$articles.eq(closestArrPos -1 ).addClass('invisible');
            }
        }               
        if (closest != currentBubble) {
            changeSection();
        }
                     
};

/*
INITIALISING CYCLE PLUGIN
*/

slidernav = '<nav class="slider-nav"><a class="prev">Previous</a><div class="pager"></div><a class="next">Next</a></nav><!--#slider-nav-->';

jQuery.fn.sliderInit = function(){
	$this = $(this[0]);
	var c = $this.children().length;
	p = $this.parent();
	if(c > 1){
		$this.after(slidernav);	
		$this.cycle({ 
			fx:     'fade', 
			speed:  'fast',
			timeout: 0, 
			pager:  $('.pager', p),
			next:   $('.next', p),
			prev:   $('.prev', p),
			containerResize: false,
			slideResize: false,
			fit: 1
		}).data('sliderinit' , true).sliderheight();
	}else{
		$this.data('sliderinit' , false);
	}
};

jQuery.fn.gallerySliderInit = function(){
	$this = $(this[0]);
	var c = $this.children().length;
	var p = $this.parent().parent();
	if(c > 1){
		$(this).before(slidernav);
		$(this).cycle({ 
			fx:     'fade', 
			speed:  'slow',
			timeout: 4000, 
			pager:  $('.pager', p),
			next:   $('.next', p),
			prev:   $('.prev', p),
			containerResize: false,
			slideResize: false,
			fit: 1
		}).data('sliderinit' , true).padSliderHeight();
	} else {
		$(this).data('sliderinit' , false);
	}
};

/*jQuery.fn.showSliderInit = function(){
	var c = $(this).children().length;
	if(c > 1){
		$(this).cycle({ 
			fx:     'fade', 
			speed:  'slow', 
			timeout: 2000,
			containerResize: false,
			slideResize: false,
			fit: 1,
		}).data('sliderinit' , true).sliderheight();
	}
}*/


jQuery.fn.latestSliderInit = function(){
	$this = $(this[0]);
	var c = $this.children().length;
	var p = $this.parent().parent();
	$this.children().find('.left').vertCenter();
	if(c > 1){
		$(this).before(slidernav);
		$(this).cycle({ 
			fx:     'fadeOutWaitFadeIn', 
			speed:  500,
			delayBetweenFades: 300,
			timeout: 0, 
			pager:  $('.pager', p),
			next:   $('.next', p),
			prev:   $('.prev', p),
			containerResize: false,
			slideResize: false,
			fit: 1
		}).data('sliderinit' , true).imagesLoaded( padSliderHeight );
	} else {
		$(this).data('sliderinit' , false);
	}
};

/*
MAKING SLIDES FLUID
*/

jQuery.fn.sliderheight = function() {
	if($(this).data('sliderinit') == true){
		$(this).each(function(){
			o = $(this);
			var maxHeight = 0;
			el = o.children();
			el.each(function(){
				//$(this).css('height' , '');
				if($(this).outerHeight(true) > maxHeight) {
					maxHeight = $(this).outerHeight(true);
				}
			});
			o.height(maxHeight);
		});
	}
};

//latest

jQuery.fn.padSliderHeight = function() {
	if($(this).data('sliderinit') == true){
		$this = $(this).children().first();
		ratio = $this.height() / $this.width();
		$(this)
			.css({'position' : 'absolute' , 'top' : '0', 'left' : '0', 'width' : '100%'})
		$(this)
			.parent('.slider-wrap')
			.css('padding-top', (ratio * 100) + "%");
	}
};


$.fn.cycle.transitions.fadeOutWaitFadeIn = function($cont, $slides, opts) {
    opts.fxFn = function(curr, next, opts, after) {
    	//$(next).find('.left').vertCenter();
    	cH = $(curr).height();
		cW = $(curr).width();
		cR = cH/cW;
		nH = $(next).height();
		nW = $(next).width();
		nR = nH/nW;
		if(cR == nR){
			$(curr).fadeOut(opts.speed);
			$(next).delay(opts.speed/2).fadeIn(opts.speed, function() {
					after();              
				});
		}else{
			$(curr).fadeOut(opts.speed, function() {
				$('.slider-wrap').css('padding-top', (nR * 100) + "%");
				$(next).delay(opts.delayBetweenFades).fadeIn(opts.speed, function() {
					after();              
				});
			});
		}
        
    };
};
/* 
FLUID WIDTH FORM ELEMENTS
*/

jQuery.fn.fluidSearchForm = function(){
	o = $(this[0]);
	$submit = o.find('input[type="submit"]');
	$search = o.find('input[type="text"]');
	submitWidth = $submit.outerWidth();
	submitHeight = $submit.outerHeight(); 
	if (submitWidth > 28)
	{
		$search.outerHeight(submitWidth);
		$submit.height(submitWidth);
	}else{
		$search.outerHeight(28);
		$submit.height(28);
	}
};

/*
RELEASE INFO LATEST POST VERT CENTRED
*/

jQuery.fn.vertCenter = function(){
	$(this).each(function(){
		o = $(this);
		oH = o.height();
		sH = o.siblings().height();
		shim = (sH - oH) / 2;
		if(shim > 0){
		 	o.css('margin-top' , shim);
		}else{
			o.css('margin-top' , '0');
		}
	});	
}

jQuery.fn.fancyRollCenter = function(){
	$(this).each(function(){
		o = $(this);
		//alert('fuck');
		oH = o.height();
		sH = o.parent().height();
		shim = (sH - oH) / 2;
		if(shim > 0){
		 	o.css({'margin-top' : shim});
		}else{
			//o.css('margin-top' , '0');
		}
	});	
}

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
		var html = '<li class="video vimeo"><a href="http://player.vimeo.com/video/' + videos[i].id + '?autoplay=1"' ;
		html += 'class="lightbox fancybox.iframe vimeo red-roll" rel="gallery-vid-aside">';
		html += '<img src="' + videos[i].thumbnail_small + '" class="media-img" />';
		html += '<div class="info"><h3 class="vid-title">' + videos[i].title + '</h3>';
		html += '<p class="vid-decription faint">' + videos[i].description + '</p></li></div></a>';
		
		$('#latest-videos ul').append(html);
	}
	
	link = '<li><a href="http://vimeo.com/user3362379" class="block red-roll" title="Stolen Recordings on Vimeo" rel="bookmark">Stolen Records on Vimeo</a></li>';
	$('#latest-videos ul').append(link);
}

/*
GET FLICKR FOR MEDIA PAGE 
*/

/*$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=8546357@N03&lang=en-us&format=json&jsoncallback=?", function(data){
  $.each(data.items, function(i,item){
    $("<img/>").attr("src", item.media.m).appendTo("#flickr-images #photos")
      .wrap("<div class='flickr-photo'><a href='" + item.link + "'></a></div>");
      if ( i == 10 ) return false;
  });
});*/

jQuery.fn.scPlayerHeight = function(){
	o = $(this[0]);
	playWidth = o.outerWidth();
		$('.sc-controls a , .sc-played, .sc-buffer, .sc-scrubber, .sc-time-span img').each(function(){
			$(this).outerHeight(playWidth);
	});
	$('.sc-scrubber').width($('.sc-player').outerWidth() - playWidth);
	//$('.sc-artwork-list .active').height($('.sc-info').outerHeight());
	activeScr = $('.sc-artwork-list .active img').attr('src');	
	$('.sc-info').css({
		"background-image" : "url('" + templateDir + "/images/info-bg.png') , url('"+activeScr+"')",
		"background-size" : "auto , cover",
		"background-position-y" : "40%"
	});
}

/*
ISOTOPE
*/

var $container = $('#flickr-images #photos')
$container.isotope();


/*$(function(){
 $('#slider').anythingSlider({
 	expand : true,
 	resizeContents: true
 });
});*/
$('.lightbox').fancybox({
		fitToView	: false,
		width 		: '80%',
		height		: '60%',
		autoSize	: false,
		arrows		: true
});
$(document).ready(function() {

	$("#social-tabs" ).tabs();
	$("#latest-slider").latestSliderInit();
	$("#artist-slider").gallerySliderInit();
	$(".slider").sliderInit();
	$('.single-release article .left').vertCenter();
	$(".fancy-roll").hover(function(){
		$(this).find('.wrap').fancyRollCenter();
	});	
	$(window).smartresize(function(){  
		$(".slider").sliderheight();
		$('.sc-controls a').scPlayerHeight();
		$('form[role="search"]').fluidSearchForm();
		$('.post-type-archive-show .expanded .info, #latest article .left, .single-release article .left').vertCenter();
		//$(".fancy-roll .info .wrap").fancyRollCenter();
	});	

	/*$('.lightbox').fancybox({
		fitToView	: false,
		width 		: '80%',
		height		: '60%',
		autoSize	: false,
		arrows		: true
	});*/
	
	$(document).bind('onPlayerInit.scPlayer', function(event){
		$('.sc-player').prepend($('.sc-scrubber , .sc-controls'), function(){
			$('.sc-player').prepend($('.sc-volume-slider , .sc-time-indicators'));	
		});
		$('.sc-controls a').scPlayerHeight();
		$('.sc-track-duration').each(function(){
			$(this).siblings().append($(this));
		});
	});
	
	$(document).bind('onPlayerPlay.scPlayer', function(event){
	  $('.sc-controls a').scPlayerHeight();
	});
	
	//CURRENT MENU ITEM ADD CLASS
	currentPage = document.location.href;
	$('#access a').each(function(){
		target = $(this).attr('href');
		if(currentPage.indexOf(target) != -1){
			$(this).parent().addClass('active');
		}
	});
	
	$('form[role="search"]').fluidSearchForm();
	
	$('.expander').expander({
		slicePoint: 250
	});
	
	/*$('.releases-divider').each(function(){
			$(this).remove();
	});*/	
	$('#releases').filter(function (index) { 
		if ($(this).children().length < 1){
			$(this).remove();
			$('.releases-divider').remove();
		}
	});
	
	$('.post-type-archive-show #shows article').each(function() {            
        shows.push(this.offsetTop);        
    });
    
    $(window).scroll(function(){
        $(this).borderScroll($(this).scrollTop());
        $('.smart').append('fire</br>');
    }).scroll();
	
	$('#primary').infinitescroll({
		navSelector  : "#nav-below",            
		nextSelector : ".nav-previous a",    
		itemSelector : "#primary article.post",
		extraScrollPx: 250,
		loading: {
					finishedMsg: "",
					img: templateDir + "/images/loader.png",
					msgText: ""
					}
	});
	
	$(".post").fitVids();
	
	relLength = $('aside#releases ul li').length;
	if(relLength < 1){
		$('aside#releases').remove();
	}
	
});

