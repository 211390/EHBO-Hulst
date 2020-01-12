<?php

/**
 * This Admin controller file provide functionality for the Admin section of the
 * Menu item organiser.
 *
 * @author Tirstan Oostdijk
 * @version 0.1
 *
 * Version history
 * 0.1 Initial version
 */
class MenuProductAdminController {

    /**
     * This function will prepare all Admin functionality for the plugin
     */
    static function prepare() {
// Check that we are in the admin area
        if (is_admin()) :
// Add the sidebar Menu structure
            add_action('admin_menu', array('MenuProductAdminController',
                'addMenus'));
        endif;
    }

    /**
     * Add the Menu structure to the Admin sidebar
     */
    static function addMenus() {
        add_menu_page(
// string $page_title The text to be displayed in the title tags
// of the page when the menu is selected
                __('Menu item Organiser Admin', 'menu-item-organiser'),
// string $menu_title The text to be used for the menu
                __('Menu item plug-in', 'menu-item-organiser'),
// string $capability The capability required for this menu to be displayed to the user.
                'manage_options',
// string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
                'menu_product_admin_main',
// callback $function The function to be called to output the content for this page.
                array('MenuProductAdminController', 'adminMenuPage'),
// * Pass the name of a Dashicons helper class to use a font
                'dashicons-carrot'

        );

        add_submenu_page(
            'menu_product_admin_main',
            __( 'Menu Items', 'menu-item-organiser' ),
            __( 'Menu Items', 'menu-item-organiser' ),
            'manage_options',
            'menu_product_admin_main',
            array( 'MenuProductAdminController', 'adminMenuPage' )
        );

        add_submenu_page(
            'menu_product_admin_main',
            __( 'Categories', 'menu-category-organiser' ),
            __( 'Categories', 'menu-category-organiser' ),
            'manage_options',
            'menu_category_admin_main',
            array( 'MenuProductAdminController', 'adminCategoryPage' )
        );

    }

    /**
     * The main menu page
     */
    static function adminMenuPage() {
// Include the view for this menu page.
        include  MENU_ITEM_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/menu_product_admin_main.php';
    }

    static function adminCategoryPage(){
        include MENU_ITEM_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR . '/menu_category_admin_main.php';
    }


}

?>
