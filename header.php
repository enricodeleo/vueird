<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>

<body>
	<div class="<?= implode(' ', get_body_class(['main-wrapper', 'fallback-undefined-component'])); ?>">
		<header class="header-main sticky-top">
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-light pl-0 pr-0">
					<a class="navbar-brand" href="/">
						<?= bloginfo('name'); ?>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div id="navbarNavDropdown" class="collapse navbar-collapse pt-3">
						<?php
						wp_nav_menu(array(
							'theme_location'  => 'primary_navigation',
							'depth'           => 2,
							'container'       => 'div',
							'container_class' => 'collapse navbar-collapse',
							'menu_class'      => 'nav navbar-nav ml-auto text-uppercase',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker()
						));
						?>
					</div>
				</nav>
			</div>
		</header>
