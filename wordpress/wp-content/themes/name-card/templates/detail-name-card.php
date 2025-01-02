<?php

/**
 * Template Name: Detail Name User
 * Description: A template to display user details.
 */

// Tải WordPress header
wp_head();

// Lấy ID người dùng từ URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn dữ liệu từ bảng database
global $wpdb;
$table_name = $wpdb->prefix . 'user_cards'; // Thay 'user_cards' bằng tên bảng của bạn
$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id));

// Kiểm tra nếu không tìm thấy người dùng
if (!$user) {
    echo '<p>Không tìm thấy người dùng!</p>';
    get_footer();
    exit;
}
?>

<div class="container mt-3">
    <div class="box-detail">
        <div class="infor">
            <div class="fil">
                <span>Name</span>
                <span>Email</span>
                <span>Phone</span>
                <span>Jobtitle</span>
                <span>Jobname</span>
                <span>Birthday</span>
                <span>Address</span>
            </div>
            <div class="data-infor">
                <span><?php echo esc_html($user->name); ?></span>
                <span><?php echo esc_html($user->email); ?></span>
                <span><?php echo esc_html($user->phone); ?></span>
                <span><?php echo esc_html($user->jobtitle); ?></span>
                <span><?php echo esc_html($user->jobname); ?></span>
                <span><?php echo esc_html($user->birthdate); ?></span>
                <span><?php echo esc_html($user->address); ?></span>
            </div>
        </div>
    </div>
</div>