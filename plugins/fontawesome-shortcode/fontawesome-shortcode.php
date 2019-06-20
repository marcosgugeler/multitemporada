<?php
/*
 *  Plugin Name: Font Awesome Shortcode
 *  Description: Adds a font awesome shortcode to your WordPress
 *  Version:     1.0
 *  Author:      marcosgugeler
 *  Author URI:  https://gugelerit.com/
 *  License:     GPL2
 *
*/

function fontawesome_shortcode_js() {
    echo '<script src="https://kit.fontawesome.com/46b92bb391.js"></script>';
}
add_action( 'wp_head', 'fontawesome_shortcode_js' );

function overwrite_shortcode_fontawesome() {
    function get_fontawesome( $atts ){
        $a = shortcode_atts( array(
            'icon' => 'rocket',
        ), $atts );
        return '<i class="far fas fa-'.$a['icon'].'"></i>';
    }
    remove_shortcode( 'fontawesome' );
    add_shortcode( 'fontawesome', 'get_fontawesome' );
}
add_action('wp_loaded', 'overwrite_shortcode_fontawesome');
