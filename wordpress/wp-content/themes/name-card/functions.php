<?php
require_once get_template_directory() . '/core/setup.php';   // Thiết lập cấu hình
require_once get_template_directory() . '/core/enqueue.php'; // Đăng ký và tải các file CSS/JS

function enqueue_theme_assets()
{
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



function enqueue_screenshot_scripts()
{
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


function enqueue_custom_scripts()
{
    wp_enqueue_script(
        'main-js', // Tên handle
        get_template_directory_uri() . '/assets/js/main.js', // Đường dẫn chính xác
        [], // Phụ thuộc (nếu có)
        null, // Phiên bản
        true // Tải ở footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');







add_action('init', 'fake_page_rewrite');

function fake_page_rewrite()
{
    global $wp_rewrite;

    // Set up our query variable %fake_page% which equates to index.php?fake_page=
    add_rewrite_tag('%fake_page%', '([^&]+)');
    add_rewrite_tag('%username%', '([^/]+)');

    // Add rewrite rule that matches /members/2, /members/2/
    add_rewrite_rule('^members/([^/]+)/?$', 'index.php?fake_page=members&username=$matches[1]', 'top');

    // Flush rules to get this to work properly
    $wp_rewrite->flush_rules();
}



add_action('template_redirect', 'fake_page_redirect');

function fake_page_redirect()
{
    global $wp;

    // Lấy giá trị 'username' từ query vars
    $template = $wp->query_vars;

    if (array_key_exists('fake_page', $template) && 'members' === $template['fake_page'] && isset($template['username'])) {
        $username = sanitize_text_field($template['username']);

        // Truy vấn dữ liệu từ database
        global $wpdb;
        $table_name = $wpdb->prefix . 'user_cards';

        // Kiểm tra nếu là ID (số nguyên) hoặc email
        if (is_numeric($username)) {
            // Truy vấn bằng ID
            $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($username)));
        } else {
            // Truy vấn bằng email
            $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email like '". $username ."@%' or email = '" . $username . "'"));
        }

        if (!$user) {
            // Người dùng không tồn tại
            wp_die('Không tìm thấy người dùng!', '404');
        }

        // Gắn dữ liệu vào biến global
        $GLOBALS['custom_user'] = $user;

        // Gọi template dựa trên trường hợp
        if (is_numeric($username)) {
            // Trường hợp ID
            $template_path = get_template_directory() . '/templates/detail-name-card.php';
        } else {
            // Trường hợp Email
            $template_path = get_template_directory() . '/templates/view-user-name.php';
        }

        if (file_exists($template_path)) {
            include $template_path;
        } else {
            wp_die('Không tìm thấy file template!', '500');
        }

        exit;
    }
}




function custom_query_vars_for_members($vars)
{
    $vars[] = 'id';  // Đảm bảo có biến 'id' trong URL
    return $vars;
}
add_filter('query_vars', 'custom_query_vars_for_members');
