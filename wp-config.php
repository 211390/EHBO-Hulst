<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ehbo-hulst' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~I%w]Z>kO7PX1jH@O#JquCI!|G_4z9XX $#~j1gTnY6L7JrOY8@>!hSx]B4oe$=4' );
define( 'SECURE_AUTH_KEY',  '5cn >Q11l/n.BZDyjv,9boLp8e(cnw-B{f`8gsw`EzxcKINjOB93W)L[y<DJz az' );
define( 'LOGGED_IN_KEY',    'gX{j-@BDj9CXhNrL&-!orpj-4w1_=fNSR  `hdT=7yTbtGOo+c;DT=PkUzWnQ cC' );
define( 'NONCE_KEY',        'N#jXSGh(HI_Ip?^#@w5LmHQxH=ZO|sOG:onE*gYoF`n5!gm7K*wKgx_I&;w?Xm h' );
define( 'AUTH_SALT',        '-mje#JI_2`t>5S3lDnL5>C%F5I;}}LJht+1aXY1F<|O|df;ol[7s[Gj6|B$EE6KT' );
define( 'SECURE_AUTH_SALT', '}Wb&`Oa=!6[GQ$>He@lz V+ZwSCgX]:#;&+^xp0G5}7Gc`nU.gS{21#^H^RzSIR9' );
define( 'LOGGED_IN_SALT',   '(Zoc`XVR|ATl:MDF*fT[j{ZvH9335HQ:Y)4 taMb#POGKQcT2YHs_+VW$dPEk)9M' );
define( 'NONCE_SALT',       'Y14u,QdZu$^?3!:I8~S*Tvr_^_~-R;1C *TcPf!#S?|A`Q`i4{7Ah(V C?`@W4mS' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
