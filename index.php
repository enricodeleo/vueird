<?php get_header(); ?>
<main role="main" aria-label="Content">
    <div class="container mt-4 mb-5">
        <?php if ( have_posts() ) : ?>
        <?php
	while ( have_posts() ) : the_post();
	$index = $wp_query->current_post + 1;
?>

        <article class="row">
            <div class="col-12 col-md-6 p-0 <?php echo $index % 2 === 0 ? 'order-md-last' : ''; ?>">
                <a href="<?php echo get_the_permalink(); ?>">
                    <img v-lazy="'<?php echo get_the_post_thumbnail_url(); ?>'" class="img-fluid" alt="<?php echo get_the_title(); ?>">
                </a>
            </div>
            <div class="col-12 col-md-6 p-0 bg-primary d-flex d-flex-column justify-content-center align-items-center text-center">
                <div class="p-5">
                    <h3 class="text-white"><?= get_the_title(); ?></h3>
                    <p class="text-white"><?= get_the_excerpt(); ?></p>
                    <a href="<?= get_the_permalink(); ?>" class="btn btn-light text-uppercase">Read more</a>
                </div>
            </div>
        </article>

        <?php
endwhile;
bootstrap_pagination();
endif;
?>
    </div>
</main>
<?php get_footer();
