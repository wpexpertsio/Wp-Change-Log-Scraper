<?php

/*
Description: create shortcode with id attribute. first you add the url in custom change loge

*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
function wpcls_wp_change_log( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',
    ), $atts );

    $plugin_url_id = $atts['id'];

    if(!empty($plugin_urls)){
        return "please inter the id";
    }

    $plugin_urls = get_the_title( $plugin_url_id );
    $html = file_get_contents($plugin_urls); //get the html returned from the following url

    $postMetaValue = wpcls_get_string_between($plugin_url_id,"changelog_data",true);
    if($postMetaValue)
    {

        $post_id = $plugin_url_id;
        $publishdate = get_the_date('l F j, Y', $post_id);
        $then = $publishdate;
        $then = new DateTime($then);
        $now = new DateTime();
        $sinceThen = $then->diff($now);
        $deffirent_days = $sinceThen->d;

        if ($deffirent_days  < 2 ) {

            $custom_fields = get_post_custom($plugin_url_id);
            $metas = get_post_meta($post_id, 'changelog_data', true);
            return '<div id="wp_changelog">'.$metas.'</div>';

        } else {
            $plugin_data = file_get_contents($plugin_urls);

            $get_change_log = wpcls_get_string_between($plugin_data,'<div id="tab-changelog" class="plugin-changelog section">','</div>');

                update_post_meta($post_id, 'changelog_data', $get_change_log);
            }
            $metas = get_post_meta($post_id, 'changelog_data', true);
        return '<div id="wp_changelog">'.$metas.'</div>';
    }
    else {
        $plugin_urls = get_the_title( $plugin_url_id );
        $html = file_get_contents($plugin_urls);
        $wp_change_doc = new DOMDocument();
        libxml_use_internal_errors(TRUE); //disable libxml errors
        $wp_change_doc->loadHTML($html);
        libxml_clear_errors(); //remove errors for yucky html
        $plugin_data = $html;
       $get_change_log = wpcls_get_string_between($plugin_data,'<div id="tab-changelog" class="plugin-changelog section">','</div>');

            update_post_meta($plugin_url_id, 'changelog_data', $get_change_log);
        }

    $metas = get_post_meta($plugin_url_id, 'changelog_data', true);
    return '<div id="wp_changelog">'.$metas.'</div>';

 }
add_shortcode('wp-change-log-scraper', 'wpcls_wp_change_log' );


function wpcls_get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}
?>