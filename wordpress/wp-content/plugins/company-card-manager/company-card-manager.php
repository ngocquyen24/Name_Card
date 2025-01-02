<?php
/*
Plugin Name: Company Card Manager
Plugin URI: https://example.com
Description: Plugin quản lý danh sách công ty có thể xem, sửa và hiển thị ra trang chính.
Version: 1
Author: Your Name
License: GPL2
*/
ob_start();
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Tạo bảng trong database khi kích hoạt plugin
function cm_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'company';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        address varchar(255) NOT NULL,
        phone varchar(20) NOT NULL,
        email varchar(100) NOT NULL,
        profile text NOT NULL,
        image varchar(255) DEFAULT '' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'cm_create_table');

// Thêm menu vào Dashboard
function cm_admin_menu()
{
    add_menu_page(
        'Company Card Manager',
        'Company Card Manager',
        'manage_options',
        'company-card-manager',
        'cm_admin_page',
        'dashicons-admin-multisite',
        6
    );
}
add_action('admin_menu', 'cm_admin_menu');

// Giao diện trang quản trị chính
function cm_admin_page()
{
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($action === 'add' || ($action === 'edit' && $id > 0)) {
        cm_add_edit_form($id);
    } else {
        cm_list_view();
    }
}
function cm_handle_image_upload($file)
{
    // Lấy đường dẫn của thư mục upload trong WordPress
    $upload_dir = wp_upload_dir();

    // Tạo đường dẫn tới thư mục 'imagesCompany'
    $target_dir = $upload_dir['basedir'] . '/imagesCompany/';

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
        // return $upload_dir['baseurl'] . '/imagesCompany/' . basename($file_name);
        return basename($file_name);
    }

    return false;
}

// Giao diện thêm/sửa thông tin công ty
function cm_add_edit_form($id = 0)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'company';
    $error_message = '';

    $company = ['name' => '', 'address' => '', 'phone' => '', 'email' => '', 'profile' => '', 'image' => ''];

    if ($id > 0) {
        $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
        if (!$company) {
            echo '<p>Company not found</p>';
            return;
        }
    }

    if (isset($_POST['save_company'])) {
        $data = [
            'name' => sanitize_text_field($_POST['name']),
            'address' => sanitize_textarea_field($_POST['address']),
            'phone' => sanitize_text_field($_POST['phone']),
            'email' => sanitize_email($_POST['email']),
            'profile' => sanitize_textarea_field($_POST['profile']),
        ];

      
        
        
         // Kiểm tra và xử lý tải ảnh (nếu có)
         if (!empty($_FILES['image']['name'])) {
            $image_upload_result = cm_handle_image_upload($_FILES['image']);
            if ($image_upload_result === false) {
                // Nếu tệp không hợp lệ, lưu thông báo lỗi và không tiếp tục lưu dữ liệu
                $error_message = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
                
            } else {
                // Nếu ảnh hợp lệ, lưu tên ảnh vào dữ liệu
                $data['image'] = $image_upload_result;
            }
        } else if ($id > 0) {
            // Nếu không chọn ảnh mới, giữ ảnh cũ (khi là sửa)
            $data['image'] = $company['image'];
        }

        // Nếu không có lỗi, lưu hoặc cập nhật dữ liệu vào cơ sở dữ liệu
        if (empty($error_message)) {
            if ($id > 0) {
                // Cập nhật công ty đã tồn tại
                $wpdb->update($table_name, $data, ['id' => $id]);
            } else {
                // Thêm mới công ty
                $wpdb->insert($table_name, $data);
            }
            wp_redirect(admin_url('admin.php?page=company-card-manager'));
            exit;
        }

    }

    // Chuyển qua trang add và update 
    include plugin_dir_path(__FILE__) . 'templates/addUpdate.php';
}

// Giao diện danh sách công ty
function cm_list_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'company';
    // Kiểm tra nếu đã có ít nhất 1 công ty
    $has_company = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    // Lấy công ty đầu tiên có id = 1
    $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d LIMIT 1", 1));

    // Chuyển qua trang list
    include plugin_dir_path(__FILE__) . 'templates/list.php';
}
