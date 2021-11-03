<?php
/**
 * Template Name: Homepage - HQ Wheelsberry
 */
get_header();
?>
	<?php echo do_shortcode('[hq_bakery_wheelsberry_reservation_form]'); ?>
	<div class="content">
		<div class="content-columns om-container">
			<div class="content-columns__content">
				<div class="content-columns__content-inner">
					<?php while (have_posts()) : the_post(); ?>
						<article>
							<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
								<?php the_content(); ?>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>