<?php
// Đăng ký menu
function name_card_theme_setup() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'name-card-theme' ),
    ) );

    // Hỗ trợ hình ảnh đại diện
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'name_card_theme_setup' );


//Đăng ký và tải file CSS/JS
function name_card_theme_enqueue() {
    wp_enqueue_style( 'name-card-theme-style', get_template_directory_uri() . '/assets/css/style.css' );
    wp_enqueue_script( 'name-card-theme-js', get_template_directory_uri() . '/assets/js/main.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'name_card_theme_enqueue' );
