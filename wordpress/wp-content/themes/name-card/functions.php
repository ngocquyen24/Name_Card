<?php
require_once get_template_directory() . '/core/setup.php';   // Thiết lập cấu hình
require_once get_template_directory() . '/core/enqueue.php'; // Đăng ký và tải các file CSS/JS

function enqueue_theme_assets() {
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

add_action('init', function () {
    if (isset($_GET['download_vcard']) && $_GET['download_vcard'] == '1' && isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
        
        // Lấy dữ liệu từ database
        global $wpdb;
        $table_user = $wpdb->prefix . 'user_cards';
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_user WHERE id = %d", $user_id));
        
        if ($user) {
            // Tạo nội dung vCard
            $vcard = "BEGIN:VCARD\n";
            $vcard .= "VERSION:3.0\n";
            $vcard .= "FN:" . (!empty($user->name) ? esc_html($user->name) : 'N/A') . "\n";
            $vcard .= "EMAIL:" . (!empty($user->email) ? esc_html($user->email) : 'N/A') . "\n";
            $vcard .= "TEL:" . (!empty($user->phone) ? esc_html($user->phone) : 'N/A') . "\n";            
            $vcard .= "END:VCARD\n";

            // Thiết lập header để tải file
            header('Content-Type: text/vcard');
            header('Content-Disposition: attachment; filename="contact.vcf"');
            echo $vcard;
            exit;
        }
    }
});



