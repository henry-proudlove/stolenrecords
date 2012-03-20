<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<section id="latest" class="twelvecol">
<h2 class="section-header">Latest</h2>
<div class="slider">
<?php /* 'Lastet' section of index */

$args = array( 'posts_per_page' => '5' , 'meta_key' => '_sr_featured-post' , 'post_type' => array( 'post', 'show', 'artist', 'release' ) );

$the_query = new WP_Query($args);
$dont_copy = array();
while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class('nested'); ?> role="article">		
		<div class="sixcol left box-pack">
			<div>
		<?php if('post' == get_post_type()): 
			array_push($dont_copy, $post->ID);?>
			<header class="entry-header">
			
				<time class="entry-date"><?php echo get_the_date(); ?></time>
				<?php _sr_post_header(); ?>
			
			</header><!-- .entry-header -->
			
			<div class="entry-summary">
			<?php 
				no_more_excerpt($post->ID);
				echo '<a href="'. get_permalink($post->ID) . '" class="read-more button button-large">read more</a>';
			?>
			</div><!-- .entry-summary -->
		<?php 
		elseif('artist' == get_post_type()): ?>
			<header class="entry-header">
				<?php _sr_post_header(); ?>
			</header><!-- .entry-header -->
			<div class="entry-summary">
			<?php 
				no_more_excerpt($post->ID);
				echo '<a href="'. get_permalink($post->ID) . '" class="read-more button button-large">read more</a>';
			?>
			</div><!-- .entry-summary -->
			
		<?php elseif('release' == get_post_type()): ?>
			<header class="entry-header">
				<?php _sr_post_header(); ?>
				<?php sr_get_rels_artist($post->ID); ?>
			</header><!-- .entry-header -->
			<div class="entry-summary">
			<?php 
				no_more_excerpt($post->ID);
				$buy_link = get_post_meta( $post->ID , '_sr_release-buy-link', true);
				if ($buy_link):
					echo '<a class="button buy-now button-large" href="' . $buy_link . '" title="Buy ' . get_the_title() . '" rel="bookmark">Buy Now</a>';
				endif;
				
				echo 'fuck';
			?>
			</div><!-- .entry-summary -->
		<?php
		elseif('show' == get_post_type()):
			$datetime = get_post_meta(get_the_ID(),'_sr_show-date',TRUE);
			$datetime = new DateTime($datetime);
			$date = $datetime->format('l, j<\s\u\p>S</\s\u\p> F Y');
			$time = $datetime->format('g:i<\s\u\p>A</\s\u\p> '); 
			$venue = get_post_meta(get_the_ID(),'_sr_show-venue',TRUE);
			$venue_link = get_post_meta(get_the_ID(),'_sr_show-venue-link',TRUE);
			$buy_tix = get_post_meta(get_the_ID(),'_sr_buy-tickets-link',TRUE);
			$artist_terms = get_the_terms( $post->ID, 'artist' );
			$artists = array();
			foreach ($artist_terms as $artist_term)
			{
				$artist = get_page_by_title($artist_term->name , OBJECT, 'artist');
				$artist = array('ID' => $artist->ID , 'title' => $artist->post_title, 'guid' => $artist->guid);
				array_push($artists, $artist);
			}
			$artists_count = count($artists); ?>
			<header class="entry-header">
				<time class="show-date"><?php echo $date; ?></time>
				<h1 class="entry-title">
				<?php if($buy_tix): ?>
					<a href="<?php echo $buy_tix; ?>" title="Buy Tickets" rel="bookmark">
					<?php the_title(); ?></a>
				<?php else: ?>
					<?php the_title(); ?>
				<?php endif; ?>
				</h1>
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
				<div class="entry-summary">
				<?php 
				$excerpt = get_the_content();
				$excerpt = sr_truncate($excerpt, 250, ' ');
				echo '<p>' . $excerpt . '</p>' ;
				if($buy_tix): ?>
					<a class="button button-large buy-tickets" href="<?php echo $buy_tix; ?>" title="Buy Tickets" rel="bookmark">Buy Tickets</a>
				<?php endif; ?>
				</div><!-- .entry-summary -->
				
		<?php endif; ?>
			</div>
		</div><!--.left -->
		<div class="sixcol right">
			<?php sr_post_thumbnail('sr-sixcol' , true, 'parent');?>
		</div><!--.right-->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile;?>
</div>
</section><!--#slider-->

<section id="news-feed" class="eightcol shim-right nested">
	<h2 class="section-header">News</h2>
	<div id="news-long">
	
	<?php /* Index 'News' section 3 posts with image */
	
		$args = array('posts_per_page' => '4' , 'post__not_in' => $dont_copy);
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">		
			
			<div class="twocol">
				<?php sr_post_thumbnail('thumbnail' , false, 'parent');
				array_push($dont_copy, $post->ID); ?>
			</div>
			<div class="sixcol">
				<header class="entry-header">
				
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					
					<?php _sr_post_header('h2'); ?>
				
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php endwhile;?>
	
	</div><!--#news-long-->
	<div id="news-trunc">
	
	<?php /* 3 posts without image */
	
		$args = array('posts_per_page' => '3' , 'post__not_in' => $dont_copy);
		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) : $the_query->the_post();?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<header class="entry-header">
				
				<time class="entry-date twocol"><?php echo get_the_date(); ?></time>
				
				<?php _sr_post_header('h2' , 'sixcol'); ?>
				
			</header><!-- .entry-header -->
		
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php endwhile; ?>
	</div><!--#news-trunc-->
</section><!--#news-feed-->