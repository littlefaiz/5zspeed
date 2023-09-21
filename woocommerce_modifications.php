<?php

//Max 1 product to add to cart
  
add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart', 99, 2 );
   
function bbloomer_only_one_in_cart( $passed, $added_product_id ) {
   wc_empty_cart();
   return $passed;
}




//Add to cart redirect 

add_filter( 'woocommerce_add_to_cart_redirect', 'add_to_cart_checkout_redirection', 10, 1 );
function add_to_cart_checkout_redirection( $url ) {
    return wc_get_checkout_url();
}


//Snippet JavaScript Tulisan Berkedip

function ti_custom_javascript() {
    ?>
      
        <script type="text/javascript">
  function JavaBlink() {
     var blinks = document.getElementsByTagName('JavaBlink');
     for (var i = blinks.length - 1; i >= 0; i--) {
        var s = blinks[i];
        s.style.visibility = (s.style.visibility === 'visible') ? 'hidden' : 'visible';
     }
     window.setTimeout(JavaBlink, 70);
  }
  if (document.addEventListener) document.addEventListener("DOMContentLoaded", JavaBlink, false);
  else if (window.addEventListener) window.addEventListener("load", JavaBlink, false);
  else if (window.attachEvent) window.attachEvent("onload", JavaBlink);
  else window.onload = JavaBlink;
</script>
    
  
    <?php
}
add_action('wp_head', 'ti_custom_javascript');








/**
 * Set WooCommerce image dimensions upon theme activation
 */
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}


//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'crunchify_disable_woocommerce_loading_css_js' );
function crunchify_disable_woocommerce_loading_css_js() {
    // Check if WooCommerce plugin is active
    if( function_exists( 'is_woocommerce' ) ){
        // Check if it's any of WooCommerce page
        if(! is_woocommerce() && ! is_cart() && ! is_checkout() ) {         
            
            ## Dequeue WooCommerce styles
            wp_dequeue_style('woocommerce-layout'); 
            wp_dequeue_style('woocommerce-general'); 
            wp_dequeue_style('woocommerce-smallscreen');     
            ## Dequeue WooCommerce scripts
            wp_dequeue_script('wc-cart-fragments');
            wp_dequeue_script('woocommerce'); 
            wp_dequeue_script('wc-add-to-cart'); 
        
            wp_deregister_script( 'js-cookie' );
            wp_dequeue_script( 'js-cookie' );
        }
    }    
}




/**
 * @snippet       Remove Order Notes - WooCommerce Checkout
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );



/**
 * @snippet       WooCommerce: Display Product Discount in Order Summary @ Checkout, Cart
 * @author        Sandesh Jangam
 * @donate $7     https://www.paypal.me/SandeshJangam/7
 */
  
add_filter( 'woocommerce_cart_item_subtotal', 'ts_show_product_discount_order_summary', 10, 3 );
 
function ts_show_product_discount_order_summary( $total, $cart_item, $cart_item_key ) {
     
    //Get product object
    $_product = $cart_item['data'];
     
    //Check if sale price is not empty
    if( '' !== $_product->get_sale_price() ) {
         
        //Get regular price of all quantities
        $regular_price = $_product->get_regular_price() * $cart_item['quantity'];
         
        //Prepend the crossed out regular price to actual price
        $total = '<span style="text-decoration: line-through; opacity: 0.5; padding-right: 5px;">' . wc_price( $regular_price ) . '</span>' . $total;
    }
     
    // Return the html
    return $total;
}


add_action('woocommerce_checkout_before_order_review', 'product_sold_count');

function product_sold_count () {
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        
        $product = $cart_item['data'];
        $units_sold = $product->get_total_sales();
        $stock = $product->get_stock_quantity();
        
        if(!empty($product)){
            // $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' );
  
           
            
            
            if ($units_sold >= '5') {
            echo''.sprintf( __( ' <p style="
			display: inline-block; 
			padding:5px 10px 5px 10px; 
			border-radius: 5px 5px 5px 5px;
			background-color: #d9534f; 
			font-size: 17px; 
			font-weight: 800; 
			color: #FFFFF; 
            "> <font color="#FFFFF"> HARINI: </font>  <javablink>  
            <font color="#FFFFF"> COD PERCUMA</font> </javablink>  
            ', 'woocommerce'), $units_sold ) .'</p>';}

          
            // to display only the first product image uncomment the line below
            // break;
        
            

               
         
        }
        
        
    }
}



 




//Buang checkout

// hide coupon field on the checkout page

function njengah_coupon_field_on_checkout( $enabled ) {

            if ( is_checkout() ) {

                        $enabled = false;

            }

            return $enabled;

}

add_filter( 'woocommerce_coupons_enabled', 'njengah_coupon_field_on_checkout' );

//Tukar Header Billing
function change_billing_details_heading( $translated_text, $text, $domain ) {
    if ( $text === 'Billing details' ) {
        $translated_text = 'Isi borang penghantaran dibawah.';
    }
    return $translated_text;
}
add_filter( 'gettext', 'change_billing_details_heading', 20, 3 );


//Buang Continue Shopping
function remove_continue_shopping_button( $messages ) {
    // Check if the message contains the "Continue shopping" button
    if ( strpos( $messages, 'Continue shopping' ) !== false ) {
        // Remove the "Continue shopping" button from the message
        $messages = preg_replace('/<a.*?class="button wc-forward".*?>.*?<\/a>/', '', $messages);
    }
    return $messages;
}
add_filter( 'woocommerce_add_message', 'remove_continue_shopping_button', 10, 1 );

//Your Order
function change_order_heading_text( $content ) {
    return str_replace( 'Your order', 'Order anda', $content );
}
add_filter( 'the_content', 'change_order_heading_text' );

//Cart Message

add_filter( 'wc_add_to_cart_message', 'woocartmsg_custom_wc_add_to_cart_message', 10, 2 ); 
function woocartmsg_custom_wc_add_to_cart_message( $message, $product_id ) { 
    $message = sprintf(esc_html__('Anda telah pilih %s!'), get_the_title( $product_id ) ); 
    return $message; 
}



add_filter('woocommerce_cart_item_name', 'replace_with_sku_short_description', 10, 3);

function replace_with_sku_short_description($item_name, $cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    $sku = $product->get_sku();
    $short_description = $product->get_short_description();

    return $item_name . '<br><small>' . $short_description . '</small>';
}



add_action('woocommerce_before_checkout_form', 'display_descriptions_above_checkout_form');

function display_descriptions_above_checkout_form() {
    // Embedding CSS
    echo '<style>
        .checkout-item-custom-description {
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>';
    
    // Loop through each cart item
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        if ( !$product ) continue;

        // Get SKU
        $sku = $product->get_sku();

        // If SKU exists, display the description
        if ( $sku ) {
            echo '<div class="checkout-item-custom-description">';
            echo '<strong>' . $product->get_name() . '</strong><br>';
            echo $product->get_description();
            echo '</div>';
        }
    }
}