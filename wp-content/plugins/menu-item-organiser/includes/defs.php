<?php

/**
 * Definitions needed in the plugin
 *
 * @author Tirstan Oostdijk
 * @version 0.1
 *
 * Version history
 * 0.1 Initial version
 */
// De versie moet gelijk zijn met het versie nummer in de MenuProduct.php header
define('MENU_ITEM_ORGANISER_VERSION', '0.0.1');
// Minimum required Wordpress version for this plugin
define('MENU_ITEM_ORGANISER_REQUIRED_WP_VERSION', '4.0');
define('MENU_ITEM_ORGANISER_PLUGIN_BASENAME', plugin_basename(
                MENU_ITEM_ORGANISER_PLUGIN));
define('MENU_ITEM_ORGANISER_PLUGIN_NAME', trim(dirname(
                        MENU_ITEM_ORGANISER_PLUGIN_BASENAME), '/'));
// Folder structure
define('MENU_ITEM_ORGANISER_PLUGIN_DIR', untrailingslashit(dirname(
                        MENU_ITEM_ORGANISER_PLUGIN)));
define('MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_DIR', MENU_ITEM_ORGANISER_PLUGIN_DIR . '/includes');
define('MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_VIEWS_DIR', MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_DIR . '/views');
define('MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_MODEL_DIR', MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_DIR . '/model');
define('MENU_ITEM_ORGANISER_PLUGIN_MODEL_DIR', MENU_ITEM_ORGANISER_PLUGIN_INCLUDES_DIR . '/model');
define('MENU_ITEM_ORGANISER_PLUGIN_ADMIN_DIR', MENU_ITEM_ORGANISER_PLUGIN_DIR . '/admin');
define('MENU_ITEM_ORGANISER_PLUGIN_ADMIN_VIEWS_DIR', MENU_ITEM_ORGANISER_PLUGIN_ADMIN_DIR . '/views');
?>