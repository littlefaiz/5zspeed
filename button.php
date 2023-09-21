<?php


// Add a menu to the WordPress admin area
add_action('admin_menu', 'wc_custom_button_text_menu');

function wc_custom_button_text_menu() {
    add_menu_page('WooCommerce Button Text', 'WC Button Text', 'manage_options', 'wc_custom_button_text', 'wc_custom_button_text_page');
}

function wc_custom_button_text_page() {
    ?>
    <div class="wrap">
        <h2>WooCommerce Custom Order Button Text</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('wc-custom-button-text');
            do_settings_sections('wc_custom_button_text');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register the setting to store the custom text
add_action('admin_init', 'wc_custom_button_text_settings');

function wc_custom_button_text_settings() {
    register_setting('wc-custom-button-text', 'wc_order_button_text');
    add_settings_section('wc_custom_button_text_section', 'Settings', 'wc_custom_button_text_section_text', 'wc_custom_button_text');
    add_settings_field('wc_order_button_field', 'Button Text', 'wc_order_button_field_input', 'wc_custom_button_text', 'wc_custom_button_text_section');
}

function wc_custom_button_text_section_text() {
    echo '<p>Edit WooCommerce order button text here.</p>';
}

function wc_order_button_field_input() {
    $option = get_option('wc_order_button_text');
    echo '<input id="wc_order_button_field" name="wc_order_button_text" type="text" value="'.esc_attr($option).'" />';
}

// Change the button text based on the option set in the admin
add_filter('woocommerce_order_button_text', 'misha_custom_button_text');

function misha_custom_button_text($button_text) {
    $custom_text = get_option('wc_order_button_text');
    return !empty($custom_text) ? $custom_text : $button_text;
}