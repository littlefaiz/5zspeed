<?php
/**
/**
 * Plugin Name: 5Z F1
 * Description: Redbull 2023
 * Plugin URI: https://nope.com
 * Author: Faiz
 * Version: 1.44
 * Author URI: https://nope.com
 */

require __DIR__ . '/vendor/autoload.php';


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




/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_f1_speedy() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( '457f412f-5ddc-490b-8ff0-f5f8c0961bd6', 'F1 Speedy', __FILE__ );

    // Active insights
    $client->insights()->init();

    // Active automatic updater
    $client->updater();

}

appsero_init_tracker_f1_speedy();
