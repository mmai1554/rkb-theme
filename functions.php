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


/**
 * Editor Zugriff auf Menü Optionen gewähren
 */
add_action( 'admin_init', function () {
	$role_object = get_role( 'editor' );
	if ( ! $role_object->has_cap( 'edit_theme_options' ) ) {
		$role_object->add_cap( 'edit_theme_options' );
	}
}, 1 );

if ( function_exists( 'acf_add_local_field_group' ) ) {

	acf_add_local_field_group( array(
		'key'                   => 'group_5d39ce66b4ddb',
		'title'                 => 'MNC Filegroups',
		'fields'                => array(
			array(
				'key'               => 'field_5d39ce89d63f4',
				'label'             => 'Dokumente',
				'name'              => 'mnc_filegroup',
				'type'              => 'repeater',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'collapsed'         => '',
				'min'               => 0,
				'max'               => 0,
				'layout'            => 'table',
				'button_label'      => '',
				'sub_fields'        => array(
					array(
						'key'               => 'field_5d39cecfd63f5',
						'label'             => 'Dokument',
						'name'              => 'mnc_file',
						'type'              => 'file',
						'instructions'      => 'Wählen Sie die Datei aus. Erlaubt sind zzt. PDF, Word-Dateien, Excel-Dateien',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'return_format'     => 'array',
						'library'           => 'all',
						'min_size'          => '',
						'max_size'          => '',
						'mime_types'        => 'pdf,doc,xls,zip',
					),
				),
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mnc_filegroups',
				),
			)
		),
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );

}