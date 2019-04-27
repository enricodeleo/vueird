      <footer class="footer-main bg-primary">
      	<div class="bg-primary pt-4 pb-3">
      		<div class="container text-center text-white">
      			<nav class="footer-navbar navbar navbar-dark">
      				<?php
						wp_nav_menu( array(
							'theme_location'  => 'footer_navigation',
							'depth'           => 1,
							'menu_class'      => 'nav m-auto small text-center',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker()
						) );
					?>
      			</nav>
      			<div class="row">
      				<div class="col">
      					<p><small>&copy; <?php echo bloginfo( 'name' ); ?> <?php echo date('Y'); ?> All Rights Reserved</small></p>
      				</div>
      			</div>

      			<nav class="footer-navbar navbar navbar-dark">
      				<?php
						wp_nav_menu(array(
							'theme_location'  => 'legal_navigation',
							'depth'           => 1,
							'menu_class'      => 'nav m-auto small text-center',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker()
						));
					?>
      			</nav>
      		</div>
      	</div>

      </footer>

	  <?php wp_footer(); ?>

	</body>

</html>
