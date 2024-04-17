<?php

function stijncappetijn_theme_support() {
}
add_action('after_setup_theme', 'stijncappetijn_theme_support');

function stijncappetijn_register_styles() {
    $version = wp_get_theme()->get('Version');
    //wp_enqueue_style( 'stijncappetijn-style', get_stylesheet_uri() );
    wp_enqueue_style('stijncap-style', get_template_directory_uri() . "/style.css", array(), $version, 'all');
}
add_action('wp_enqueue_scripts', 'stijncappetijn_register_styles');

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


?>
