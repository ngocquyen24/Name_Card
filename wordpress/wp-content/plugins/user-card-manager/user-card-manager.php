<?php
/*
Plugin Name: User Card Manager
Plugin URI: https://example.com
Description: Plugin quản lý danh sách user card có thể xem, sửa, xóa và hiển thị ra trang chính.
Version: 1.0
Author: Your Name
License: GPL2
*/
ob_start();

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Tạo bảng trong database khi kích hoạt plugin
function ncm_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_cards';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        birthdate date DEFAULT NULL,
        address text DEFAULT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20) NOT NULL,
        jobtitle varchar(100) NOT NULL,
        jobname varchar(100) NOT NULL,
        template varchar(100) NOT NULL,
        image varchar(255) DEFAULT '' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'ncm_create_table');

// Thêm menu vào Dashboard
function ncm_admin_menu()
{
    add_menu_page(
        'Quản lý User Card',
        'User Card',
        'manage_options',
        'user-card-manager',
        'ncm_admin_page',
        'dashicons-id',
        6
    );
}
add_action('admin_menu', 'ncm_admin_menu');



// Giao diện trang quản trị chính
function ncm_admin_page()
{
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($action === 'add' || ($action === 'edit' && $id > 0)) {
        ncm_add_edit_form($id);
    } else {
        ncm_list_view();
    }
}
function cm_handle_image_upload_user($file)
{
    // Lấy đường dẫn của thư mục upload trong WordPress
    $upload_dir = wp_upload_dir();

    // Tạo đường dẫn tới thư mục 'imagesCompany'
    $target_dir = $upload_dir['basedir'] . '/imagesUser/';

    // Tạo thư mục nếu chưa tồn tại
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Sanitize tên file để tránh các ký tự đặc biệt
    $file_name = sanitize_file_name($file['name']);

    // Tạo đường dẫn đầy đủ cho file upload
    $target_file = $target_dir . basename($file_name);

    // Kiểm tra loại file (chỉ cho phép hình ảnh)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        // return 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
        return false;  // Trả về false nếu loại tệp không hợp lệ
    }

    // Di chuyển file từ thư mục tạm thời vào thư mục đích
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Trả về URL của hình ảnh đã upload
        return basename($file_name);
    }

    return false;
}

// Giao diện thêm/sửa name card
function ncm_add_edit_form($id = 0)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_cards';

    $card = ['name' => '', 'birthdate' => '', 'address' => '', 'email' => '', 'phone' => '', 'jobtitle' => '', 'jobname' => '', 'tempalte' => '', 'image' => ''];
    if ($id > 0) {
        $card = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
        if (!$card) {
            echo '<p>Not found name card.</p>';
            return;
        }
    }

    if (isset($_POST['save_card'])) {
        $data = [
            'name' => sanitize_text_field($_POST['name']),
            'birthdate' => sanitize_text_field($_POST['birthdate']),
            'address' => sanitize_text_field($_POST['address']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
            'jobtitle' => sanitize_text_field($_POST['jobtitle']),
            'jobname' => sanitize_text_field($_POST['jobname']),
            'template' => sanitize_text_field($_POST['template']),
        ];



        // Kiểm tra và xử lý tải ảnh (nếu có)
        if (!empty($_FILES['image']['name'])) {
            $image_upload_result = cm_handle_image_upload_user($_FILES['image']);
            if ($image_upload_result === false) {
                // Nếu tệp không hợp lệ, lưu thông báo lỗi và không tiếp tục lưu dữ liệu
                $error_message = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
            } else {
                // Nếu ảnh hợp lệ, lưu tên ảnh vào dữ liệu
                $data['image'] = $image_upload_result;
            }
        } else if ($id > 0) {
            // Nếu không chọn ảnh mới, giữ ảnh cũ (khi là sửa)
            $data['image'] = $card['image'];
        }

        // Nếu không có lỗi, lưu hoặc cập nhật dữ liệu vào cơ sở dữ liệu
        if (empty($error_message)) {
            if ($id > 0) {
                $wpdb->update($table_name, $data, ['id' => $id]);
            } else {
                $wpdb->insert($table_name, $data);
            }
            // Lệnh chuyển hướng trang 
            wp_redirect(admin_url('admin.php?page=user-card-manager'));
            exit;
        }

    }

    // Chuyển qua trang add và update 
    include plugin_dir_path(__FILE__) . 'templates/addUpdate.php';
}

// Giao diện danh sách name card
function ncm_list_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_cards';

    if (isset($_POST['delete_card'])) {
        $wpdb->delete($table_name, ['id' => intval($_POST['card_id'])]);
        wp_redirect(admin_url('admin.php?page=user-card-manager'));
        exit;
    }

    $cards = $wpdb->get_results("SELECT * FROM $table_name");
    // Chuyển qua trang list    
    include plugin_dir_path(__FILE__) . 'templates/list.php';
}

// Shortcode hiển thị danh sách name card trên trang chính
function ncm_front_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_cards';
    $cards = $wpdb->get_results("SELECT * FROM $table_name");
    include plugin_dir_path(__FILE__) . 'templates/front-view.php';
?>

<?php
    return ob_get_clean();
}
add_shortcode('name_card_list', 'ncm_front_view');
