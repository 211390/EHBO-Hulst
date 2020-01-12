<?php
/**
 * This Admin controller file provide functionality for the Admin section of the My event organiser.
 *
 * @author < your name >
 * @version 0.1
 *
 */

class coursePlugin_adminController
{
    /**
     * This function will prepare all Admin functionality for the plugin
     */
    static function prepare()
    {
        // Check that we are in the admin area
        if (is_admin()) :

            // Add the sidebar Menu structure
            add_action('admin_menu', array('coursePlugin_adminController', 'addMenus'));

        endif;
    }

    /**
     * Add the Menu structure to the Admin sidebar
     */
    static function addMenus()
    {
        add_menu_page(
            __('Cursus Plug-in Admin', 'coursePlugin'), // Header text
            __('Cursus Plug-in Admin', 'coursePlugin'), //Menu name
            '', //capabillity which is required to show menu.
            'cursus_plug-in_admin', // menu slug
            array('coursePlugin_adminController', 'adminMenuPage'), //array(name of controller, static function)
            'dashicons-heart' //dashicon
        );
        // sub menu toevoevoegen: Aanmaken Nieuwe Cursus
        add_submenu_page(
            'cursus_plug-in_admin', //name of main menu slug
            __('Aanmaken Nieuwe Cursus', 'coursePlugin'), // Header text
            __('Aanmaken Nieuwe Cursus', 'coursePlugin'), //Menu name
            'manage_options', //capability which is required to show menu
            'adminSubMenuCreateNewCourse', //menu slug
            array('coursePlugin_adminController', 'adminSubMenuCreateNewCourse') //array(name of controller, static function)
        );
        // sub menu toevoevoegen: Beheren Nieuwe Cursus
        add_submenu_page(
            'cursus_plug-in_admin', //name of main menu slug
            __('Beheren Nieuwe Cursus', 'coursePlugin'), // Header text
            __('Beheren Nieuwe Cursus', 'coursePlugin'), //Menu name
            'manage_options', //capability which is required to show menu
            'adminSubMenuManageNewCourse', //menu slug
            array('coursePlugin_adminController', 'adminSubMenuManageNewCourse') //array(name of controller, static function)
        );

        // sub menu toevoevoegen: Aanmaken Herhalende Cursus
        add_submenu_page(
            'cursus_plug-in_admin', //name of main menu slug
            __('Aanmaken Herhalende Cursus', 'coursePlugin'), // Header text
            __('Aanmaken Herhalende Cursus', 'coursePlugin'), //Menu name
            'manage_options', //capability which is required to show menu
            'adminSubMenuCreateRepeatingCourse', //menu slug
            array('coursePlugin_adminController', 'adminSubMenuCreateRepeatingCourse') //array(name of controller, static function)
        );
        // sub menu toevoevoegen: Beheren Herhalende Cursus
        add_submenu_page(
            'cursus_plug-in_admin', //name of main menu slug
            __('Beheren Herhalende Cursus', 'coursePlugin'), // Header text
            __('Beheren Herhalende Cursus', 'coursePlugin'), //Menu name
            'manage_options', //capability which is required to show menu
            'adminSubMenuManageRepeatingCourse', //menu slug
            array('coursePlugin_adminController', 'adminSubMenuManageRepeatingCourse') //array(name of controller, static function)
        );
    }

    /**
     * The main menu page
     */
    static function adminMenuPage()
    {
        // Include the view for this menu page.
        include COURSE_PLUGIN_ADMIN_VIEWS_DIR .
            '/admin_main.php';
    }

    /**
     * The submenu pages for the creation and managing of the 'Cursus Plug-in'.
     */
    static function adminSubMenuCreateNewCourse()
    {
        // include the view for the 'Create New Course' submenu page.
        include COURSE_PLUGIN_ADMIN_VIEWS_DIR .
            '/adminSubMenuCreateNewCourse.php';
    }

    static function adminSubMenuManageNewCourse()
    {
        // includes the view for the 'Manage New Course' submenu page.
        include COURSE_PLUGIN_ADMIN_VIEWS_DIR .
            '/adminSubMenuManageNewCourse.php';
    }

    static function adminSubMenuCreateRepeatingCourse()
    {
        // include the view for the 'Create Repeating Course' submenu page.
        include COURSE_PLUGIN_ADMIN_VIEWS_DIR .
            '/adminSubMenuCreateRepeatingCourse.php';
    }

    static function adminSubMenuManageRepeatingCourse()
    {
        // includes the view for the 'Manage Repeating Course' submenu page.
        include COURSE_PLUGIN_ADMIN_VIEWS_DIR .
            '/adminSubMenuManageRepeatingCourse.php';
    }
}
