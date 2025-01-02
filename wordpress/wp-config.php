<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'demo_wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ')OltqM%ME1CBAWtQG^*U)#4Jb1r3f]jg1a)z /lWldROnDzV}zv)QAH%2+tc$`(X' );
define( 'SECURE_AUTH_KEY',  'qq9kE|T(&V3UrT_x{BT1QBdG{}kHGi Y?&d/%*U/TkBqC_i0JJ6&]zb-DWq#<-,`' );
define( 'LOGGED_IN_KEY',    'oo,Y?_~Riz}H9(hntPoY`T164}i#J+wLyyo:rRV,T|h;m-K+1P&$+l>@|/s}{5L3' );
define( 'NONCE_KEY',        'XfrCI66c?:>W&-+pQ~~X>8|Q(AX|F)]@H<khmg[(F(kK>A>[lp]O/Sw4QAG2yY!U' );
define( 'AUTH_SALT',        'U#8+URlICg-MKEN{7A)uq}]i/S.QO->S`i=O(cN~q!O{3l01a[HDrTG)W=0)N`Wj' );
define( 'SECURE_AUTH_SALT', 'Wiw hF[d:J CB!ehXf/#Bxdi!c-!Rn.to}N8,1C``v :ln+.R>EZ~nPi2Q~{ IbY' );
define( 'LOGGED_IN_SALT',   'Qh^*osm<]0>/JmKc.604,xewtY>94KPv8+YPHZU6,23O-E1EXD 8Jawu^W@n),vu' );
define( 'NONCE_SALT',       '{)Y|,j=[s}1oC9Z=27{zE.~%;XedfK!?S #1TqA^?>&j?o,iuA5/?.1vaob4H($_' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

