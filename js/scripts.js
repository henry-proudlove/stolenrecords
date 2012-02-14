(function( $ ) {
  jQuery.fn.stripTags = function() {
  	return this.replaceWith( this.html().replace(/<\/?[^>]+>/gi, '') );
  };
})( jQuery );


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
      .wrap("<a href='" + item.link + "'></a>");
      if ( i == 10 ) return false;
  });
});