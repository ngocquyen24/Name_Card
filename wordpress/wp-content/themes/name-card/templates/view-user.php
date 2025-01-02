<?php
/*
Template Name: View User
*/

// Tải WordPress header

use Rakit\Validation\Rules\Json;



global $wpdb;

// Lấy ID người dùng từ URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


// Truy vấn dữ liệu từ bảng company database
$table_name = $wpdb->prefix . 'company';
$company = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d LIMIT 1", 1));
// Truy vấn dữ liệu từ bảng user database

$table_user = $wpdb->prefix . 'user_cards';
$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_user WHERE id = %d", $user_id));

$card = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_user WHERE id = %d", $user_id), ARRAY_A);

// $id = isset($_GET['id']) ? intval($_GET['id']) : 0; 


ob_start();


// Kiểm tra nếu không tìm thấy user
if (!$user) {
    echo '<p>User not found!</p>';
    get_footer();
    exit;
}

// Lấy template từ cơ sở dữ liệu
$user->template = isset($user->template) ? $user->template : 'a'; 

// Chuẩn bị đường dẫn template
$partial = '/partials/' . ($user->template ?? 'a') . '.php';

// Truyền dữ liệu vào template
set_query_var('user', json_encode($user));
set_query_var('company', json_encode($company));
set_query_var('user_id', json_encode($user_id));
set_query_var('card', json_encode($card));

// Load template
if ($overridden_template = locate_template($partial)) {
    load_template($overridden_template);
} else {
    load_template(dirname(__FILE__) . $partial, true);
}
?>
