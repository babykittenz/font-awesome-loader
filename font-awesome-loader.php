<?php
/**
 * Plugin Name: Font Awesome Pro Loader
 * Plugin URI: https://github.com/risepoint/font-awesome-loader
 * Description: A plugin to enqueue Font Awesome Pro icons in WordPress.
 * Version: 1.0
 * Author: Michael Kidby
 * Author URI: https://github.com/babykittenz
 * License: MIT
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Font Awesome Pro CSS and JS
 */
function enqueue_font_awesome_pro() {
    // Enqueue Font Awesome Pro CSS
    wp_enqueue_style(
        'font-awesome-pro-css',
        plugins_url( '/assets/css/all.min.css', __FILE__ ),
        array(),
        '6.5.1'
    );

    // Enqueue Font Awesome Pro JS (if needed)
    wp_enqueue_script(
        'font-awesome-pro-js',
        plugins_url( '/assets/js/all.min.js', __FILE__ ),
        array(),
        '6.5.1',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome_pro' );
