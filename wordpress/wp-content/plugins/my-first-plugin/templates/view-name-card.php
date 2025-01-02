<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #e0e0e0;
    }

    .name-card-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        display: flex;
        /* Khoảng cách giữa các thẻ */
    }

    .name-card {
        width: 336px;
        /* Kích thước chuẩn 3.5 inch */
        height: 192px;
        /* Kích thước chuẩn 2 inch */
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 20px;
        perspective: 1000px;
    }

    /* Mặt trước */
    .name-card .front,
    .name-card .back {
        flex-direction: column;
        justify-content: left;
    }

    h3,
    p {
        margin: 10px 0;
    }

    .name-card .company .logo img {
        height: 60px;
        width: 60px;
    }

    .name-card .company {
        display: flex;
    }

    .name-card .company .name-company {
        margin-left: 30px;
        line-height: 65px;
        height: 50px;
    }
</style>
<?php
// Lấy URL của thư mục theme
$theme_directory = get_template_directory_uri();

// Đường dẫn đến ảnh trong thư mục assets/images
$image_url = $theme_directory . '/assets/images/icon.jpg';
?>

<div class="name-card-container">
    <form style="display: contents;">
        <!-- Thẻ tên 1 -->

        <div class="name-card">
            <div class="front">
                <div class="company">
                    <div class="logo"><img src="<?php echo esc_url($image_url); ?>" alt="Logo"></div>
                    <div class="name-company">NewIT</div>
                </div>
                <div class="name">
                    <h3>Name: <?php echo esc_html($card->name); ?></h3>
                </div>
                <div class="email">
                    <p>Email: </p>
                </div>
                <div class="phone">
                    <p>Phone:</p>
                </div>
            </div>
        </div>

        <!-- Thẻ tên 2 -->
        <div class="name-card">
            <div class="back">
                <h3>Contact Info</h3>
                <p>Phone: 987-654-3210</p>
                <p>Location: Los Angeles</p>
            </div>
        </div>
    </form>

</div>
