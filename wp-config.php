<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wks_wooddesign' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'S*:;CKwf3#Z;23DC2kP&<:{K71?!jZ~30s>I4ihj)S[!EJ`4*Fn<pMx042rWWEEe' );
define( 'SECURE_AUTH_KEY',  'lL%>({@Ym5E)u-z I={fO1?Ls-!*N}1P ;|IYxX[OlP!<Y}@~8P~4&v1T=}F>5ah' );
define( 'LOGGED_IN_KEY',    'ihs-C4f7kQR LX#T4XZ}FkeUMbZH.EOoq2+bKc|I2+F!)N5HYO+3UOkWt!Ulg[R|' );
define( 'NONCE_KEY',        'oRDe,G gU Rj]@}vA@@&p!6iuSJlxM,|R!bz6$C-w?[R/f>$=`&md<~3aLXiE2Wy' );
define( 'AUTH_SALT',        'Oqlet?eI,*k@(;4+Bl:h.4oJs:rK2nTkc>B28rz,Te.dXcJ7SK&T/?liT(48X49I' );
define( 'SECURE_AUTH_SALT', 'jWxQA=$#QoG6NNLw*dv!?J<rxBOD461U((hP&w@]EEDe_s#O0{+sbW&xh9f%=DXv' );
define( 'LOGGED_IN_SALT',   'l37kYE=SBorkKc.-4Gq~lo]WcEPI LVf#!<oKuBt>O6]Zl=pN|+UMHt-#|>lHJsX' );
define( 'NONCE_SALT',       'c`SSF:+`;LMt#CSo^B6{}FGoXd440*8}dck%kKr)qu4y!<nU(zHq: {6J&B_j+3:' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
