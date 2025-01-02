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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'G1#P%>;0X 9*XK-M.4/CE@yu}/&E}-1n[}oUfy4Qr!Tyx}FE~}u^]*z3^/^Yl+3Y' );
define( 'SECURE_AUTH_KEY',  '_1hj^Jo-|vfP8VZF|uvce9j!4&uVs>6$>aE2{%kuDa_WDs[Lf$n*mz~YpdK;Z*rA' );
define( 'LOGGED_IN_KEY',    'U3WxdO&H{lnr1c.q7np}%HSE0|-)A{++M+N]IHxw~sRpi~Zel(67d0_Exm8~z3A.' );
define( 'NONCE_KEY',        'rU<dY5NjGQ^8h:~_$?X3n%Y&#Os~ig;;4joJRXWz%k>2T}oT4wExKwuLLo,&c? #' );
define( 'AUTH_SALT',        'JO+KT=.*=:]i6RxG3e5ewb_tz>..pz?8E<E[?3|>)Y)RlC.J~oaorKSgLNd9eCe/' );
define( 'SECURE_AUTH_SALT', ' [.j1@cx&$s^y4_Px~33a}|s%`#pS)7i~M*-#c%L-lSQxMsR23n wOAyKIvtScwO' );
define( 'LOGGED_IN_SALT',   'GpM[V]GUXw#NyZ`xU&F><u&Vl+utJk,F1L37KHeW2KbcVeC>,,+:[%>nO&PFBqPx' );
define( 'NONCE_SALT',       '4NN?1t!F/I.@Icqr5qi9zF0%5F@b%`F}Q:%}m M/:b*Cf-/Ihq`9;U)y1z*(,nfr' );

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



