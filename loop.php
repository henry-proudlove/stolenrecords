<?php /* Start the Loop */ ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
				<header class="entry-header">
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					
					<? _sr_post_header(); ?>
						<?php sr_post_thumbnail('sr-eightcol' , true, 'parent'); ?>
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</article><!-- #post-<?php the_ID(); ?> -->
			<div class="divider"></div>
		<?php endwhile; else:?>
			<article id="no-posts" <?php post_class(); ?> role="article">
				<header class="entry-header">
					<h1 class="entry-title">Sorry, no posts!</h1>
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<p>Try the <a title="Home Page Link" rel="bookmark" href="<?php get_home_url(); ?>">home page</a></p>
				</div><!-- .entry-summary -->
			</article><!-- #post-<?php the_ID(); ?> -->
			<div class="divider"></div>
<?php endif; ?>