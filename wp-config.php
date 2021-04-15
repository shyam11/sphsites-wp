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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'newdb' );

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
define( 'AUTH_KEY',         'Qu.09xnOXS+k8^8G8o4>X!xH!%C8U3tSwVmHg,a^<;nTbQ/4GKJTV08>@@He 8Gi' );
define( 'SECURE_AUTH_KEY',  'd[GD5-=htXlp&eVEK&e]5Q>0Q5dGL4T{F[mNMhSXxz% @L4?RrzWh<;csS?|h//[' );
define( 'LOGGED_IN_KEY',    'DohA$=PtOEK~wjUu!.1.q^g:<AT;t+tzRBGDI$S|Q~O9~iHqW(h`3MR=Q@Y!$pvH' );
define( 'NONCE_KEY',        'c#Y&|P?%<DA/6@|0+Q81Af(*tavy+&|[$_VvcCmU){rPBRceLRiZPs6%4BSz[:B0' );
define( 'AUTH_SALT',        '$#QWd,?lR_hS%Pz&PHzaT!u;eLKV3L,S8=}K*sH.$I6Kpa8M71iCXmirW.IklVbx' );
define( 'SECURE_AUTH_SALT', 'dzS.v?yY7Dqbov cT$ODQ=)!=|4fBO&FX`~>d#$eH&v^lq*Bg@e.7sn(I;(cD%6y' );
define( 'LOGGED_IN_SALT',   '(]3dW//}^2_L1UI>,@$d<w YX*$e2%N%+kz3`ruxGjS8,np,r1H4IV74}% b>B+j' );
define( 'NONCE_SALT',       'VnPN6B6_r%&{]USaf2SV/OhP9-pVA)mR)W,JSq&(6TYIB+=7HliWbx-FOco6NL&}' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
