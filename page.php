<?php get_header(); ?>

<main role="main" aria-label="Content" class="clearfix">
	<!-- section -->
	<section class="mt-5">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<h1><?php the_title(); ?></h1>

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(['gutenberg']); ?>>

					<?php the_content(); ?>

				</article>
				<!-- /article -->

			<?php endwhile; ?>

		<?php else : ?>

			<!-- article -->
			<article>

				<h2><?php _e('Sorry, nothing to display.', 'vueird'); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

	</section>
	<!-- /section -->
</main>

<?php get_footer(); ?>
