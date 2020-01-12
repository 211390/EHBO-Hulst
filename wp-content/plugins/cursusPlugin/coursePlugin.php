<?php
defined('ABSPATH') OR exit;

/**
 * Plugin Name: EHBO Hulst | Cursus Plug-in
 * Plugin URI: https://stichtingivs.nl/
 * Description: Een plug-in voor het aanmaken en beheren van cursussen voor op de programma pagina.
 * Author: IVS (Innovision Solutions)
 * Author URI: https://stichtingivs.nl/
 * Version: 0.0.1
 * Text Domain: coursePlugin
 * Domain Path: languages
 *
 */

// Define the plugin name:
define('COURSE_PLUGIN', __FILE__);

// Include the general definition file:
require_once plugin_dir_path(__FILE__) . 'includes/defs.php';


/* Register the hooks */
register_activation_hook(__FILE__, array('coursePlugin', 'on_activation'));

register_deactivation_hook(__FILE__, array('coursePlugin', 'on_deactivation'));

class coursePlugin
{

    public function __construct()
    {

        // Fire a hook before the class is setup.
        do_action('COURSE_PLUGIN_pre_init');

        // Load the plugin.
        add_action('init', array($this, 'init'), 1);

    }

    public static function on_activation()
    {

        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        check_admin_referer("activate-plugin_{$plugin}");
        // Create the DB
        coursePlugin::createDb();

    }

    public static function on_deactivation()
    {
        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        check_admin_referer("deactivate-plugin_{$plugin}");
    }

    /**
     * Loads the plugin into WordPress.
     *
     * @since 1.0.0
     */
    public function init()
    {
        // Run hook once Plugin has been initialized.
        do_action('COURSE_PLUGIN_init');

        // Load admin only components.
        if (is_admin()) {

            // Load all admin specific includes
            $this->requireAdmin();

            // Setup admin page
            $this->createAdmin();
        }
        // Load the view shortcodes
        $this->loadViews();
    }

    /**
     * Loads all admin related files into scope.
     *
     * @since 1.0.0
     */
    public function requireAdmin()
    {
// Admin controller file
        require_once COURSE_PLUGIN_ADMIN_DIR . '/coursePlugin_adminController.php';
    }

    /**
     * Admin controller functionality
     */
    public function createAdmin()
    {
        coursePlugin_adminController::prepare();
    }

    /**
     * Load the view shortcodes:
     */
    public function loadViews()
    {

        include COURSE_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';

    }

    /**
     * Generate database tables
     */

    public static function createDb()
    {

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        //Calling $wpdb;
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        //Names of the tables that will be added to the db
        $courseRegistrationOverview = $wpdb->prefix . "cp_courseRegistrationOverview";
        $registration = $wpdb->prefix . "cp_registration";
        $newCourse = $wpdb->prefix . "cp_newCourse";
        $repeatingCourse = $wpdb->prefix . "cp_repeatingCourse";

        //Create the courseRegistrationOverview table
        $sql = "CREATE TABLE IF NOT EXISTS $courseRegistrationOverview(
    id INT NOT NULL AUTO_INCREMENT,
    registrationID INT NOT NULL,
    repeatingID INT NOT NULL,
    repeatingID INT NOT NULL,
    PRIMARY KEY  (id))
    ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

        //Create the registration table
        $sql = "CREATE TABLE IF NOT EXISTS $registration(
    registrationID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    mail VARCHAR(64) NOT NULL,
    tel VARCHAR(16) NOT NULL,
    comment VARCHAR(2048) NOT NULL,
    approval VARCHAR(16) NOT NULL,
    courseType INT NOT NULL,
    PRIMARY KEY  (registrationID))
    ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

        //Create the newCourse table
        $sql = "CREATE TABLE IF NOT EXISTS $newCourse(
    repeatingID INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(64) NOT NULL,
    maxParticipants INT(8) NOT NULL,
    description VARCHAR(3072) NOT NULL,
    enableParticipants INT NOT NULL,
    PRIMARY KEY  (repeatingID))
    ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

        //Create the repeatingCourse table
        $sql = "CREATE TABLE IF NOT EXISTS $repeatingCourse(
    repeatingID INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(64) NOT NULL,
    maxParticipants INT(8) NOT NULL,
    date DATE NOT NULL,
    description VARCHAR(3072) NOT NULL,
    enableParticipants INT NOT NULL,
    PRIMARY KEY  (repeatingID))
    ENGINE = InnoDB $charset_collate";
        dbDelta($sql);
    }
}

// Instantiate the class
$coursePlugin = new coursePlugin();

?>