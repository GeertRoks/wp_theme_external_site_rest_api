<?php

function extsite_restapi_theme_support() {
}
add_action('after_setup_theme', 'extsite_restapi_theme_support');

function extsite_restapi_register_styles() {
    $version = wp_get_theme()->get('Version');
    //wp_enqueue_style( 'stijncappetijn-style', get_stylesheet_uri() );
    wp_enqueue_style('stijncap-style', get_template_directory_uri() . "/style.css", array(), $version, 'all');
}
add_action('wp_enqueue_scripts', 'extsite_restapi_register_styles');

add_action('rest_api_init', 'register_rest_images');
function register_rest_images() {
    register_rest_field(array('post'), 'featured_media_url', array(
        'get_callback' => 'get_rest_featured_image',
        'update_callback' => null,
        'schema' => null,
    ));
}

function get_rest_featured_image($object, $field_name, $request) {
    if ($object['featured_media']) {
        $img = wp_get_attachment_image_src($object['featured_media'], 'app-thumb');
        return $img[0];
    }
    return false;
}

function extsite_restapi_customize_register( $wp_customize ) {
    // Register a new section.
    $wp_customize->add_section( 'frontend_url_section', array(
        'title'      => 'Frontend URL',
        'priority'   => 30,
    ) );

    // Register a new setting for the URL.
    $wp_customize->add_setting( 'frontend_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    // Add a text input control for the URL.
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'frontend_url', array(
        'label'      => 'Enter the URL to the frontend',
        'section'    => 'frontend_url_section',
        'settings'   => 'frontend_url',
        'type'       => 'text',
    ) ) );
}
add_action( 'customize_register', 'extsite_restapi_customize_register' );

?>
