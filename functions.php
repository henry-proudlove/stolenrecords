<?php
/**
 * @package WordPress
 * @subpackage themename
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'themename', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/**
 * Remove code from the <head>
 */
//remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
//remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
//remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );
// Hide the version of WordPress you're running from source and RSS feed // Want to JUST remove it from the source? Try: remove_action('wp_head', 'wp_generator');
/*function hcwp_remove_version() {return '';}
add_filter('the_generator', 'hcwp_remove_version');*/
// This function removes the comment inline css
/*function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );*/

/**
 * Remove meta boxes from Post and Page Screens
 */
function customize_meta_boxes() {
   /* These remove meta boxes from POSTS */
  //remove_post_type_support("post","excerpt"); //Remove Excerpt Support
  //remove_post_type_support("post","author"); //Remove Author Support
  //remove_post_type_support("post","revisions"); //Remove Revision Support
  //remove_post_type_support("post","comments"); //Remove Comments Support
  //remove_post_type_support("post","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("post","editor"); //Remove Editor Support
  //remove_post_type_support("post","custom-fields"); //Remove custom-fields Support
  //remove_post_type_support("post","title"); //Remove Title Support

  
  /* These remove meta boxes from PAGES */
  //remove_post_type_support("page","revisions"); //Remove Revision Support
  //remove_post_type_support("page","comments"); //Remove Comments Support
  //remove_post_type_support("page","author"); //Remove Author Support
  //remove_post_type_support("page","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("page","custom-fields"); //Remove custom-fields Support
  
}
add_action('admin_init','customize_meta_boxes');

/**
 * This theme uses wp_nav_menus() for the header menu, utility menu and footer menu.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'themename' ),
	'footer' => __( 'Footer Menu', 'themename' ),
	'utility' => __( 'Utility Menu', 'themename' )
) );

/** 
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * This theme uses post thumbnails
 */
add_theme_support( 'post-thumbnails' );

/**
 *	This theme supports editor styles
 */

//add_editor_style("/css/layout-style.css");

/**
 * Disable the admin bar in 3.1
 */
//show_admin_bar( false );

/**
 * This enables post formats. If you use this, make sure to delete any that you aren't going to use.
 */
//add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video', 'gallery', 'chat', 'link', 'quote', 'status' ) );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function handcraftedwp_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar', 'themename' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s" role="complementary">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'init', 'handcraftedwp_widgets_init' );

/*
 * Remove senseless dashboard widgets for non-admins. (Un)Comment or delete as you wish.
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Plugins widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPress Blog widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Other WordPress News widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Right Now widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Quick Press widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Incoming Links widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Recent Drafts widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Recent Comments widget
}

/**
 *	Hide Menu Items in Admin
 */
function themename_configure_dashboard_menu() {
	global $menu,$submenu;

	global $current_user;
	get_currentuserinfo();

		// $menu and $submenu will return all menu and submenu list in admin panel
		
		// $menu[2] = ""; // Dashboard
		// $menu[5] = ""; // Posts
		// $menu[15] = ""; // Links
		// $menu[25] = ""; // Comments
		// $menu[65] = ""; // Plugins

		// unset($submenu['themes.php'][5]); // Themes
		// unset($submenu['themes.php'][12]); // Editor
}


// For non-admins, add action to Hide Dashboard Widgets and Admin Menu Items you just set above
// Don't forget to comment out the admin check to see that changes :)
if (!current_user_can('manage_options')) {
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets'); // Add action to hide dashboard widgets
	add_action('admin_head', 'themename_configure_dashboard_menu'); // Add action to hide admin menu items
}


?>
<?php // asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet
//	 change the UA-XXXXX-X to be your site's ID
/*add_action('wp_footer', 'async_google_analytics');
function async_google_analytics() { ?>
	<script>
	var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
		(function(d, t) {
			var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
			g.async = true;
			g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g, s);
		})(document, 'script');
	</script>
<?php }*/ 

//Read more link

function new_excerpt_more($more) {
       global $post;
	return '...<div class="read-more"><a href="'. get_permalink($post->ID) . '">Read more</a></div>';
}
add_filter('excerpt_more', 'new_excerpt_more');


//Truncation

function _sr_truncate($string, $limit, $break=0, $pad="...")
{	
	$string = strip_tags($string);
	// return with no change if string is shorter than $limit
	if(strlen($string) <= $limit) return $string;
	
	if($break=0){
		$string = substr($string, $limit) . $pad;
		return $string;
	}
	// is $break present between $limit and the end of the string?
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
	if($breakpoint < strlen($string) - 1) {
	  $string = substr($string, 0, $breakpoint) . $pad;
	}
	}
	
  return $string;
}

/*
=======================================================
POST TYPES
=======================================================
*/


add_action( 'init', 'type_taxon_init' );

function type_taxon_init() {

//Shows
  $labels = array(
    'name' => _x('Shows', 'post type general name'),
    'singular_name' => _x('Show', 'post type singular name'),
    'add_new' => _x('Add New', 'Show'),
    'add_new_item' => __('Add New Show'),
    'edit_item' => __('Edit Show'),
    'new_item' => __('New Show'),
    'all_items' => __('All Shows'),
    'view_item' => __('View Show'),
    'search_items' => __('Search Shows'),
    'not_found' =>  __('No shows found'),
    'not_found_in_trash' => __('No shows found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Shows'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/css/menu-icons/calendar-list.png',
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 6,
    'taxonomies' => array( 'artist' ),
    'supports' => array( 'title', 'editor', 'thumbnail' , 'revisions')
  ); 
  register_post_type('show',$args);
  
// Artists
  $labels = array(
    'name' => _x('Artists', 'post type general name'),
    'singular_name' => _x('Artist', 'post type singular name'),
    'add_new' => _x('Add New', 'Artist'),
    'add_new_item' => __('Add New Artist'),
    'edit_item' => __('Edit Artist'),
    'new_item' => __('New Artist'),
    'all_items' => __('All Artists'),
    'view_item' => __('View Artist'),
    'search_items' => __('Search Artists'),
    'not_found' =>  __('No artists found'),
    'not_found_in_trash' => __('No artists found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Artists',
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/css/menu-icons/cards-address.png',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 7,
    'supports' => array( 'title', 'editor', 'thumbnail' , 'revisions')
  ); 
  register_post_type('artist',$args);
  
// Releases
  $labels = array(
    'name' => _x('Releases', 'post type general name'),
    'singular_name' => _x('Release', 'post type singular name'),
    'add_new' => _x('Add New', 'Release'),
    'add_new_item' => __('Add New Release'),
    'edit_item' => __('Edit Release'),
    'new_item' => __('New Release'),
    'all_items' => __('All Releases'),
    'view_item' => __('View Release'),
    'search_items' => __('Search Releases'),
    'not_found' =>  __('No releases found'),
    'not_found_in_trash' => __('No releases found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Releases',
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/css/menu-icons/cassette.png',
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'editor', 'thumbnail' , 'revisions')
  ); 
  register_post_type('release',$args);
  
// Artist Taxonomy
  $labels = array(
    'name' => _x( 'Artist', 'taxonomy general name' ),
    'singular_name' => _x( 'Artist', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Artists' ),
    'all_items' => __( 'All Artists' ),
    'parent_item' => __( 'Parent Artists' ),
    'parent_item_colon' => __( 'Parent Artists:' ),
    'edit_item' => __( 'Edit Artist' ), 
    'update_item' => __( 'Update Artist' ),
    'add_new_item' => __( 'Add New Artist' ),
    'new_item_name' => __( 'New Genre Artist' ),
    'menu_name' => __( 'Artist' ),
  ); 	

  register_taxonomy('artist',array('post', 'release' , 'show'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'artist' ),
    'show_in_nav_menus' => false
  ));
}

/*
=======================================================
AUTO ADD ARTIST TERM ON ARTIST TYPE PUBLISH
=======================================================
*/

//Create term on publish

function create_artist_term($post_ID) {
	$this_post = get_post($post_ID); 
	$title = $this_post->post_title;
	
	wp_insert_term($title, 'artist');
}

add_action('publish_artist', 'create_artist_term');

// Remove on delete Cannot get this to work

/*function delete_artist_term($post_ID) {
	
	$this_post = get_post($post_ID); 
	$title = $this_post->post_title;
	
	$term_Num = get_term_by('name' , $title , 'artist');
	
	echo $term_Num->term_id;
	//echo "Title: ".$term_Num['term_id'];
	//print_r ($term_Num);
	
	//wp_delete_term($term_Num->term_id, 'artist');
}

add_action('puslish_artist', 'delete_artist_term');*/

/*
=======================================================
METABOXES	
=======================================================
*/

include_once WP_CONTENT_DIR . '/wpalchemy/MetaBox.php';
 
// global styles for the meta boxes
if (is_admin()) wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/metaboxes/meta.css');


$featured_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_featured_post',
	'title' => 'Push to top of home page',
	'types' => array('post' , 'artist' , 'show' , 'release'),
	'context' => 'side',
	'priority' => 'low',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/metaboxes/featured-post-meta.php'
));

$artist_lnks_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_artist_lnks',
	'title' => 'Social Links',
	'types' => array('artist'), 
	'context' => 'normal', 
	'priority' => 'high',
	'template' => get_stylesheet_directory() . '/metaboxes/artist-links-meta.php'
));

$past_artist_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_past_artist',
	'title' => 'Artist Status',
	'types' => array('artist'),
	'context' => 'side',
	'priority' => 'low',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/metaboxes/past-artist-meta.php'
));

$show_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_show_details',
	'title' => 'Show Details',
	'types' => array('show'),
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/metaboxes/shows-meta.php'
));

$release_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_release_details',
	'title' => 'Release Details',
	'types' => array('release'),
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/metaboxes/release-meta.php'
));

$video_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_videos',
	'title' => 'Videos',
	'types' => array('release' , 'artist'),
	'context' => 'side',
	'priority' => 'low',
	'template' => get_stylesheet_directory() . '/metaboxes/videos-meta.php'
));

$tracks_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_tracks',
	'title' => 'Sample Tracks',
	'types' => array('release' , 'artist'),
	'context' => 'side',
	'priority' => 'low',
	'template' => get_stylesheet_directory() . '/metaboxes/tracks-meta.php'
));

$reivew_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_reviews',
	'title' => 'Reviews',
	'types' => array('artist' , 'release'),
	'context' => 'normal',
	'priority' => 'low',
	'template' => get_stylesheet_directory() . '/metaboxes/reviews-meta.php'
));

$thumb_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_thumbs_URL',
	'title' => 'Featured Video',
	'types' => array('post'),
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/metaboxes/featured-video-meta.php'
));	

//jquery date-time picker on admin

function load_date_time_picker(){
	wp_register_script( 'datepicker', get_template_directory_uri() . '/js/jquery-ui-1.8.17.custom.min.js');
	wp_enqueue_script( 'datepicker' );
	
	wp_register_style('datepicker-css', get_template_directory_uri() . "/css/jquery-ui-1.8.17.custom.css");  
	wp_enqueue_style( 'datepicker-css');
	
	wp_register_script( 'timepicker', get_template_directory_uri() . '/js/jquery-ui-timepicker-addon.js');
	wp_enqueue_script( 'timepicker' );
	
	wp_register_style('timepicker-css', get_template_directory_uri() . "/css/jquery-ui-timepicker-addon.css");  
	wp_enqueue_style( 'timepicker-css'); 
	
	
}
add_action('admin_enqueue_scripts', 'load_date_time_picker');

/*
=======================================================
Markup	
=======================================================
*/

// Markup for posts on the releases and artists landing page
function _sr_relart_loop_markup(){

	global $post;
	
	if('artist' == get_post_type()){
		$_sr_post_class = get_post_meta(get_the_ID(),'_sr_present-past',TRUE);
	}else{
		$_sr_post_class = null;
	}
	
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($_sr_post_class); ?> role="article">		
		
		<?php sr_post_thumbnail(); ?>
		
		<header class="entry-header">
			
			<?php _sr_post_header(); ?>
		
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php }

// Older newer posts nav
function sr_posts_navigation(){
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) : ?>
		<nav id="nav-below" role="article">
			<h1 class="section-heading"><?php _e( 'Post navigation', 'themename' ); ?></h1>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'themename' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'themename' ) ); ?></div>
		</nav><!-- #nav-below -->
	<?php endif; ?>
<?php }

// Featured image/video thumbnail thing
function sr_post_thumbnail(){ ?>
	<?php global $post;
	if ('post' == get_post_type()):
		array_push($dont_copy, $post->ID);
		if(get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE)):
			echo get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE);
		elseif (has_post_thumbnail()):
			the_post_thumbnail('thumbnail');
		endif;
	elseif(has_post_thumbnail()):
		the_post_thumbnail('thumbnail');
	endif;?>
<?php }

// Post Header
function _sr_post_header(){
	global $post;?>
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1><?php
}

// Shows Markup

function _sr_shows_markup(){
	global $post;?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<header class="entry-header">
			<time class="entry-date"><?php echo get_post_meta(get_the_ID(),'_sr_show-date',TRUE); ?></time>
			<?php echo get_post_meta(get_the_ID(),'_sr_stolen-show',TRUE); ?>
			<? _sr_post_header(); ?>
		</header><!-- .entry-header -->
		<?php sr_post_thumbnail() ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</article><!-- #post-<?php the_ID(); ?> -->
<?php }

// No shows message markup(){

function _sr_noshows_markup(){
	global $post;?>
	<article id="no-posts" <?php post_class(); ?> role="article">
		<header class="entry-header">
			<h1 class="entry-title">Sorry, no posts!</h1>
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<p>Try the <a title="Home Page Link" rel="bookmark" href="<?php get_home_url(); ?>">home page</a></p>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->
<?php }


/*
=======================================================
API gubbins	
=======================================================
*/


//Pulling latest videos from vimeo
function _sr_latest_videos(){

	// The Simple API URL
	$api_endpoint = 'http://vimeo.com/api/v2/';
	
	// Curl helper function
	function curl_get($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return $return;
	}
	
	// Change this to your username to load in your videos
	$vimeo_user_name = ($_GET['user']) ? $_GET['user'] : '3362379';
	
	// Load the user's videos
	$videos = simplexml_load_string(curl_get($api_endpoint.$vimeo_user_name . '/videos.xml'));
	
	
	?>
	<script>

		// Tell Vimeo what function to call
		var oEmbedCallback = 'embedVideo';

		// Set up the URL
		var oEmbedUrl = 'http://vimeo.com/api/oembed.json';

		// Load the first one in automatically?
		var loadFirst = false;

		// This function puts the video on the page
		function embedVideo(video) {
			var videoEmbedCode = video.html;
			document.getElementById('embed').innerHTML = unescape(videoEmbedCode);
		}

		// This function runs when the page loads and adds click events to the links
		function init() {
			var links = document.getElementById('thumbs').getElementsByTagName('a');

			for (var i = 0; i < $videos.length; i++) {
				// Load a video using oEmbed when you click on a thumb
				if (document.addEventListener) {
					links[i].addEventListener('click', function(e) {
						var link = this;
						loadScript(oEmbedUrl + '?url=' + link.href + '&callback=' + oEmbedCallback);
						e.preventDefault();
					}, false);
				}
				// IE (sucks)
				else {
					links[i].attachEvent('onclick', function(e) {
						var link = e.srcElement.parentNode;
						loadScript(oEmbedUrl + '?url=' + link.href + '&callback=' + oEmbedCallback);
						return false;
					});
				}
			}

			// Load in the first video
			if (loadFirst) {
				loadScript(oEmbedUrl + '?url=' + links[0].href + '&height=280&width=504&callback=' + oEmbedCallback);
			}
		}

		// This function loads the data from Vimeo
		function loadScript(url) {
			var js = document.createElement('script');
			js.setAttribute('src', url);
			document.getElementsByTagName('head').item(0).appendChild(js);
		}

		// Call our init function when the page loads
		window.onload = init;
	</script>

	<div id="wrapper">
		<div id="embed"></div>
		<div id="thumbs">
			<ul>
			<?php foreach ($videos->video as $video):
				$shortdesc = _sr_truncate($video->description, 20);?>
				<li>
					<a href="<?php echo $video->url ?>">
						<img src="<?php echo $video->thumbnail_small ?>" class="thumb" />
						<p class="video-title"><?=$video->title?></p>
						<p class="video-description"><?=$shortdesc?></p>
					</a>
				</li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>
<?php 
//echo trunc_vid_description($video->description);
}
?>