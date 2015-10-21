<?php
/**
 * Configuración básica de WordPress.
 *
 * Este fichero contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, y ABSPATH. Para obtener más información visite la página del Codex
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editando wp-config.php}.
 * Los ajustes de MySQL se los proporcionará su proveedor de alojamiento web.
 * 
 * Este fichero es usado por el script de creación de wp-config.php durante la
 * instalación. Usted no tiene que utilizarlo en su sitio web, simplemente puede guardar este fichero
 * como "wp-config.php" y completar los valores.  
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solcite esta información a su proveedor de alojamiento web. ** //
/** El nombre de la base de datos de WordPress */
define('DB_NAME', 'hotelaura2');

/** Nombre de usuario de la base de datos de MySQL */
define('DB_USER', 'root');

/** Contraseña del usuario de la base de datos de MySQL */
define('DB_PASSWORD', 'root');

/** Nombre del servidor de MySQL (generalmente es localhost) */
define('DB_HOST', '192.168.1.39');

/** Codificación de caracteres para usar en la creación de las tablas de la base de datos. */
define('DB_CHARSET', 'utf8');

/** El tipo de cotejamiento de la base de datos. Si tiene dudas, no lo modifique. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autenticación y salts.
 *
 * ¡Defina cada clave secreta con una frase aleatoria distinta!
 * Usted puede generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress.org}
 * Usted puede cambiar estos valores en cualquier momento para invalidar todas las cookies existentes. Esto obligará a todos los usuarios a iniciar sesión nuevamente. 
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'm4k!U?.B W6fU]y9>HZWkGF??hQ>N,&Puz(_ETewW8^Kq$X[5T:GP|N%|k!+>%Uz');
define('SECURE_AUTH_KEY',  'O3Cb9>rNGqC)}fQ[h|=K9f8Y{(_<i>g#*$1KeW,6;mrxZh4) gD<#tqa#b aYb<B');
define('LOGGED_IN_KEY',    '(i-g@v 6H#lIUD{Hv6L<=z_Wc%/Uy<XqVWqBunA 4#JuxS%{-siwhuS +u?:vAF*');
define('NONCE_KEY',        'k.ZSvB^J%5P&kx)QmQ^9f+M-?3@50 Q4}zTYWMC[-@7fzZ}&IB7wrgHlfWjbqZol');
define('AUTH_SALT',        '~G+-`;;o0-3mpj{)^.HKsMc=rdUd|9=GY7P~-B`8:N}~`#gV@hz|11-l{Z68!/mk');
define('SECURE_AUTH_SALT', 'w 8_9V4Emd]5invf<V%J`*$|4)Bd0fr?Xv;nP<[;y-m10y.?N23*zilhom>9e|Q$');
define('LOGGED_IN_SALT',   '-[UR$6xpuhXcz^7C^.Ld#f0*Xm3{a.F?-{s2[Bu#j1T&:K%qu>N^+[qk>: Zax^X');
define('NONCE_SALT',       'i9#^s1?$JU-A(G7nM<${Rx+MbBjw_XPGG)Hpp&Fz`s?[e%N-m(>8%|)i4A&,A?ev');

/**#@-*/

/**
 * Prefijo de las tablas de la base de datos de WordPress. 
 *
 * Usted puede tener múltiples instalaciones en una sóla base de datos si a cada una le 
 * da un único prefijo. ¡Por favor, emplee sólo números, letras y guiones bajos!
 */
$table_prefix  = 'ha_';

/**
 * Para los desarrolladores: modo de depuración de WordPress.
 *
 * Cambie esto a true para habilitar la visualización de noticias durante el desarrollo.
 * Se recomienda encarecidamente que los desarrolladores de plugins y temas utilicen WP_DEBUG 
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deje de editar! Disfrute de su sitio. */

/** Ruta absoluta al directorio de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Establece las vars de WordPress y los ficheros incluidos. */
require_once(ABSPATH . 'wp-settings.php');
