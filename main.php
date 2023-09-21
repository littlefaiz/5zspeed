<?php
/**
/**
 * Plugin Name: 5ZF1
 * Description: Speed my own way
 * Plugin URI: https://nope.com
 * Author: Faiz
 * Version: 1.420
 * Author URI: https://nope.com
 */

// Include additional files
include( plugin_dir_path( __FILE__ ) . 'woocommerce_modifications.php');
include( plugin_dir_path( __FILE__ ) . 'button.php');


include_once( 'webhook.php' );

register_activation_hook(__FILE__, 'add_and_activate_webhook');

// ... other code

add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

function enqueue_custom_styles() {
    // Get the URL to your plugin's directory
    $plugin_dir_url = plugin_dir_url(__FILE__);
    
    // Enqueue your custom stylesheet
    wp_enqueue_style('custom-styles', $plugin_dir_url . 'css/custom-styles.css');
}
