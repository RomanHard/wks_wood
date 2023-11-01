<?php
/**
 * decofurniture functions and definitions
 *
 * @version 1.0
 *
 * @date 12.08.2015
 */
load_theme_textdomain( 'decofurniture', get_template_directory() . '/languages' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

require_once( trailingslashit( get_template_directory() ). '/th-lib/function.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/config.php' );

// LOAD CLASS LIB

require_once( trailingslashit( get_template_directory() ). '/th-lib/class/asset.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/class/class-tgm-plugin-activation.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/class/importer.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/class/mega-menu.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/class/order-comment-field.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/class/require-plugin.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/class/template.php' );

// END LOAD

// LOAD CONTROLER LIB

require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Base-Control.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Customize-Control.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Walker-Megamenu.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Woocommerce-Control.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Woocommerce-Variable.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Multi-Language-Control.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Header-Control.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Footer-Control.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/MegaItem-Control.php' );
if(class_exists('Redux')) require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Redux-Config.php' );
require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Metabox-Control.php' );
if(class_exists('Elementor\Core\Admin\Admin')) require_once( trailingslashit( get_template_directory() ). '/th-lib/controler/Elementor-Control.php' );
// END LOAD

if(function_exists('th_load_lib')){
	th_load_lib('widget');
}