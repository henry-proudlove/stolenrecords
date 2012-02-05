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
    'supports' => array( 'title', 'editor', 'thumbnail')
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
    'supports' => array( 'title', 'editor', 'thumbnail' )
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
    'supports' => array( 'title', 'editor', 'thumbnail')
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
	'types' => array('artist' , 'page'), 
	'context' => 'normal', 
	'priority' => 'high',
	'exclude_template' => array('publishing.php', 'page.php'),
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
	'save_action' => 'video_save_action',
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

$review_mb = new WPAlchemy_MetaBox(array
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

//END metaboxes

/*
=======================================================
MARKUP	
=======================================================
*/


/*---------------------------------------------------
Releases + artists landing page
*/

function sr_relart_loop_markup(){
	global $post;
	if('artist' == get_post_type()){
		$sr_post_class = get_post_meta(get_the_ID(),'_sr_present-past',TRUE);
		if ($sr_post_class == 'past'){
			$artist_status = '<span class="artist-status">' . $sr_post_class . '</span>'; 
		}else{
			$artist_status = null;
		}
	}else{
		$sr_post_class = null;
		$artist_status = null;
	}
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($sr_post_class); ?> role="article">
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		<?php sr_post_thumbnail('medium' , false); ?>
		<header class="entry-header">
			<?php _sr_post_header(); ?>
			<?php echo $artist_status ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</a>
	</article><!-- #post-<?php the_ID(); ?> -->

<?php }

/* END Releases + artists landing page
---------------------------------------------------*/


/*---------------------------------------------------
Shows
*/

function sr_shows_markup($aside){
	global $post;
	
	$datetime = get_post_meta(get_the_ID(),'_sr_show-date',TRUE);
	$datetime = new DateTime($datetime);
	$date = $datetime->format('l, jS F Y');
	$time = $datetime->format('g:iA'); 
	$venue = get_post_meta(get_the_ID(),'_sr_show-venue',TRUE);
	$venue_link = get_post_meta(get_the_ID(),'_sr_show-venue-link',TRUE);
	$buy_tix = get_post_meta(get_the_ID(),'_sr_buy-tickets-link',TRUE);
	
	
	if($aside == false):
		$h_tag = 'h1';
		$artist_terms = get_the_terms( $post->ID, 'artist' );
		$artists = array();
		foreach ($artist_terms as $artist_term)
		{
			$artist = get_page_by_title($artist_term->name , OBJECT, 'artist');
			$artist = array('ID' => $artist->ID , 'title' => $artist->post_title, 'guid' => $artist->guid);
			array_push($artists, $artist);
		}
		$artists_count = count($artists);?>
	
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<?php if($buy_tix): ?>
				<a href="<?php echo $buy_tix; ?>" title="Buy Tickets" rel="bookmark">
				<div class="show-img-gallery">
				<?php sr_shows_images($artists); ?>
				</div><!--.show-img-gallery-->
				</a>
			<?php else: ?>
				<div class="show-img-gallery">
				<?php sr_shows_images($artists); ?>
				</div><!--.show-img-gallery-->
			<?php endif; ?>
		<div class="info">
	<?php else: 
		$h_tag = 'h3'; ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<?php endif; ?>
			<header class="entry-header">
				<time class="show-date"><?php echo $date; ?></time>
				<?php echo '<' . $h_tag . ' class="entry-title">'; ?>
				<?php if($buy_tix): ?>
					<a href="<?php echo $buy_tix; ?>" title="Buy Tickets" rel="bookmark">
					<?php the_title(); ?></a>
				<?php else: ?>
					<?php the_title(); ?>
				<?php endif; ?>
				<?php echo '</' . $h_tag . '>'; ?>
			</header><!-- .entry-header -->
			
			<div class="entry-meta">
				<?php if($aside == false && $artists_count > 0):?>
					<ul class="artists">
					<?php foreach($artists as $artist):?>
						<li>
							<a href="<?php echo $artist['guid']; ?>" title="More about <?php echo $artist['title'];?>" rel="bookmark">
							<?php echo $artist['title'];?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<time class="show-time"><?php echo $time; ?></time>
				<?php if($venue_link && $venue):?>
					<span class="venue"><a href="<?php echo $venue_link; ?>" title="More info" rel="bookmark"><?php echo $venue; ?></a></span>
				<?php elseif($venue): ?>
					<span class="venue"><?php echo $venue; ?></span>
				<?php elseif($venue_link):?>
					<span class="venue"><a href="<?php echo $venue_link; ?>" title="More info" rel="bookmark"></span>
					<?php echo $venue_link; ?></a>
				<?php endif; ?>
			</div>
	
	<?php if($aside == false): ?>
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
			
			<?php if($buy_tix): ?>
				<a class="button buy-tickets" href="<?php echo $buy_tix; ?>" title="Buy Tickets" rel="bookmark">Buy Tickets</a>
			<?php endif; ?>
		</article><!-- #post-<?php the_ID(); ?> -->
	<?php else: ?>
		</li><!-- #post-<?php the_ID(); ?> -->
	<?php endif;
}

/* END Shows
---------------------------------------------------*/


/*---------------------------------------------------
Social links on artist page and about
*/

function sr_social_links()
{
	global $artist_lnks_mb;
	$meta = $artist_lnks_mb->the_meta();
	if($meta['artist_soc_links']){
	echo '<nav id="social-links">';
		foreach ($meta['artist_soc_links'] as $art_links_meta)
		{	
			$artist_link = $art_links_meta['art_social_a'];
			$artist_name = get_the_title();
			
			if(strpos($artist_link , 'facebook.com'))
			{
				$art_link_source = 'Facebook';
				
			}elseif (strpos($artist_link , 'twitter.com'))
			{	
				$art_link_source = 'Twitter';
				
			}elseif (strpos($artist_link , 'soundcloud.com'))
			{	
				$art_link_source = 'Soundcloud';
				
			}elseif (strpos($artist_link , 'bandcamp.com'))
			{	
				$art_link_source = 'Bandcamp';
				
			}elseif (strpos($artist_link , 'vimeo.com'))
			{	
				$art_link_source = 'Vimeo';
				
			}elseif (strpos($artist_link , 'youtu.be') || strpos($video_link , 'youtube.com'))
			{	
				$art_link_source = 'Youtube';
				
			}elseif (strpos($artist_link , 'myspace.com'))
			{	
				$art_link_source = 'Myspace';
				
			}else
			{
				$art_link_source = 'generic'; 
			}
			
			$art_link_class = strtolower($art_link_source);
			if($art_link_source != 'generic')
			{
				$art_link_title = $artist_name . ' on ' . $art_link_source;
			}else
			{
				$art_link_title = str_replace(array('http://' , 'www.' , '/') , '' , $artist_link);
			}
			echo '<a href="'. $artist_link .'" class"' . $art_link_class . '" title="' . $art_link_title . '" rel="bookmark">' . $art_link_title . '</a> ';  
		}
	echo '</nav><!--#social-links-->';
	}
}

/* END Social links
---------------------------------------------------*/


/*---------------------------------------------------
Pagination
*/


// loop page pagination
function sr_posts_navigation(){
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) : ?>
		<nav id="nav-below" role="article">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'themename' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'themename' ) ); ?></div>
		</nav><!-- #nav-below -->
	<?php endif; ?>
<?php }

// Single posts nav
function sr_single_post_navigation(){?>
	<nav id="nav-below" role="article">
		<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'themename' ) . '</span> %title' ); ?></div>
		<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'themename' ) . '</span>' ); ?></div>
	</nav><!-- #nav-below -->
<?php }


/* END Pagination
---------------------------------------------------*/


/*---------------------------------------------------
Post Header
*/

function _sr_post_header(){
	global $post;?>
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
<?php }

/* END Post Header
---------------------------------------------------*/



/*---------------------------------------------------
Asides
*/

//get artist releases

function sr_rels_by_artist($args = array())
{	
	$defaults = array(
		'artist' => '',
		'thumb_size' => 'thumbnail',
		'limit' => '6',
		'buy_now' => true,
		'exclude' => '',
		'aside' => false
	);
	
	$options = array_merge($defaults , $args);
	$query_args = array(
		'post_type' => 'release' ,
		'posts_per_page' => $options['limit'] ,
		'post__not_in' => array($options['exclude']),
		'tax_query' => array(
			array(
				'taxonomy' => 'artist',
				'field' => 'id',
				'terms' => $options['artist']
			)
		)
	);
	$aside = $options['aside'];
	if(!$aside)
	{
		$wrapper_o = '<section id="releases">';
		$wrapper_c = '</section><!--#releases-->';
		$article_tag = 'article';
	}else{
		$wrapper_o = '<aside id="releases"><h2 class="aside-header">Releases</h2><ul class="artist-releases">';
		$wrapper_c = '</ul></aside><!--#releases-->';
		$article_tag = 'li';
	}
	$rel_sub_query = new WP_query($query_args);
	if( have_posts() ):
		echo $wrapper_o;	
		while ($rel_sub_query->have_posts() ): $rel_sub_query->the_post();?>
				<<?php echo $article_tag;?>  class="release">
				<?php $rel_id = get_the_ID(); ?>
				<?php sr_post_thumbnail($options['thumb_size'] , false);?>
				<?php _sr_post_header();
				$release_date = get_post_meta( $rel_id , '_sr_release-date', true);
				
				if ($release_date)
				{	
					$release_date = date_create($release_date);
					$release_date = date_format($release_date, 'Y');
					echo '<time class="release-date">' . $release_date . '</time>';
				}
				
				$buy_now_link = get_post_meta ( $rel_id , '_sr_release-buy-link' , true);
				
				if ($buy_now_link && $options['buy_now'])
				{
					$curr_date = date('U');
					$release_date = strtotime($release_date);
					if ($curr_date <= $release_date)
					{
						echo '<a class="buy-link preorder">Preorder now</a>';
					}else
					{
						echo '<a class="buy-link buy-now">Buy Now</a>';
					}
				}?>
			</<?php echo $article_tag; ?>>
		<?php endwhile; 
		echo $wrapper_c;
		endif; wp_reset_query();
}

//Reviews

function sr_get_reivews($reviews)
{	
	foreach($reviews as $review)
	{
		if($review['review-link']){
			$reviewlnk_o = '<a href="' . $review['review-link'] . '" rel="bookmark">';
			$reviewlnk_c = '</a>';
		}?>
		<div class="review">
		<q><?php echo $review['review-text']; ?></q>
		<cite> <?php echo $reviewlnk_o ?>
		<?php echo $review['review-attr']; ?>
		<?php echo $reviewlnk_c; ?></cite></div>
	<?php }
}

//Get 4 Shows by artist
function sr_artist_shows($artist, $aside)
{
	$current_datetime = date('Y-m-d H:i');
	$meta_query_str = array(
		array(
			'key' => '_sr_show-date', 
			'compare' => '>=' ,
			'value' => $current_datetime
		)
	);
	
	$args = array(
		'posts_per_page' => '4' ,
		'post_type' => 'show' ,
		'artist' => $artist,
		'orderby' => 'meta_value',
		'meta_key' => '_sr_show-date' ,
		'order' => 'ASC' , 
		'meta_query' => $meta_query_str
	);
	
	$the_query = new WP_query($args); ?>
	
	<aside id="shows">
		<h2 class="aside-header">Shows</h2>
		<ul class="artist-shows">
	<?php if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();?>
		<?php sr_shows_markup($aside); ?>
		
	<?php endwhile; else: ?>
			
		<li id="no-shows" role="article">
			<header class="entry-header"><h3 class="entry-title">Sorry, no gigs coming up</h3></header>
			<span class="no-shows-msg">Check back soon or <?php get_twitter_link(); ?> for incessant updates </span>
		</li>
		
	<?php endif; ?>
		</ul>
	</aside><!--#shows-->
	<?php wp_reset_query();
}

//Artist page sample tracks
function sr_artist_tracks($artist)
{	
	$tracks = array();
	global $tracks_mb;
	$meta = $tracks_mb->the_meta();
	$trackmeta = $meta['tracks'];
	
	if($trackmeta){
		foreach ($trackmeta as $track){
			$track = $track['track-link'];
			if (!in_array($track , $tracks)){
				array_push($tracks, $track);
			}
		}
	} 
	$args = $rel_args = array('post_type' => 'release' , 'artist' => $artist , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
		
	if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
	
		$meta = $tracks_mb->the_meta();
		$trackmeta = $meta['tracks'];
	
		if($trackmeta){
			foreach ($trackmeta as $track){
				$track = $track['track-link'];
				if (!in_array($track , $tracks)){
					array_push($tracks, $track);
				}
			}
		} 
	
	endwhile; endif; wp_reset_query();
	
	$tracks_count = count($tracks);
	if($tracks_count > 7){
		$tracks = array_slice($tracks, 0, 7);
	}
	if(!empty($tracks)){
		echo '<aside id="tracks"><h2 class="aside-header">Listen</h2><ul>';
		foreach ($tracks as $track)
		{	
			echo '<li><a href="' . $track . '" class="sample-track">' . $track . '</a></li>';
		}
		echo '</ul></aside><!--#tracks-->';
	}
}

//Release page sample tracks
function sr_release_tracks()
{	
	$tracks = array();
	global $tracks_mb;
	$meta = $tracks_mb->the_meta();
	$trackmeta = $meta['tracks'];
	
	if($trackmeta){
		foreach ($trackmeta as $track){
			$track = $track['track-link'];
			if (!in_array($track , $tracks)){
				array_push($tracks, $track);
			}
		}
	} 
	$tracks_count = count($tracks);
	if($tracks_count > 7){
		$tracks = array_slice($tracks, 0, 7);
	}
	if(!empty($tracks)){
		echo '<aside id="tracks"><h2 class="aside-header">Listen</h2><ul>';
		foreach ($tracks as $track)
		{	
			echo '<li><a href="' . $track . '" class="sample-track">' . $track . '</a></li>';
		}
		echo '</ul></aside><!--#tracks-->';
	}
}

/* END Asides
---------------------------------------------------*/
//END MARKUP


/*
=======================================================
VIDEO
=======================================================
*/


/*---------------------------------------------------
Home page latest videos
*/

function _sr_latest_videos_init(){
	if(is_home()):?>
	
		<script>
		
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
				for (var i = 0; i < 5; i++) {	
					var html = '<li><a href="' + videos[i].url + '"><img src="' + videos[i].thumbnail_medium + '" class="thumb" />';
					html += '<p class="vid-title">' + videos[i].title + '</p></li>';
					html += '<p class="vid-decription">' + videos[i].description + '</p></a></li>';
					$('#thumbs ul').append(html);
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
		</script>
	
	<?php endif;
}

add_action('wp_footer' , '_sr_latest_videos_init');

function _sr_latest_videos(){ ?>
	<div id="wrapper">
		<div id="embed"></div>
		<div id="thumbs">
			<ul></ul>
		</div>
	</div>
<?php }

/* END Home page latest videos
---------------------------------------------------*/


/*---------------------------------------------------
Main video fetcher
*/

function sr_get_videos($videos){
	
	$i=0;
	$videos_count = count($videos);
	
	for($i = 0; $i < $videos_count; $i++)
	{
		$videos[$i] = array('video_link' => $videos[$i]);
	}
	
		
	for($i = 0; $i < $videos_count; $i++)
	{	
		
		$video_link = $videos[$i]['video_link'];
		if(strpos($video_link , 'vimeo.com'))
		{
			$video_id = substr($video_link , 17);
			$videos[$i]['id'] = $video_id;
			$videos[$i]['endpoint'] = 'http://vimeo.com/api/v2/video/' . $video_id  . '/videos.xml';
			$videos[$i]['vendor'] = 'vimeo';
			$videos[$i]['is_valid'] = 'true';
			
		}elseif (strpos($video_link , 'youtu.be'))
		{	
			$video_id = substr($video_link , 16);
			$videos[$i]['id'] = $video_id;
			$videos[$i]['endpoint'] = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id ;
			$videos[$i]['vendor'] = 'youtube';
			$videos[$i]['is_valid'] = 'true';
		}elseif (strpos($video_link , 'youtube.com'))
		{
			$video_id = substr($video_link , 31 , 11);
			$videos[$i]['id'] = $video_id;
			$videos[$i]['endpoint'] = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id ;
			$videos[$i]['vendor'] = 'youtube';
			$videos[$i]['is_valid'] = 'true';
		}else
		{
			$videos[$i]['is_valid'] = 'false';
		}
	}
	
	//Fetching the data
	
	$curl_arr = array();
	$master = curl_multi_init();
	
	for($i = 0; $i < $videos_count; $i++)
	{
		$url = $videos[$i]['endpoint'];
		$curl_arr[$i] = curl_init($url);
		curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
		curl_multi_add_handle($master, $curl_arr[$i]);
	}
	
	do {
		curl_multi_exec($master,$running);
	} while($running > 0);
	
	//Poplulating results
	
	for($i = 0; $i < $videos_count; $i++)
	{	
		$vid_data = simplexml_load_string(curl_multi_getcontent  ( $curl_arr[$i]  ));
		
		if($videos[$i]['vendor'] == 'vimeo')
		{
			$vid_data = $vid_data->video;
			$videos[$i]['title'] = (string) $vid_data->title;
			$videos[$i]['thumbnail_large'] = (string) $vid_data->thumbnail_large;
			$videos[$i]['thumbnail_small'] = (string) $vid_data->thumbnail_small;
			$videos[$i]['description'] = (string) strip_tags($vid_data->description);
		}elseif($videos[$i]['vendor'] == 'youtube')
		{
			$videos[$i]['title'] = (string) $vid_data->title;
			$videos[$i]['thumbnail_large'] = (string) 'http://img.youtube.com/vi/'. $videos[$i]['id'] .'/0.jpg';
			$videos[$i]['thumbnail_small'] = (string) 'http://img.youtube.com/vi/'. $videos[$i]['id'] .'/1.jpg';
			$videos[$i]['description'] = (string) strip_tags($vid_data->content);
		}
	}
	return $videos;
}

/* END Main video fetcher
---------------------------------------------------*/


/*---------------------------------------------------
Media Page videos
*/

function sr_media_videos(&$dont_copy)
{
	global $post;
	global $video_mb;

	$meta = $video_mb->the_meta();
	if($meta['videos'])
	{	
		$videos_meta = $meta['videos'];
		$videos = array();
		$i = 0;
		foreach ($videos_meta as $video)
		{	
			$video_link = $video['video-link'];
			if(!in_array($video_link , $dont_copy))
			{
				array_push($videos , $video_link);
				array_push($dont_copy , $video_link);
			}
		}
		$videos = sr_get_videos($videos);
		foreach($videos as $video)
		{
			if($video['is_valid'] == 'true')
			{?>
				<article class="media-thumb video <?php echo $video['vendor'] ?>">
					<a href="<?php echo $video['video_link'] ?>" class="video-link">
						<img src="<?php echo $video['thumbnail_large']?>" class="media-img <?php echo $video['vendor'] ?>" />
						<div class="info">
							<h1><?php echo $video['title'] ?></h1>
							<p><?php echo $video['description'] ?></p>
						</div>
					</a>
				</article>
			<?php }
		}
		$video_count = count($videos);
		return $video_count;
	}else{
		return 0;
	}
}

/* END Media Page videos
---------------------------------------------------*/


/*---------------------------------------------------
Artist Page videos
*/

function sr_artist_videos($artist)
{
	global $post;
	global $video_mb;
	
	$videos = array();

	$meta = $video_mb->the_meta();
	$post_id = $post->ID;
	if($meta['videos'])
	{	
		$videos_meta = $meta['videos'];
		foreach ($videos_meta as $video)
		{	
			$video_link = $video['video-link'];
			if(!in_array($video_link , $videos))
			{
				array_push($videos , $video_link);
			}
		}
	}
	$args = $rel_args = array('post_type' => 'release' , 'artist' => $artist , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
		
	if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
		$meta = $video_mb->the_meta();
		if($meta['videos'])
		{	
		$videos_meta = $meta['videos'];
			foreach ($videos_meta as $video)
			{	
				$video_link = $video['video-link'];
				if(!in_array($video_link , $videos))
				{
					array_push($videos , $video_link);
				}
			}
		}
	endwhile; endif; wp_reset_query();
	
	$videos_count = count($videos);
	if($videos_count > 4){
		$videos = array_slice($videos, 0, 4);
	}
	if(!empty($videos)){
		echo '<aside id="videos"><h2 class="aside-header">Videos</h2><ul>';
		$videos = sr_get_videos($videos);
		video_aside_markup($videos);
		echo '</ul></aside><!--#videos-->';
	}
	
}

function sr_release_videos()
{
	global $post;
	global $video_mb;
	
	$videos = array();

	$meta = $video_mb->the_meta();
	$post_id = $post->ID;
	if($meta['videos'])
	{	
		$videos_meta = $meta['videos'];
		foreach ($videos_meta as $video)
		{	
			$video_link = $video['video-link'];
			if(!in_array($video_link , $videos))
			{
				array_push($videos , $video_link);
			}
		}
	}
	
	$videos_count = count($videos);
	if($videos_count > 4){
		$videos = array_slice($videos, 0, 4);
	}
	if(!empty($videos)){
		echo '<aside id="videos"><h2 class="aside-header">Videos</h2><ul>';
		$videos = sr_get_videos($videos);
		video_aside_markup($videos);
		echo '</ul></aside><!--#videos-->';
	}
	
}

/* END Artist Page videos
---------------------------------------------------*/


/*---------------------------------------------------
Video Aside markup
*/
function video_aside_markup($videos)
{
	foreach($videos as $video)
	{
		if($video['is_valid'] == 'true')
		{?>
			<li class="video <?php echo $video['vendor'] ?>">
				<a href="<?php echo $video['video_link'] ?>" class="video-link">
					<img src="<?php echo $video['thumbnail_small']?>" class="media-img <?php echo $video['vendor'] ?>" />
					<div class="info">
						<h1><?php echo $video['title'] ?></h1>
						<p><?php echo $video['description'] ?></p>
					</div>
				</a>
			</li>
		<?php }
	}
}
/* END Video Aside markup
---------------------------------------------------*/
//END VIDEOS


/*
=======================================================
IMAGES
=======================================================
*/

/*---------------------------------------------------
Main attachtment fetcher
*/

function sr_get_images( $args = array() ) {
	
	global $post;
	
	$defaults = array(
		'size' => 'thumbnail', 
		'limit' => '0',
		'offset' => '0',
		'big' => 'large',
		'post_id' => $post->ID,
		'link' => 'self',
		'img_class' => 'attachment-image',
		'wrapper' => true,
		'wrapper_class' => 'attachment-image-wrapper',
		'include' => '',
		'exclude' => ''
	);
	
	$options = array_merge( $defaults, $args );
	
	$size = $options['size'];
	$limit = $options['limit'];
	$offset = $options['offset'];
	$big = $options['big'];
	$link = $options['link'];
	$img_class = $options['img_class'];
	$wrapper = $options['wrapper'];
	$wrapper_class = $options['wrapper_class'];
	
	$images = get_children( array(
		'post_parent' => $options['post_id'],
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => 'ASC',
		'orderby' => 'menu_order ID' ,
		'include' => $options['include'],
		'exclude' => $options['exclude']
	));
	
	//Adding parent title as class
	$parent_title = strtolower(get_the_title($options['post_id']));
	$parent_title_class = str_replace(' ', '-' , $parent_title);
	$img_class .= ' ' . $parent_title_class;
	$wrapper_class .= ' ' . $parent_title_class; 

	if ($images) {

		$num_of_images = count($images);
		
		if ($offset > 0) : $start = $offset--; else : $start = 0; endif;
		if ($limit > 0) : $stop = $limit+$start; else : $stop = $num_of_images; endif;

		$i = 0;
		foreach ($images as $attachment_id => $image) {
			if ($start <= $i and $i < $stop) {
			$img_title = $image->post_title;   // title.
			$img_description = $image->post_content; // description.
			$img_caption = $image->post_excerpt; // caption.
			//$img_page = get_permalink($image->ID); // The link to the attachment page.
			$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			if ($img_alt == '') {
			$img_alt = $img_title;
			}
				if ($big == 'large') {
				$big_array = image_downsize( $image->ID, $big );
 				$img_url = $big_array[0]; // large.
				} else {
				$img_url = wp_get_attachment_url($image->ID); // url of the full size image.
				}

			// FIXED to account for non-existant thumb sizes.
			$preview_array = image_downsize( $image->ID, $size );
			if ($preview_array[3] != 'true') {
			$preview_array = image_downsize( $image->ID, 'thumbnail' );
 			$img_preview = $preview_array[0]; // thumbnail or medium image to use for preview.
 			$img_width = $preview_array[1];
 			$img_height = $preview_array[2];
			} else {
 			$img_preview = $preview_array[0]; // thumbnail or medium image to use for preview.
 			$img_width = $preview_array[1];
 			$img_height = $preview_array[2];
 			}
 			// End FIXED to account for non-existant thumb sizes.

			if($wrapper == true):?>
			<article class="<?php echo $wrapper_class ?>">
			<?php endif; ?>
			<?php if($link == 'self'):?>
			<a href="<?php echo $img_url; ?>" title="<?php echo $img_title; ?>">
			<?php elseif($link == 'parent'):?>
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php endif; ?>
			<img class="<?php echo $img_class;?>" src="<?php echo $img_preview; ?>" alt="<?php echo $img_alt; ?>" title="<?php echo $img_title; ?>" />
			<?php if($link == 'self'):?>
				<div class="info">
				<?php if ($img_caption != '') : ?>
					<div class="attachment-caption"><?php echo $img_caption; ?></div>
				<?php endif; ?>
				<?php if ($img_description != '') : ?>
					<div class="attachment-description"><?php echo $img_description; ?></div>
				<?php endif; ?>
					<span>Click to zoom</span>
					</div>
			<?php endif; ?>
			<?php if($link == 'self' || $link == 'parent'):?>
			</a>
			<?php endif; ?>
			<?php if($wrapper == true):?>
			</article>
			<?php endif; 
			// End custom image tag. Do not edit below here.
			///////////////////////////////////////////////////////////
			
			}
			$i++;
		}

	}
}

/* END Main attachtment fetcher
---------------------------------------------------*/

/*---------------------------------------------------
Image display
*/

// Default post thumbnail. Check for video, thumbnail, if not show first attachment
function sr_post_thumbnail($size , $show_video)
{ 	
	global $post;
	if ($show_video == true && 'post' == get_post_type() && get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE)):
		$vid_link = get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE);
		$embed_code = wp_oembed_get($vid_link);
		echo $embed_code;	
	elseif (has_post_thumbnail()):
		$post_thumb = get_post_thumbnail_id();
		$options = array(
			'size' => $size,
			'big' => 'full' ,
			'img_class' => 'post',
			'wrapper' => false ,
			'include' => $post_thumb,
			'link' => $link
		);
		sr_get_images($options);
	else:
		$options = array(
			'size' => $size,
			'big' => 'full' ,
			'img_class' => 'post',
			'wrapper' => false ,
			'limit' => '1',
			'link' => $link
		);
		sr_get_images($options);
	endif;
}

//Artist Page gallery. Thumbnail leads, if not set all images in menu order

function sr_artist_gallery(){
	global $post;
	if(has_post_thumbnail())
	{	
		$post_thumb = get_post_thumbnail_id();
		$options = array(
			'size' => 'thumbnail',
			'big' => 'full' ,
			'img_class' => 'artist-header attachment-image',
			'wrapper' => false ,
			'include' => $post_thumb
		);
		sr_get_images($options);
	}else
	{
		$post_thumb = '';
	}
	$options['include'] = '';
	$options['exclude'] = $post_thumb;
	sr_get_images($options);
	wp_reset_query();
}

//Shows image. Post thumb/flyer if not all artists
function sr_shows_images($artists )
{
	global $post;
	if (has_post_thumbnail()){
		the_post_thumbnail('medium');
	}else{
		$args = array('size' => 'medium');
		$artist_count = count($artists);
		foreach($artists as $artist)
		{	
			$artist_id = $artist['ID'];
			if(has_post_thumbnail($artist_id)){
				echo get_the_post_thumbnail( $artist_id, 'medium' );
			}else{
				$options = array(
					'size' => 'medium',
					'wrapper' => false ,
					'limit' => '1',
					'link' => 'none',
					'post_id' => $artist_id
				);
				sr_get_images($options);
			}
		}
	}
}
/*
End Image display
---------------------------------------------------*/

/*
=======================================================
MISC
=======================================================
*/

//Get twitter link
function get_twitter_link(){?>
	<a href="http://www.twitter.com/mysadcaptains" title="Follow stolen on Twitter">Follow us on twitter</a>
<?php }

//END MISC
?>