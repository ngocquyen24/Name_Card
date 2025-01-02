<?php
require_once get_template_directory() . '/core/setup.php';   // Thiết lập cấu hình
require_once get_template_directory() . '/core/enqueue.php'; // Đăng ký và tải các file CSS/JS

function enqueue_custom_scripts_in_head() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
    
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts_in_head');

function enqueue_view_user_styles() {
    // Đường dẫn đến file style.css trong thư mục assets/css
    wp_enqueue_style( 'view-user-style', get_template_directory_uri() . '/assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_view_user_styles' );

function enqueue_theme_styles() {
    // Đường dẫn chính xác tới file CSS
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

remove_filter( 'the_content', 'prepend_attachment' );

home_url('/view-user.php?id=' . $id);
home_url('/detail-name-card.php?id=' . $id);





function create_or_update_page_template($post_id) {
    error_log("create_or_update_page_template called for Page ID {$post_id}");

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

    // Gán template cho page
    update_post_meta($post_id, '_wp_page_template', '/templates/partials/' . $slug . '.php');
}


// Hook vào 'save_post' để tạo hoặc cập nhật file khi trang được lưu
add_action('save_post', 'create_or_update_page_template');


function delete_page_template_on_trash($post_id) {
    // Kiểm tra xem post có phải là page
    if (get_post_type($post_id) != 'page') {
        return;
    }
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

// Hook vào 'wp_trash_post' để xóa file khi trang bị đưa vào thùng rác
add_action('wp_trash_post', 'delete_page_template_on_trash');


function restore_page_template_on_restore($post_id) {
    error_log("restore_page_template_on_restore called for Page ID {$post_id}");

    // Kiểm tra post type và trạng thái
    if (get_post_type($post_id) != 'page') {
        error_log("Not a page: Skipping for Page ID {$post_id}");
        return;
    }

    // Tạo lại file template
    create_or_update_page_template($post_id);
}

// Hook vào 'transition_post_status' để khôi phục file khi trang được restore
add_action('transition_post_status', function ($new_status, $old_status, $post) {
    if (get_post_type($post) === 'page') {
        error_log("Status changed: {$old_status} -> {$new_status} for Page ID {$post->ID}");
    }

    if ($new_status === 'publish' && $old_status === 'trash' && get_post_type($post) === 'page') {
        error_log("Restore triggered for Page ID {$post->ID}");
        restore_page_template_on_restore($post->ID);
    }
}, 10, 3);





