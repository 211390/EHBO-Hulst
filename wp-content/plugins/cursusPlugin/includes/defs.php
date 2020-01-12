<?php
/**
  * Definitions needed in the plugin
  *
  * @author Thijs van der Poel
  * @version 0.1
  *
  * Version history
  * 0.1 Initial version
  */

// De versie moet gelijk zijn met het versie nummer in de my-event-organiser.php header
define( 'COURSE_PLUGIN_VERSION', '0.0.1' );

// Minimum required WordPress version for this plugin
define('COURSE_PLUGIN_REQUIRED_WP_VERSION', '4.0');

define('COURSE_PLUGIN_BASENAME', plugin_basename(COURSE_PLUGIN));

define('COURSE_PLUGIN_NAME', trim(dirname(COURSE_PLUGIN_BASENAME), '/' ));

// Folder structure
define('COURSE_PLUGIN_DIR', untrailingslashit(dirname(COURSE_PLUGIN)));

define('COURSE_PLUGIN_INCLUDES_DIR', COURSE_PLUGIN_DIR . '/includes');

define('COURSE_PLUGIN_MODEL_DIR', COURSE_PLUGIN_INCLUDES_DIR . '/model');

define('COURSE_PLUGIN_ADMIN_DIR', COURSE_PLUGIN_DIR . '/admin');

define('COURSE_PLUGIN_ADMIN_VIEWS_DIR', COURSE_PLUGIN_ADMIN_DIR . '/views');

define('COURSE_PLUGIN_INCLUDES_VIEWS_DIR',	COURSE_PLUGIN_INCLUDES_DIR	.	'/views');

define('COURSE_PLUGIN_INCLUDES_IMGS_DIR', COURSE_PLUGIN_INCLUDES_DIR . '/images');

?>
