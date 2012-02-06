(function( $ ) {
  jQuery.fn.stripTags = function() {
  	return this.replaceWith( this.html().replace(/<\/?[^>]+>/gi, '') );
  };
})( jQuery );

/*videoARR = [];
vidDataARR = [];

function constructVidArray(){
	$('.video').each(function(index){
		var vidURL = $(this).text();
		if(vidURL.indexOf("vimeo.com") >= 0){
			var oEmbedEndpoint = 'http://vimeo.com/api/oembed.json';
			var apiEndpoint = 'http://vimeo.com/api/v2/';
			var videoID = vidURL.replace('http://vimeo.com/', '');
			//alert(videoID);
			var formatSuffix = ''
		}
		else if (url.indexOf("youtu.be") >= 0) {
			var oEmbedEndpoint = 'http://www.youtube.com/oembed';
			var formatSuffix = '&format=json'
		}else{
			var oEmbedEndpoint = '';
			var formatSuffix = '';
		}
		var oEmbedCall = oEmbedEndpoint + '?url=' + vidURLmani + formatSuffix + '&callback=';
		videoARR.push(oEmbedCall);
	});
}
function fetchvideos(){
	$.each(videoARR, function(i, val) {
		$("body").append(i + " : " + val + "<br/>");
		/*$.getJSON(val , function(data) {
		var html = '<li><a href="' + data.url + '"><img src="' + data.thumbnail_url + '" class="thumb" />';
		html += '<p class="vid-title">' + data.title + '</p></li>';
		alert('fuck');
		});
		vidDataARR.push(html);
	});
}

$(document).ready(function() {
	
	$.each(videoARR, function(i, val) {
	  $("body").append(i + " : " + val + "<br/>");
		//vidDataARR.push(html);
});

});
*/

$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=8546357@N03&lang=en-us&format=json&jsoncallback=?", function(data){
  $.each(data.items, function(i,item){
    $("<img/>").attr("src", item.media.m).appendTo("#flickr-images")
      .wrap("<a href='" + item.link + "'></a>");
      if ( i == 10 ) return false;
  });
});