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


function create_or_update_page_template($post_id) {
    if (get_post_type($post_id) != 'page' || get_post_status($post_id) != 'publish') {
        error_log("Skipping: Not a page or not published for Page ID {$post_id}");
        return;
    }


    // Lấy tên của page và slug
    $page_title = get_the_title($post_id);
    $slug = sanitize_title($page_title); // Tạo slug từ tên của page

    // Lấy nội dung của page
    $page_content = get_post_field('post_content', $post_id);

    // Đường dẫn tới thư mục theme
    $theme_directory = get_template_directory();

    // Đường dẫn file PHP sẽ được tạo hoặc cập nhật
    $file_path = $theme_directory . '/templates/partials/' . $slug . '.php';

    // Nội dung của file template là nội dung trang
    $template_content = $page_content;

    // Tạo hoặc cập nhật file PHP với nội dung mới nhất
    file_put_contents($file_path, $template_content);

    // Lấy template hiện tại được gắn với trang
    $current_template = get_post_meta($post_id, '_wp_page_template', true);

    // Đường dẫn template mới
    $new_template = 'templates/' . $slug . '.php';

    // Chỉ gán template mới nếu nó chưa được gán
    if (empty($current_template) || $current_template === 'default') {
        update_post_meta($post_id, '_wp_page_template', $new_template);
    }
    
}

// Hook vào 'save_post' để tạo hoặc cập nhật file khi trang được lưu
add_action('save_post', 'create_or_update_page_template');


function delete_page_template_on_trash($post_id) {
    // Lấy tên của page và slug
    $page_title = get_the_title($post_id);
    $slug = sanitize_title($page_title); // Tạo slug từ tên của page

    // Đường dẫn tới thư mục theme
    $theme_directory = get_template_directory();

    // Đường dẫn file PHP tương ứng
    $file_path = $theme_directory . '/templates/partials/' . $slug . '.php';

    // Xóa file nếu tồn tại
    if (file_exists($file_path)) {
        unlink($file_path);
    } 
}

// Hook vào 'before_delete_post' để xóa file khi trang bị xóa hoặc đưa vào thùng rác
add_action('before_delete_post', 'delete_page_template_on_trash');


// Hàm tạo trang từ file PHP
function create_page_from_php_template($file_path) {
    // Lấy tên file từ đường dẫn và tạo slug từ tên file (bỏ .php)
    $slug = basename($file_path, '.php');

    // Đọc nội dung của file PHP
    $template_content = file_get_contents($file_path);

    // Kiểm tra nếu file không tồn tại
    if ($template_content === false) {
        return;
    }

    // Tạo một page mới trong WordPress
    $post_data = array(
        'post_title'    => ucfirst($slug),  // Tiêu đề trang là tên file (a -> A)
        'post_content'  => $template_content,  // Nội dung trang là nội dung file
        'post_status'   => 'publish',  // Đăng trang ngay lập tức
        'post_type'     => 'page',  // Kiểu post là page
        'post_name'     => $slug,  // Slug của page
    );

    // Insert post vào cơ sở dữ liệu
    $post_id = wp_insert_post($post_data);

    // Kiểm tra nếu page được tạo thành công
    if (!is_wp_error($post_id)) {
        // Gán template cho page nếu cần (ví dụ nếu bạn có template tùy chỉnh)
        $new_template = 'templates/partials/' . $slug . '.php';
        update_post_meta($post_id, '_wp_page_template', $new_template);
    }
}

// Hook vào 'save_post' để kiểm tra sự thay đổi trong thư mục khi có file mới
function check_new_php_template($file_path) {
    // Kiểm tra nếu file PHP mới được tạo ra trong thư mục templates/partials
    if (file_exists($file_path) && pathinfo($file_path, PATHINFO_EXTENSION) === 'php') {
        create_page_from_php_template($file_path);
    }
}

// Giám sát sự thay đổi trong thư mục templates/partials của theme
function monitor_template_changes() {
    $theme_directory = get_template_directory(); // Đường dẫn đến thư mục theme
    $template_directory = $theme_directory . '/templates/partials/';  // Đường dẫn đến thư mục templates/partials

    // Kiểm tra nếu có file PHP mới trong thư mục
    if ($handle = opendir($template_directory)) {
        while (false !== ($entry = readdir($handle))) {
            $file_path = $template_directory . $entry;
            if (is_file($file_path)) {
                check_new_php_template($file_path);
            }
        }
        closedir($handle);
    }
}

// Thực thi khi theme được kích hoạt
add_action('after_switch_theme', 'monitor_template_changes');

