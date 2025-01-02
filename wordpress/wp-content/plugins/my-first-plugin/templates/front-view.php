<style>
    /* Cấu trúc tổng thể */
    .name-card {
        width: 300px;
        height: 180px;
        perspective: 1000px;
        /* Tạo hiệu ứng 3D */
        margin: 20px;
    }

    .name-card-inner {
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
        transition: transform 0.6s;
    }

    .name-card:hover .name-card-inner {
        transform: rotateY(180deg);
        /* Quay 180 độ khi di chuột */
    }

    /* Mặt trước của name card */
    .name-card-front,
    .name-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        /* Ẩn mặt sau khi quay */
        padding: 20px;
        box-sizing: border-box;
    }

    /* Mặt trước */
    .name-card-front {
        background-color: #f2f2f2;
        color: #333;
    }

    /* Mặt sau */
    .name-card-back {
        background-color: #4CAF50;
        color: white;
        transform: rotateY(180deg);
        /* Quay mặt sau 180 độ */
    }

    /* Cải tiến kiểu chữ cho card */
    .name-card h2,
    .name-card h3 {
        margin: 0;
        font-size: 20px;
    }

    .name-card p {
        margin: 5px 0;
        font-size: 14px;
    }
</style>

<?php
global $wpdb;

// Truy vấn dữ liệu từ bảng wp_user_cards
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($user_id > 0) {
    $card = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_user_cards WHERE id = %d", $user_id));
    if ($card):
?>
        <div class="name-card">
            <div class="name-card-inner">
                <!-- Mặt trước của Name Card -->
                <div class="name-card-front">
                    <h2><?php echo esc_html($card->name); ?></h2>
                    <p>Email: <?php echo esc_html($card->email); ?></p>
                    <p>Điện thoại: <?php echo esc_html($card->phone); ?></p>
                </div>
                <!-- Mặt sau của Name Card -->
                <div class="name-card-back">
                    <h3>Thông tin bổ sung</h3>
                    <p>Chức vụ: <?php echo esc_html($card->jobtitle); ?></p>
                    <p>Công ty: <?php echo esc_html($card->company); ?></p>
                    <p>Địa chỉ: <?php echo esc_html($card->address); ?></p>
                </div>
            </div>
        </div>
<?php
    else:
        echo "<p>Không tìm thấy thông tin người dùng.</p>";
    endif;
} else {
    echo "<p>ID người dùng không hợp lệ.</p>";
}
?>