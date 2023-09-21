<?php
// In your main plugin file (e.g., main.php)

// Other functions, hooks, etc.

// Function to add and activate the webhook
function add_and_activate_webhook() {
    if (class_exists('WC_Webhook')) {
        $webhook_name = 'order';
        $webhook_status = 'active';
        $webhook_topic = 'order.created';
        $delivery_url = 'https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjUwNTZkMDYzNjA0Mzc1MjZmNTUzYzUxMzQi_pc';
        $api_version = 3; // WP REST API Integration v3

        $webhook = new WC_Webhook();

        $webhook->set_name($webhook_name);
        $webhook->set_status($webhook_status);
        $webhook->set_topic($webhook_topic);
        $webhook->set_delivery_url($delivery_url);
        $webhook->set_api_version($api_version);

        $webhook->save();

        if ($webhook->get_id()) {
            // Successfully created webhook with ID: $webhook->get_id()
        } else {
            // Failed to create webhook
        }
    }
}

// Use register_activation_hook to run add_and_activate_webhook only when the plugin is activated
register_activation_hook(__FILE__, 'add_and_activate_webhook');

// More of your existing main.php code