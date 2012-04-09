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

/*
SHOWS PAGE
*/

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
		//$(this).after(slidernav);
		$(slidernav).insertAfter('.slider-wrap');
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
		}).data('sliderinit' , true).padSliderHeight();
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
		}).resize();
	}
};

//latest

jQuery.fn.padSliderHeight = function() {
	if($(this).data('sliderinit') == true){
		$(this).imagesLoaded(function(){
			$this = $(this).children().first();
			ratio = $this.height() / $this.width();
			$(this)
				.css({'position' : 'absolute' , 'top' : '0', 'left' : '0', 'width' : '100%'})
			$(this)
				.parent('.slider-wrap')
				.css('padding-top', (ratio * 100) + "%");
		});
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
	$(this).imagesLoaded(function(){
		 //console.log( 'all images has finished with loading, do some stuff...' );
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
		}).resize();
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
		var html = '<li class="vimeo"><a href="http://player.vimeo.com/video/' + videos[i].id + '?autoplay=1"' ;
		html += 'class="lightbox video vimeo red-roll">';
		html += '<img src="' + videos[i].thumbnail_small + '" class="media-img" />';
		html += '<div class="info"><h3 class="vid-title">' + videos[i].title + '</h3>';
		html += '<p class="vid-decription faint">' + videos[i].description + '</p></li></div></a>';

		$('#latest-videos ul').append(html);
	}

	link = '<li><a href="http://vimeo.com/user3362379" class="block red-roll" title="Stolen Recordings on Vimeo" rel="bookmark">Stolen Records on Vimeo</a></li>';
	$('#latest-videos ul').append(link).find('.lightbox').colorbox({
		iframe:true,
		width:"80%",
		height:"60%",
		returnFocus : false
	});
}

/*
FILTER BUILDER
*/

function filtrationUnits(filterString){
	if (filterString !== undefined){
		var isotopeFilter = '<div class="isotope-filter"><header class="filter-header collapse"><h1 class="filter-title"><span class="arrow-icon"></span>Filter</h1></header><nav class="filters"><ul class="artist-list filter-list"><li class="filter-item artist"><a href="#" data-filter="*" class="selected">All Artists</a></li>' + filterString + '</ul></nav></div><!--.isotope-filter-->';
		
		$('.post-type-archive-release #content, .page-template-page-media-php #content').prepend(isotopeFilter);
	}else{
		filterString = '';
		alert('fuck');
	}
}

$(document).ready(function() {
	$('a.lightbox.video').colorbox({iframe:true, width:"80%", height:"60%", returnFocus : false});
	
	$('a.lightbox.photo, a.lightbox.flickr').colorbox({opacity	: 0.85 , returnFocus : false});
	
	$("#social-tabs" ).tabs();
	
	$("#latest-slider").latestSliderInit();
	
	$("#artist-slider").gallerySliderInit();
	
	$(".slider").sliderInit();
	
	$('.single-release article .left').vertCenter();
	
	$(".fancy-roll").hover(function(){
		$(this).find('.wrap').fancyRollCenter();
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
	
	$container = $('#isotope-wrap');
	$container.imagesLoaded(function(){
		$(this).isotope({
			itemSelector : '.fancy-roll',
		});
	});
	
	//Filtering
	
	$('.isotope-filter .filter-header').click(function(){
		if($(this).hasClass('collapse')){
			$(this).removeClass('collapse');
		}else{
			$(this).addClass('collapse');
		}
		return false;
	});
	
	$('.post-type-archive-release .filter-list a').click(function(){
		$(this).parents('.filter-list').find('.selected').removeClass('selected');
		$(this).addClass('selected');
		var selector = $(this).attr('data-filter');
		$('#isotope-wrap').isotope({
			filter: selector,
			itemSelector : '.fancy-roll',
		});
		return false;
	});
	
	$('.page-template-page-media-php .filter-list a:not(.flickr-link)').click(function(){
	
		$sib = $(this).parents('.filter-list').siblings();
		$sibselected = $sib.find('.selected')
		sibselect = $sibselected.attr('data-filter');
		var selector = $(this).attr('data-filter');
		$selected = $(this).parents('.filter-list').find('.selected');
		
		if(selector == '.flickr' || sibselect == '.flickr'){
			$sibselected.removeClass('selected');
			$sib.find('a[data-filter="*"]').addClass('selected');
			$selected.removeClass('selected');
			$(this).addClass('selected');
			
		}else if(selector == sibselect) {
			$selected.removeClass('selected');
			$(this).addClass('selected');
		}else{
			selector += sibselect;
			$selected.removeClass('selected');
			$(this).addClass('selected');
		}
		$('#isotope-wrap').isotope({
			filter: selector,
			itemSelector : '.fancy-roll',
		});
		return false;
	});
	
	$filters = $('.post-type-archive-release .isotope-filter li');
	filtercount = $filters.length;
	filtermodulus = filtercount % 4;
	if(filtermodulus == 0 || filtercount < 4){
		$filters.addClass('filter-no-border');
	}else{
		start = filtercount - filtermodulus;
		end = filtercount;
		$filters.slice(start, end).addClass('filter-no-border');
	}
	//console.log(filtermodulus);
	
	
	$(window).smartresize(function(){  
		$(".slider").sliderheight();
		$('.sc-controls a').scPlayerHeight();
		$('form[role="search"]').fluidSearchForm();
		$('.post-type-archive-show .expanded .info, #latest article .left, .single-release article .left').vertCenter();
		
		$('#isotope-wrap').isotope('reLayout');
	});
	
	/*$('.fancy-roll img').lazyload({
		effect : 'fadeIn'
	});*/
	
});
