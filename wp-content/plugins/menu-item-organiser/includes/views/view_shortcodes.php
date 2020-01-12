<?php
/**
 * @author: Tirstan Oostdijk
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
add_shortcode( 'view-menu', 'load_menu_main_view' );


/**
 * @param $atts
 * @param null $content
 */
function load_menu_main_view( $atts, $content = null ) {
    include MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR. '/menu_item_list.php';
};