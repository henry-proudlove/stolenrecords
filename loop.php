<?php /* Start the Loop */
		if ( have_posts() ) : while ( have_posts() ) : the_post();
		//add video class
		if(get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE)){
			$video = 'video';	
		}else{
			$video = null;
		}
		//now get on with your shit?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($video); ?> role="article">
				<header class="entry-header">
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					<? _sr_post_header('h1' , 'medium-h'); ?>
						<?php sr_post_thumbnail('sr-eightcol' , true, 'parent'); ?>
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</article><!-- #post-<?php the_ID(); ?> -->
		<?php endwhile; else:?>
			<article id="no-posts" <?php post_class(); ?> role="article">
				<header class="entry-header">
					<h1 class="entry-title medium-h">Sorry, no posts!</h1>
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<p>Try the <a title="Home Page Link" rel="bookmark" href="<?php get_home_url(); ?>">home page</a></p>
				</div><!-- .entry-summary -->
			<div class="divider"></div>
			</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>