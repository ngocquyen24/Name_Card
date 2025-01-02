<?php
require_once get_template_directory() . '/core/setup.php';   // Thiết lập cấu hình
require_once get_template_directory() . '/core/enqueue.php'; // Đăng ký và tải các file CSS/JS

function enqueue_theme_assets() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');

    // Custom CSS
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0', 'all');

    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);

    // Custom JS
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array(), time(), true);

}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');

remove_filter('the_content', 'prepend_attachment');

// URLs tùy chỉnh
home_url('/view-user.php?id=' . $id);
home_url('/detail-name-card.php?id=' . $id);


function enqueue_screenshot_scripts() {
    // Tải thư viện html2canvas
    wp_enqueue_script(
        'html2canvas',
        'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js',
        [],
        null,
        true
    );

    // Tải file custom JS
    wp_enqueue_script(
        'screenshot-script',
        get_template_directory_uri() . '/assets/js/screenshot.js',
        ['html2canvas'], // Phụ thuộc html2canvas
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_screenshot_scripts');


function enqueue_custom_scripts() {
    wp_enqueue_script(
        'main-js', // Tên handle
        get_template_directory_uri() . '/assets/js/main.js', // Đường dẫn chính xác
        [], // Phụ thuộc (nếu có)
        null, // Phiên bản
        true // Tải ở footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function vcard_template_redirect() {
    if (get_query_var('download_vcard')) {
        download_vcard();
        exit;
    }
}
add_action('template_redirect', 'vcard_template_redirect');
