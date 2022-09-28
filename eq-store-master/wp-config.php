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
define( 'DB_NAME', 'sql3424455' );

/** MySQL database username */
define( 'DB_USER', 'sql3424455' );

/** MySQL database password */
define( 'DB_PASSWORD', 'BXyTWLnALu' );

/** MySQL hostname */
define( 'DB_HOST', 'sql3.freesqldatabase.com' );

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
define( 'AUTH_KEY',         'JYrHkE,BAGz#g-P3&losSa@j>-HZ;?Bze}erd`w5>^+:XR<UB+EQ.I8gnq5fFf@H' );
define( 'SECURE_AUTH_KEY',  'Mo_wr=+H+xPXI|k(Hbz!Kjd<QZo/E$X6CDL=uD`k#k4]IL1tm]2us[KZvCS$cJID' );
define( 'LOGGED_IN_KEY',    '+Ud78=lnvF8SUGeo94c;c&AA|d[MiqIZw*vs9MzjV6Ml$?#ID*4mfd#>LI~pZMHo' );
define( 'NONCE_KEY',        'T-}g[t~cDm+h?=#k7wa].-Q$zhn j<~pfn4[*z?3Ri-S8vRD!}C#|Qn6gW)dita6' );
define( 'AUTH_SALT',        ',Wb0i68BIt>%3&QGk]ptPJ+y7!4@.9Rxtb0yykmY~5qBcEje1J&[!=TR#-Jp]sz:' );
define( 'SECURE_AUTH_SALT', 'Cu!wj-x~6s)X{yM5v31gz(K7@`^jQ3qWf|06CzT*p,QJ>YW!]!(%*K`0AhBdi=0%' );
define( 'LOGGED_IN_SALT',   't2[MtF%.;ZZ#>|-3sREXu#{l8j~PM<JRwsB5{]Ri#_FU+b8(0/6?TZ]2#hf{VF}s' );
define( 'NONCE_SALT',       'hG1TM>7rbhe0=U!*6ce?=:|69EH{#>gFH]*-H1_~1#DC{JPT,K-l17;<9&;;?8T,' );

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
