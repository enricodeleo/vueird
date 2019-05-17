<?php

include_once './lib/wp-bootstrap-navwalker.php';

// Clean up wordpres <head>
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    $manifest = json_decode(file_get_contents('build/assets.json', true));
    $main = $manifest->main;
    wp_enqueue_style('font-awesome','https://use.fontawesome.com/releases/v5.7.2/css/all.css', false, null);
    wp_enqueue_style('theme-css', get_template_directory_uri() . "/build/" . $main->css,  false, null);
	wp_enqueue_script('theme-js', get_template_directory_uri() . "/build/" . $main->js, ['jquery'], null, true);
}, 100);

/**
 * Expose some useful info to js
 */
add_action('wp_enqueue_scripts', function () {
	$site_globals = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'restBaseUrl' => get_rest_url(),
		'restWpUrl' => get_rest_url(null, 'wp/v2'),
	);

	wp_localize_script('theme-js', 'siteGlobals', $site_globals);
}, 101);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'vueird'),
        'footer_navigation' => __('Footer Navigation', 'vueird'),
        'legal_navigation' => __('Legal Navigation', 'vueird')
    ]);
    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
	add_theme_support('post-thumbnails');

	/**
	 * Set the default thumbnail size
	 */
	set_post_thumbnail_size(570, 570);

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
	// add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Enable wide elements support for Gutenberg
	 */
	add_theme_support('align-wide');

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	add_theme_support('editor-styles');
	add_editor_style('build/editor-style.css'); // Enqueue editor styles.

}, 20);

add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }
    return $classes;
}

/**
 * @param WP_Query|null $wp_query
 * @param bool $echo
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo bootstrap_pagination($query);
 *     ?>
 */
function bootstrap_pagination(\WP_Query $wp_query = null, $echo = true)
{
	if (null === $wp_query) {
		global $wp_query;
	}
	$pages = paginate_links(
		[
			'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
			'format'       => '?paged=%#%',
			'current'      => max(1, get_query_var('paged')),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __('« Prev'),
			'next_text'    => __('Next »'),
			'add_args'     => false,
			'add_fragment' => ''
		]
	);
	if (is_array($pages)) {
		//$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
		$pagination = '<div class="pagination"><ul class="pagination">';
		foreach ($pages as $page) {
			$pagination .= '<li class="page-item"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
		}
		$pagination .= '</ul></div>';
		if ($echo) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}
	return null;
}
