<?php

defined('ABSPATH') OR exit;
/**
 * Plugin Name: Menu product plugin
 * Plugin URI: https://tirstan-oostdijk.nl
 * beschrijving: This plugin will help organising an event with your website
 * Author: &#x1F480; Tirstan Oostdijk &#x1F480;
 * Author URI: https://tirstan-oostdijk.nl
 * Version: 1.0.0
 * Text Domain: Menu-product-organiser
 * Domain Path: languages
 *
 * This is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with your plugin. If not, see <http://www.gnu.org/licenses/>.
 */
// Define the plugin name:
define('MENU_ITEM_ORGANISER_PLUGIN', __FILE__);

// Include the general definition file:
require_once plugin_dir_path(__FILE__) . 'includes/defs.php';
/* Register the hooks */
register_activation_hook(__FILE__, array('MenuProductOrganiser', 'on_activation'));
register_deactivation_hook(__FILE__, array('MenuProductOrganiser', 'on_deactivation'));

class MenuProductOrganiser
{

    public function __construct()
    {
// Fire a hook before the class is setup.
        do_action('MENU_ITEM_ORGANISER_pre_init');
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
        MenuProductOrganiser::createDb();
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
        do_action('MENU_ITEM_ORGANISER_init');
// Load admin only components.
        if (is_admin()) {

// Load all admin specific includes
            $this->requireAdmin();
// Setup admin page
            $this->createAdmin();
        } else {

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
        require_once MENU_ITEM_ORGANISER_PLUGIN_ADMIN_DIR .
            '/MenuProduct_AdminController.php';
    }

    /**
     * Admin controller functionality
     */
    public function createAdmin()
    {
        MenuProductAdminController::prepare();
    }

    /**
     * Load the view shortcodes:
     */
    public function loadViews()
    {

        include MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
    }

    /*
     * Define the array with plugin specific capabilities per role.
     *
     */

    public static function get_plugin_roles_and_caps()
    {

        // Define the desired roles for this plugin:
        return array(
            /* Is always available - Should be on firsth line */
            array('administrator',
                'Admin',
                array('MENU_ITEM_ORGANISER_read',
                    'MENU_ITEM_ORGANISER_create',
                    'MENU_ITEM_ORGANISER_update',
                    'MENU_ITEM_ORGANISER_delete',
                    'MENU_CATEGORY_ORGANISER_read',
                    'MENU_CATEGORY_ORGANISER_create',
                    'MENU_CATEGORY_ORGANISER_update',
                    'MENU_CATEGORY_ORGANISER_delete')),
            array('ivs_manager',
                'IVS_Manager',
                array('MENU_ITEM_ORGANISER_read',
                    'MENU_ITEM_ORGANISER_create',
                    'MENU_ITEM_ORGANISER_update',
                    'MENU_ITEM_ORGANISER_delete',
                    'MENU_CATEGORY_ORGANISER_read',
                    'MENU_CATEGORY_ORGANISER_create',
                    'MENU_CATEGORY_ORGANISER_update',
                    'MENU_CATEGORY_ORGANISER_delete')),
            array('project_lid',
                'Project lid',
                array('MENU_ITEM_ORGANISER_read'),
                array('MENU_CATEGORY_ORGANISER_read'))
        );
    }

    /**
     * Add plugin specific capabilities
     * Check firsth for the specific roles
     * If they not exists add specific roles
     * Add plugin specific caps per role
     *
     */
    public static function add_plugin_caps()
    {

        // Include the roles and capabilities definition file:
        require_once plugin_dir_path(__FILE__) .
            'includes/roles_and_caps_defs.php';

        $role_array = MenuProductOrganiser::get_plugin_roles_and_caps();

        // Check for the roles:
        foreach ($role_array as $key => $role_name) {
            // Check specific role
            if (!($GLOBALS['wp_roles']->is_role(
                $role_name[MENU_ITEM_ROLE_NAME]))
            ) {

// Create role
                $role = add_role($role_name[MENU_ITEM_ROLE_NAME], $role_name[MENU_ITEM_ROLE_ALIAS], array('read' => true, 'level_0' => true));
            }
            // else : role exists
        }

        // Add the capabilities per role
        foreach ($role_array as $key => $role_name) {
            // Create the caps for this role
            foreach ($role_name[MENU_ITEM_ROLE_CAP_ARRAY] as $cap_key => $cap_name) {
                // gets the author role
                $role = get_role($role_name[MENU_ITEM_ROLE_NAME]);
                // This only works, because it accesses the class instance.
// would allow the author to edit others' posts for currenttheme only
                $role->add_cap($cap_name);
            }
        }
    }

    /**
     *
     * Remove all the specific capabilities for this plugin.
     *
     *
     *
     */
    public static function remove_plugin_caps()
    {

        // Include the roles and capabilities definition file:
        require_once plugin_dir_path(__FILE__) .
            'includes/roles_and_caps_defs.php';

        // Get the plugin specific capabilities per role
        $role_array = MenuProductOrganiser::get_plugin_roles_and_caps();

        // Add the capabilities per role
        foreach ($role_array as $key => $role_name) {
            // Create the caps for this role
            foreach ($role_name[MENU_ITEM_ROLE_CAP_ARRAY] as $cap_key => $cap_name) {
                // gets the specific role
                $role = get_role($role_name[MENU_ITEM_ROLE_NAME]);
                // This only works, because it accesses the class instance.
// would allow the author to edit others' posts for current theme only
                $role->remove_cap($cap_name);
            }
        }
    }

    public static function createDb()
    {

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        //Calling $wpdb;
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        //Names of the tables that will be added to the db
        $MenuProductType  = $wpdb->prefix . "menu_product";
        $MenuCategorieType  = $wpdb->prefix . "menu_categories";

        //Create the categorie table
        $sql = "CREATE TABLE IF NOT EXISTS $MenuCategorieType (
        id INT(11) NOT NULL AUTO_INCREMENT,
        naam VARCHAR(64) NOT NULL,
        beschrijving VARCHAR(1024) NOT NULL,
        ranking INT(11) NOT NULL,
        PRIMARY KEY  (id))
        ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

        //Create the product table
        $sql = "CREATE TABLE IF NOT EXISTS $MenuProductType (
        id_menu_product INT NOT NULL AUTO_INCREMENT,
        naam VARCHAR(32) NOT NULL,
        beschrijving VARCHAR(1024) NOT NULL,
        prijs FLOAT NULL,
        categoryID INT(11) NOT NULL,
        PRIMARY KEY  (id_menu_product))
        ENGINE = InnoDB $charset_collate";
        dbDelta($sql);

    }
}
// Instantiate the class
$event_organiser = new MenuProductOrganiser();
?>