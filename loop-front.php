<?php
/**
 * @package WordPress
 * @subpackage themename
 */

$args = array( 'posts_per_page' => '5' , 'meta_key' => '_sr_featured-post' , 'post_type' => array( 'post', 'show', 'artist', 'release' ) );

$the_query = new WP_Query($args);
$dont_copy = array();

/* 'Lastet' section of index */

if($the_query->have_posts() ):?>
	<section id="latest" class="twelvecol">
	<h2 class="section-header">Latest</h2>
	<div class="slider-wrap">
		<div id="latest-slider"> <?php
			while ( $the_query->have_posts() ) : $the_query->the_post();?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class('nested clearfix'); ?> role="article">		
				<div class="sixcol left">
					<div>
					<?php
					/* 
					POST
					*/
					if('post' == get_post_type()): 
						array_push($dont_copy, $post->ID);?>
						<header class="entry-header">
							<time class="entry-date"><?php echo get_the_date(); ?></time>
							<?php _sr_post_header('h1' , 'medium-h'); ?>
						</header><!-- .entry-header -->
						
						<div class="entry-summary big-center">
							<?php no_more_excerpt($post->ID); ?>
						</div><!-- .entry-summary -->
						<?php echo '<a href="'. get_permalink($post->ID) . '" class="read-more button button-large">read more</a>'; ?>
						
					<?php
					/* 
					ARTIST
					*/
					elseif('artist' == get_post_type()): ?>
						<header class="entry-header">
							<?php _sr_post_header('h1' , 'medium-h'); ?>
						</header><!-- .entry-header -->
						<div class="entry-summary big-center">
							<?php no_more_excerpt($post->ID); ?>
						</div><!-- .entry-summary -->
						<?php echo '<a href="'. get_permalink($post->ID) . '" class="read-more button button-large">read more</a>'; ?>
					<?php 
					/* 
					RELEASE
					*/
					elseif('release' == get_post_type()): ?>
						<header class="entry-header">
							<?php _sr_post_header('h1' , 'medium-h'); ?>
							<?php sr_get_rels_artist(get_the_ID()); ?>
						</header><!-- .entry-header -->
						<div class="entry-summary big-center">
						<?php no_more_excerpt($post->ID); ?>
						</div><!-- .entry-summary -->
						<?php 
							$buy_link = get_post_meta( $post->ID , '_sr_release-buy-link', true);
							if ($buy_link):
								$curr_date = date('U');
								$release_date = strtotime($release_date);
								if ($curr_date <= $release_date)
								{
									echo '<a href="'.$buy_now_link .'" class="buy-link preorder button button-large">Preorder now</a>';
								}else
								{
									echo '<a href="'.$buy_now_link .'" class="buy-link buy-now button button-large">Buy Now</a>';
								}
							endif;
						?>
					<?php
					/* 
					SHOW
					*/
					elseif('show' == get_post_type()):
						$show_meta = sr_shows_meta($post->ID); ?>
						<header class="entry-header">
							<time class="show-date"><?php echo $show_meta['date']; ?></time>
							<h1 class="entry-title medium-h">
							<?php if($show_meta['buy_tix']): ?>
								<a href="<?php echo $show_meta['buy_tix']; ?>" title="Buy Tickets" rel="bookmark">
								<?php the_title(); ?></a>
							<?php else: ?>
								<?php the_title(); ?>
							<?php endif; ?>
							</h1>
							<h2>
							<?php foreach($show_meta['artists'] as $artist):?>
								<span class="entry-artist">
									<a href="<?php echo $artist['guid'];?>" title= "More about <?php echo $artist['title']; ?>"><?php echo $artist['title']; ?></a>
								</span>
							<?php endforeach; ?>
							</h2>
							<div class="entry-meta">
								<time class="show-time"><?php echo $show_meta['time']; ?></time>
								<?php if($show_meta['venue_link'] && $show_meta['venue']):?>
									<span class="venue"><a href="<?php echo $show_meta['venue_link']; ?>" title="More info" rel="bookmark"><?php echo $show_meta['venue']; ?></a></span>
								<?php elseif($show_meta['venue']): ?>
									<span class="venue"><?php echo $show_meta['venue']; ?></span>
								<?php elseif($show_meta['venue_link']):?>
									<span class="venue"><a href="<?php echo $show_meta['venue_link']; ?>" title="More info" rel="bookmark"></span>
									<?php echo $show_meta['venue_link']; ?></a>
								<?php endif; ?>
							</div>
						</header><!-- .entry-header -->
						
						<div class="entry-summary big-center">
							<?php no_more_excerpt($post->ID); ?>
						</div><!-- .entry-summary -->
						
						<?php if($show_meta['buy_tix']): ?>
							<a class="button button-large buy-tickets" href="<?php echo $show_meta['buy_tix']; ?>" title="Buy Tickets" rel="bookmark">Buy Tickets</a>
						<?php endif; ?>
							
					<?php endif; //END post type switcher ?>
					</div>
				</div><!--.left -->
				<div class="sixcol right">
					<?php 
					if('show' == get_post_type()): 
						sr_post_thumbnail('sr-show-sixcol' , true, 'null');
					else:
						sr_post_thumbnail('sr-sixcol' , true, 'parent');
					endif;?>
				</div><!--.right-->
		
			</article><!-- #post-<?php the_ID(); ?> -->
		
			<?php endwhile;?>
			</div>
		</div>
	</section><!--#latest-->
<?php endif; ?>

<section id="news-feed" class="eightcol shim-right nested">
	<h2 class="section-header">News</h2>
	<div id="news-long">
	
	<?php /* Index 'News' section 3 posts with image */
	
		$args = array('posts_per_page' => '4' , 'post__not_in' => $dont_copy);
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">		
			
			<div class="twocol">
				<?php sr_post_thumbnail('sr-twocol' , false, 'null');
				array_push($dont_copy, $post->ID); ?>
			</div>
			<div class="sixcol">
				<header class="entry-header">
				
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					
					<?php _sr_post_header('h2' , 'small-h'); ?>
				
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
				
				<?php _sr_post_header('h2' , 'sixcol small-h'); ?>
				
			</header><!-- .entry-header -->
		
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php endwhile; ?>
	</div><!--#news-trunc-->
</section><!--#news-feed-->