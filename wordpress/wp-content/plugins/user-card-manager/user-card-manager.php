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

// Giao diện thêm/sửa name card
function ncm_add_edit_form($id = 0)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_cards';

    $card = ['name' => '', 'birthdate' => '', 'address' => '', 'email' => '', 'phone' => '', 'jobtitle' => '', 'jobname' => '', 'tempalte' => ''];
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
        if ($id > 0) {
            $wpdb->update($table_name, $data, ['id' => $id]);
        } else {
            $wpdb->insert($table_name, $data);
        }



        // Lệnh chuyển hướng trang 
        wp_redirect(admin_url('admin.php?page=user-card-manager'));
        exit;
    }
?>
    <div class="wrap">
        <h1><?php echo $id > 0 ? 'Update User Card' : 'Add User Card'; ?></h1>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" value="<?php echo esc_attr($card['name']); ?>" required></td>
                </tr>
                <tr>
                    <th>Birthdate</th>
                    <td><input type="date" name="birthdate" value="<?php echo esc_attr($card['birthdate'] ?? ''); ?>" required></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><textarea name="address" required><?php echo esc_textarea($card['address'] ?? ''); ?></textarea></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" name="email" value="<?php echo esc_attr($card['email']); ?>" required></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><input type="text" name="phone" value="<?php echo esc_attr($card['phone']); ?>" required></td>
                </tr>
                <tr>
                    <th>Job title</th>
                    <td><input type="text" name="jobtitle" value="<?php echo esc_attr($card['jobtitle']); ?>" required></td>
                </tr>
                <tr>
                    <th>Job name</th>
                    <td><input type="text" name="jobname" value="<?php echo esc_attr($card['jobname']); ?>" required></td>
                </tr>
                <tr>
                    <th>Template</th>
                    <td>
                        <select name="template" required>
                            <option value="a" <?php selected($card['template'], 'Template 1'); ?>>Template A</option>
                            <option value="b" <?php selected($card['template'], 'Template 2'); ?>>Template B</option>
                            <option value="c" <?php selected($card['template'], 'Template 3'); ?>>Template C</option>
                        </select>
                    </td>
                </tr>
            </table>
            <p><button type="submit" name="save_card" class="button button-primary">Save</button></p>
        </form>
        <a href="<?php echo admin_url('admin.php?page=user-card-manager'); ?>" class="button">Back</a>
    </div>
<?php
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

?>
    <div class="wrap">
        <h1>List User Card</h1>
        <a href="<?php echo admin_url('admin.php?page=user-card-manager&action=add'); ?>" class="button button-primary">Add user card</a>
        <table class="widefat fixed" style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Job title</th>
                    <th>Job name</th>
                    <th>Template</th>
                    <th>Active</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $card): ?>
                    <tr>
                        <td><?php echo ($card->name); ?></td>
                        <td><?php echo ($card->birthdate); ?></td>
                        <td><?php echo ($card->address); ?></td>
                        <td><?php echo ($card->email); ?></td>
                        <td><?php echo ($card->phone); ?></td>
                        <td><?php echo ($card->jobtitle); ?></td>
                        <td><?php echo ($card->jobname); ?></td>
                        <td><?php echo ($card->template); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=user-card-manager&action=edit&id=' . $card->id); ?>" class="button">Update</a>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user card?');">
                                <input type="hidden" name="card_id" value="<?php echo $card->id; ?>">
                                <button type="submit" name="delete_card" class="button button-danger">Delete</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
}

// Shortcode hiển thị danh sách name card trên trang chính
function ncm_front_view()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_cards';
    $cards = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/front-view.php';

?>

<?php
    return ob_get_clean();
}
add_shortcode('name_card_list', 'ncm_front_view');
