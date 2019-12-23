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
define( 'DB_NAME', 'online-university' );

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
define( 'AUTH_KEY',         'loRlBfe,w1qCVRD+EaR0t2qjJ [S>Gq3;8ph8F*U#g.R]-a^ #H3_6 CSZnU #==' );
define( 'SECURE_AUTH_KEY',  'l<}%;y%D;=E7#D,J*=G4@MG]]L{i-U91#5/]TM7g+lzxT4cEq|8_^kV+4opV;|#&' );
define( 'LOGGED_IN_KEY',    'Qvi*5Pr~Lr/FZBU:l!1fp-lCHNzW6/ZKvSEEEl}<S8flje^149HR2Ysd/|i|hLiJ' );
define( 'NONCE_KEY',        '5pU!NB`*m0E9k~]2B6]1ey(=oW 1-_L:f,]fL%/4_@Z]Hf5zFgNAg^,+,HA~v9|U' );
define( 'AUTH_SALT',        '=I4>RJ*Rd?GA}+>zufwR{]a@(-C>WkTxVkA_-i(T4n@7c]CG^N@Q5=yST5YaB/]b' );
define( 'SECURE_AUTH_SALT', '*42]^*C(6;][X&hf/x`u_<TESf,g<,4=8f s_hz!,MlYxwL)*$+C@bk%1=(}9u%/' );
define( 'LOGGED_IN_SALT',   'pgVD=ono}LDTY?/oRg6@8:Agf!M_h0@H_3&Gs2EMWj&Qq!63n:`@i4[]&P%SH=Bl' );
define( 'NONCE_SALT',       '0cL8Oeu1 ~{75-P1nzv29KCXxcDD]&=2ynR3(67}:U3<|>SiTXJmCIYO0DCw}4J+' );

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
