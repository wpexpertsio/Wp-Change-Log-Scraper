<?php
/*
Plugin Name: WP Change log Scraper
Plugin URI: https://wpexperts.io/wp-change-log-scraper
Description: Easy to get change loge from wordpress using short code
Version: 1.0
Author: wpexperts.io
Author URI: https://wpexperts.io/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

include ('changelog_post.php');

// enqueue css and js files
add_action('wp_enqueue_scripts','wpcls_changelog_scripts');
function wpcls_changelog_scripts() {
    wp_enqueue_style('changelog_css-style', plugins_url( '/css/changelog_css.css', __FILE__ ));
}
include ('change-logs.php');
?>