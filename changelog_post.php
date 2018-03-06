<?php
/**
Description: Register a changelog post type and Meta box .
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( !post_type_exists( 'changelog' ) ) {
    // Our custom post type function
    add_action('init', 'wpcls_changelog_register_init');

    function wpcls_changelog_register_init()
    {

        $labels = array(
            'name' => _x('WP Changelog', 'post type general name', 'your-plugin-textdomain'),
            'singular_name' => _x('WP Changelog', 'post type singular name', 'your-plugin-textdomain'),
            'menu_name' => _x('WP Changelog', 'admin menu', 'your-plugin-textdomain'),
            'name_admin_bar' => _x('WP Changelog', 'add new on admin bar', 'your-plugin-textdomain'),
            'add_new' => _x('Changelog New', 'changelog', 'your-plugin-textdomain'),
            'add_new_item' => __('Add New Changelog', 'your-plugin-textdomain'),
            'new_item' => __('New Changelog', 'your-plugin-textdomain'),
            'edit_item' => __('Edit Changelog', 'your-plugin-textdomain'),
            'view_item' => __('View Changelog', 'your-plugin-textdomain'),
            'all_items' => __('All Changelog', 'your-plugin-textdomain'),
            'search_items' => __('Search Changelog', 'your-plugin-textdomain'),
            'parent_item_colon' => __('Parent Changelog:', 'your-plugin-textdomain'),
            'not_found' => __('No Changelog found.', 'your-plugin-textdomain'),
            'not_found_in_trash' => __('No Changelog found in Trash.', 'your-plugin-textdomain')
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Description.', 'your-plugin-textdomain'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'changelog'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title')
        );

        register_post_type('changelog', $args);
    }

// add custom changelog metabox
    function wpcls_changelog_add_post_meta_boxes()
    {
        add_meta_box(
            'changelog_post_class',      // Unique ID
            esc_html__('Changelog Short Code', 'wp-changeloge'),    // Title
            'wpcls_changelog_post_meta',   // Callback function
            'changelog',         // Admin page (or post type)
            'normal',         // Context
            'default'         // Priority
        );
    }

    function wpcls_changelog_post_meta_boxes_setup() {
        add_action('add_meta_boxes', 'wpcls_changelog_add_post_meta_boxes');
    }
    add_action( 'load-post.php', 'wpcls_changelog_post_meta_boxes_setup' );
    add_action( 'load-post-new.php', 'wpcls_changelog_post_meta_boxes_setup' );
    /* Display the changelog meta box. */
    function wpcls_changelog_post_meta( $post ) {
        if(isset($_GET['post'])){
            $post_id =  $_GET['post'];
            echo '<input type="text" onfocus="this.select();" readonly="readonly" value="[wp-change-log-scraper id=' . $post_id . ']" class="large-text code">';
        } else {
            echo '<p>Please publish this post to get shortcode</p>';
        }
         wp_nonce_field( basename( __FILE__ ), 'changelog_post_class' );
    }

}
?>
