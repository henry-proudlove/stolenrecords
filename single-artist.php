<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="primary">
	<div id="content">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<section id="intro">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
				
				<div class="entry-gallery">
					<?php sr_artist_gallery(); ?>
				</div><!-- .entry-gallery -->
				<div id="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				
				<?php sr_social_links(); ?>
			</section><!--#intro-->
			
			<?php //Getting max 6 releases by artist
			$artist_tax = get_the_title();
			$args = array(
				'post_type' => 'release' ,
				'posts_per_page' => '6' ,
				'artist' => $artist_tax
			);
			$rel_query = new WP_query($args);
			if($rel_query->have_posts() ):?>
				<section id="releases artist"><?php
				while ($rel_query->have_posts() ): $rel_query->the_post();?>
					<article class="release">
						<?php $post_id = get_the_ID(); ?>
						<?php sr_post_thumbnail('thumbnail' , false);?>
						<?php _sr_post_header();
						$release_date = get_post_meta( $post_id , '_sr_release-date', true);
						
						if ($release_date)
						{	
							$release_date = date_create($release_date);
 							$release_date = date_format($release_date, 'Y');
							echo '<time class="release-date">' . $release_date . '</time>';
						}
						
						$buy_now_link = get_post_meta ( $post_id , '_sr_release-buy-link' , true);
						
						if ($buy_now_link)
						{
							$curr_date = date('U');
							$release_date = strtotime($release_date);
							echo '</br>' . $curr_date . ' : ' . $release_date . '</br>';
							if ($curr_date <= $release_date)
							{
								echo 'Preorder now';
							}else
							{
								echo 'Buy Now';
							}
						}
						
						?> 
					</article>
			<?php endwhile; endif;?>
				
				
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php sr_single_post_navigation();?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>