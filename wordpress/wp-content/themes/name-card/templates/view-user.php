<?php
/*
Template Name: View User
*/

// Tải WordPress header
wp_head();

// Lấy giá trị id từ query string, mặc định là 0 nếu không có
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn dữ liệu từ bảng user_cards
global $wpdb;
$table_user_cards = $wpdb->prefix . 'user_cards';
$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_user_cards WHERE id = %d", $user_id));

// Truy vấn dữ liệu từ bảng company
$table_company = $wpdb->prefix . 'company';
$company = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_company WHERE id = %d LIMIT 1", 1));

// Kiểm tra nếu không tìm thấy user
if (!$user) {
    echo '<p>User not found!</p>';
    get_footer();
    exit;
}

// Nếu không có template, gán mặc định là 'a'
$user->template = isset($user->template) ? $user->template : 'a'; 

// Chuẩn bị đường dẫn template
$partial = '/partials/' . $user->template . '.php';

// Truyền dữ liệu vào template
set_query_var('user', json_encode($user));
set_query_var('company', json_encode($company));

// Load template
if ($overridden_template = locate_template($partial)) {
    load_template($overridden_template);
} else {
    load_template(dirname(__FILE__) . $partial, true);
}

