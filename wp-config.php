<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
 
 define('WP_DEBUG', true);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_szkolenie');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 't3l3c@st3r');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-YTcf-a1X+c.pr6}03Lv!V}en&oYfjN8Tn}PJ@P@<Xb+Jj2I)pO)8K=8|~kzrK-B');
define('SECURE_AUTH_KEY',  'Z(#$_Ir3AO+lc+%VQ!71fPH>J a@izP{Ho{=u-3/c/6G+]~|>&qbD)9<M^dRCxKz');
define('LOGGED_IN_KEY',    '>/.G+@8AYi@_A0QCo-eN*1|+08RE|~e@.9+-uIr>>NiD@9X# UX>_p|U/+PQZw-C');
define('NONCE_KEY',        '!Ok9_<4en0-HgJ|8-!yO^]<?-%C?aDqSUqPwQEsy8N0}q|rq2a#eH4{jlo,xJMuC');
define('AUTH_SALT',        'mLL1R)m~-q*^ze1p+2-+)w4*_))d}|D7,JY2E{ngXoJ+0CZ9G#?`!+DK vZ8kLwW');
define('SECURE_AUTH_SALT', 'LwlAk_R|;QB*%S]wo]=v4[2o5{lLVS >T|o)u,-Rv4[o^)z_-/!m;s^G#T,.qh:7');
define('LOGGED_IN_SALT',   '&*;=tn#PiiVrYx0TJI^risR<?|oynC&WFm5h,,(Bd5m*sO.#^IK7KLpLzF0+cuLl');
define('NONCE_SALT',       '[V.|vi19W#JWuCFB7DHzH!UB-#BPF7sz<Dwymti|P~!WGMd;eg&Mb*Ai{+6|I^xp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
