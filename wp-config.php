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
define( 'AUTH_KEY',         '*)e3 hn6AU~Zs,&>Uax%,#CKBE;3EiH3zRaAK(#H7Rq7qdbdqnz6}G}vDp>:jEor' );
define( 'SECURE_AUTH_KEY',  'sne:UV[drd4Y4NWo- 6%|~Lq3]s}^5!M?j>czQHihHNVzlovnCElwvZp+/]d; Hm' );
define( 'LOGGED_IN_KEY',    'f`ncv1f%)n(3P5#>i:BMB2-dd~w|G|~M(UmHSv_pDGC<1i26Ql|_FBjEwC&UzCyC' );
define( 'NONCE_KEY',        'XA8K8wQT +iVbvu`jHz9a%GWRCgl>oUaL7l.$!Gig__PPO%pGOB3#_Szs{=LVg;,' );
define( 'AUTH_SALT',        'ebp[TOY%Ynk00TKX.2v w)@N;g-yP.,re9PKNdzq*#Yf83xdCx#Umo4R8Aak_7aq' );
define( 'SECURE_AUTH_SALT', 'Rij3gMQgFz|$`5[lMPcXxN[&4b[nr=KHQ#a):$KY%k#pGe@NcE)f82c??%w*>[UF' );
define( 'LOGGED_IN_SALT',   '}D+|Hxg>8=i&3igH_h,4DK8mh9q40vu,@H`H {^~V$k`M@RhU_MBV0c$vNKs3F-@' );
define( 'NONCE_SALT',       '8[96I%3*t*?%hJ[50=QG94QF6b[L;<[*L1]@bp&By5K?!<MLZ1<QXQy-:J*jM9C~' );

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
