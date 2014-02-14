<?php
/**
 * Plugin Name: WooCommerce Order Products
 * Plugin URI: https://github.com/thiagolcks/woocommerce-order-products
 * Description: Display all products of each order on the orders list.
 * Version: 1.0
 * Author: Thiago Locks
 * Author URI: https://github.com/thiagolcks
 * License: GPL2
 * GitHub Plugin URI: https://github.com/thiagolcks/woocommerce-order-products
 */

// Add the column title
add_filter( 'manage_edit-shop_order_columns', 'wcop_set_order_column', 20 );
function wcop_set_order_column( $columns ) {
	$cols = array();
	foreach($columns as $key => $title) {
		if ( $key == 'billing_address' )
			$cols['order_producten']  = __( 'Products', 'woocommerce' );
		$cols[$key] = $title;
	}
	return $cols ;
}

// Add the column content
add_action( 'manage_shop_order_posts_custom_column' , 'wcop_set_order_column_content', 10, 2 );
function wcop_set_order_column_content( $column ) {
	global $the_order;

	switch ( $column ) {
		case 'order_producten' :
			$terms = $the_order->get_items();
			if ( is_array( $terms ) ) {
				foreach($terms as $term) {
					$qtd = ( $term['item_meta']['_qty'][0] > 1 ) ? $term['item_meta']['_qty'][0] .' x ' : '';
					echo ' - ' . $qtd . $term['name'] .'<br />';
				}
			} else {
				echo '-';
			}
		break;
	}
}