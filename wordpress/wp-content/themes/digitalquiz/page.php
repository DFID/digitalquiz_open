<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package DFID
 */

?>
	<?php if ( !is_front_page() ) : ?>
		<?php get_header(); ?>
		<!-- Sections navigation -->

		<div class="mobile-footer">

			<div class="navigation">
				<a href="#" id="prev">Previous</a>
				<br>
				<a href="#" id="next">Next</a>
			</div>

			<div class="quiz-page-controls">
				<div class="progress-meter">
					<p class="percent">0%</p>
					<p>completed</p>
				</div>
			</div>

		</div>

	<?php else : ?>
		<?php get_header('home'); ?>
	<?php endif; ?>


	<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php //print_r($exam); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php // get_sidebar(); ?>
<?php get_footer(); ?>
