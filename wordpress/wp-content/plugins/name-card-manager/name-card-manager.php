<?php
/*
Plugin Name: Name Card Manager
Plugin URI: https://example.com
Description: Plugin quản lý name card cho WordPress.
Version: 1.0
Author: Your Name
Author URI: https://example.com
License: GPL2
*/

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Tạo Custom Post Type cho Name Card
function ncm_register_name_card_cpt() {
    $labels = array(
        'name' => __('Name Cards', 'name-card-manager'),
        'singular_name' => __('Name Card', 'name-card-manager'),
        'add_new' => __('Add New', 'name-card-manager'),
        'add_new_item' => __('Add New Name Card', 'name-card-manager'),
        'edit_item' => __('Edit Name Card', 'name-card-manager'),
        'new_item' => __('New Name Card', 'name-card-manager'),
        'all_items' => __('All Name Cards', 'name-card-manager'),
        'view_item' => __('View Name Card', 'name-card-manager'),
        'search_items' => __('Search Name Cards', 'name-card-manager'),
        'not_found' => __('No Name Cards Found', 'name-card-manager'),
        'not_found_in_trash' => __('No Name Cards Found in Trash', 'name-card-manager'),
        'menu_name' => __('Name Cards', 'name-card-manager'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-id', // Icon cho menu
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true, // Hỗ trợ Gutenberg
    );

    register_post_type('name_card', $args);
}
add_action('init', 'ncm_register_name_card_cpt');
