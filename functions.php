<?php
/**
 * Residenz Kubitzer Bodden Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Residenz Kubitzer Bodden
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_RKB_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'rkb-theme-css', get_stylesheet_directory_uri() . '/style.css', array( 'astra-theme-css' ), CHILD_THEME_RKB_VERSION, 'all' );

}

// <link rel="stylesheet" href="https://use.typekit.net/xpg1upf.css">

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


add_shortcode( 'mi_tel', function () {
	// $icon = '<span class="fl-icon"><i class="fi-telephone" aria-hidden="true"></i></span>';
	return '<a class="phone" href="tel:+49XXXXXX">XXXXXX</a>';
} );
add_shortcode( 'mi_email', function () {
	return '<a class="mail" href="mailto:info@residenz-kubitzer-bodden.de">info@residenz-kubitzer-bodden.de</a>';
} );


/**
 * Wir brauchen Beiträge und Kommentare in dieser Version nicht
 */
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
} );

/**
 * Dont show astra pro settings in Termine and ARO Projekte:
 */
function mnc_hide_astra_box() {
	global $post;
	$cpt = [
		'termin',
		'mnc_filegroups'
	];
	if ( in_array( $post->post_type, $cpt ) ) {
		echo '
                <style type="text/css">
                    #astra_settings_meta_box, #gos_simple_redirect {
                        display:none;
                    }
                </style>
            ';
	}
}

add_action( 'admin_head-post.php', 'mnc_hide_astra_box' );
add_action( 'admin_head-post-new.php', 'mnc_hide_astra_box' );