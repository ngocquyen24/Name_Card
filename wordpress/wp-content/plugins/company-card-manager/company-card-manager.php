<?php
/*
Plugin Name: Company Card Manager
Plugin URI: https://example.com
Description: Plugin quản lý danh sách công ty có thể xem, sửa, xóa và hiển thị ra trang chính.
Version: 1.1
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
        return 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
    }

    // Di chuyển file từ thư mục tạm thời vào thư mục đích
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Trả về URL của hình ảnh đã upload
        // return $upload_dir['baseurl'] . '/imagesCompany/' . basename($file_name);
        return basename($file_name);
    }

    return 'File upload failed.';
}
// Xóa hình ảnh khỏi thư mục
function cm_delete_image($image_url)
{
    $upload_dir = wp_upload_dir();
    $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);

    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Giao diện thêm/sửa thông tin công ty
function cm_add_edit_form($id = 0)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'company';

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

        if (!empty($_FILES['image']['name'])) {
            if (!empty($company['image'])) {
                cm_delete_image($company['image']);
            }
            $data['image'] = cm_handle_image_upload($_FILES['image']);
        } else if ($id > 0) {
            $data['image'] = $company['image'];
        }

        if ($id > 0) {
            $wpdb->update($table_name, $data, ['id' => $id]);
        } else {
            $wpdb->insert($table_name, $data);
        }
        wp_redirect(admin_url('admin.php?page=company-card-manager'));
        exit;
    }
?>
    <div class="wrap">
        <h1><?php echo $id > 0 ? 'Update Company' : 'Add Company'; ?></h1>
        <form method="post" enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" value="<?php echo esc_attr($company['name']); ?>" required></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><textarea name="address" required><?php echo esc_textarea($company['address']); ?></textarea></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><input type="text" name="phone" value="<?php echo esc_attr($company['phone']); ?>" required></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" name="email" value="<?php echo esc_attr($company['email']); ?>" required></td>
                </tr>
                <tr>
                    <th>Profile</th>
                    <td><textarea name="profile" required><?php echo esc_textarea($company['profile']); ?></textarea></td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        <input type="file" name="image">
                        <?php if (!empty($company['image'])): ?>
                            <p>Current Image:</p>
                            <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company['image']); ?>" alt="Company Image" style="max-width: 150px;">
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <p><button type="submit" name="save_company" class="button button-primary">Save</button></p>
        </form>
        <a href="<?php echo admin_url('admin.php?page=company-card-manager'); ?>" class="button">Back</a>
    </div>
<?php
}

// Giao diện danh sách công ty
function cm_list_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'company';

    if (isset($_POST['delete_company'])) {
        $company = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_POST['company_id'])));

        if ($company) {
            cm_delete_image($company->image);
            $wpdb->delete($table_name, ['id' => intval($_POST['company_id'])]);
        }
        wp_redirect(admin_url('admin.php?page=company-card-manager'));
        exit;
    }

    $company = $wpdb->get_results("SELECT * FROM $table_name");
?>
    <div class="wrap">
        <h1>List Company</h1>
        <a href="<?php echo admin_url('admin.php?page=company-card-manager&action=add'); ?>" class="button button-primary">Add Company</a>
        <table class="widefat fixed" style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Profile</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($company as $company): ?>
                    <tr>
                        <td><?php echo ($company->name); ?></td>
                        <td><?php echo ($company->address);
                            ?></td>
                        <td><?php echo ($company->phone); ?></td>
                        <td><?php echo ($company->email); ?></td>
                        <td><?php echo ($company->profile); ?></td>
                        <td>
                            <?php if (!empty($company->image)): ?>
                                <img src="<?php echo  wp_upload_dir()['baseurl'] . '/imagesCompany/'; ?><?php echo ($company->image); ?>" alt="Company Image" style="max-width: 100px;">
                            <?php else: ?>
                                <span>No Image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=company-card-manager&action=edit&id=' . $company->id); ?>" class="button">Edit</a>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this company?');">
                                <input type="hidden" name="company_id" value="<?php echo $company->id; ?>">
                                <button type="submit" name="delete_company" class="button button-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
}

// Shortcode hiển thị danh sách công ty trên trang chính
function cm_front_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'company';
    
    // Lấy công ty có id = 1
    $company = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", 1));

    ob_start();
?>
    <div class="company-list">
        <?php if (!empty($company)): ?>
            <?php foreach ($company as $company): ?>
                <div class="company-card">
                    <?php if (!empty($company->image)): ?>
                        <img src="<?php echo esc_url($company->image); ?>" alt="<?php echo esc_attr($company->name); ?>" style="max-width: 150px;">
                    <?php endif; ?>
                    <h3><?php echo esc_html($company->name); ?></h3>
                    <p><strong>Address:</strong> <?php echo esc_html($company->address); ?></p>
                    <p><strong>Phone:</strong> <?php echo esc_html($company->phone); ?></p>
                    <p><strong>Email:</strong> <?php echo esc_html($company->email); ?></p>
                    <p><strong>Profile:</strong> <?php echo esc_html($company->profile); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No company found with ID = 1.</p>
        <?php endif; ?>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('company_list', 'cm_front_view');

