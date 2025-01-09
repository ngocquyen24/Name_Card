<?php

/**
 * Template Name: Template B
 * Description: A template for displaying user details.
 */

$user = json_decode(get_query_var('user', '')); // Lấy user từ set_query_var
$company = json_decode(get_query_var('company', '')); // Lấy company từ set_query_var

$user_id = json_decode(get_query_var('user_id', ''));
$card = json_decode(get_query_var('card', ''));





if (isset($_GET['download_vcard']) && !empty($user_id) && !empty($company)) {
    if ($card) {
        $address .= esc_attr($card->address) . "\r\n"; // Dùng $card->address thay vì $card['address']
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:" . esc_attr($card->name) . "\r\n";
        $vcard .= "EMAIL:" . esc_attr($card->email) . "\r\n";
        $vcard .= "TEL:" . esc_attr($card->phone) . "\r\n";

        if (!empty($company->image)) {
            # code...
        }

        if (!empty($card->image)) {
            $image_path = wp_upload_dir()['basedir'] . '/imagesUser/' . $card->image; // Đường dẫn hình ảnh trên server
            if (file_exists($image_path)) {
                $image_data = file_get_contents($image_path);
                $base64_image = base64_encode($image_data);
                $vcard .= "PHOTO;ENCODING=b;TYPE=JPEG:$base64_image\r\n"; // Sử dụng TYPE=JPEG cho định dạng ảnh JPEG
            }
        }


        // Thêm địa chỉ (1 dòng) vào vCard
        if (!empty($address)) {
            $vcard .= "ADR;TYPE=home:;;$address;;;;\r\n";
        }
        ////
        // Thêm URL Google Maps nếu địa chỉ không rỗng
        if (!empty($address)) {
            $map_query = urlencode($address);
            $vcard .= "URL:https://www.google.com/maps/search/?api=1&query=$map_query\r\n";
        }

        if (!empty($company)) {
            $vcard .= "ORG:" . esc_attr($company->name) . "\r\n"; // Tên công ty

        }

        if (!empty($user) && !empty($user->jobname)) {
            $vcard .= "TITLE:" . esc_attr($user->jobname) . "\r\n"; // Thêm jobname từ company
        }

        if (!empty($jobname)) {
            echo '<p class="jobname">Job: ' . esc_html($jobname) . '</p>'; // Hiển thị jobname trên giao diện
        }

        $vcard .= "END:VCARD\r\n";

        header('Content-Type: text/vcard; charset=utf-8');
        header('Content-Disposition: attachment; filename="contact.vcf"');
        echo $vcard;
        exit;
    } else {
        echo "Contact not found.";
        exit;
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>

    <div class="name-card-container ">
        <div class="name-card">
            <div class="name-card-a front-card-a">
                <div class="front">
                    <div class="jobname"><?php echo esc_html($user->jobname); ?></div>
                    <div class="name-b"><?php echo esc_html($user->name); ?></div>
                    <div class="my-image">
                        <img src="<?php echo esc_url(wp_upload_dir()['baseurl'] . '/imagesUser/' . $user->image); ?>">
                        <canvas class="qrcode" id="qrcode" style="width: 0; height: 0;"></canvas>
                    </div>
                </div>
            </div>
            <div class="name-card-a back-card-a">
                <div class="back">

                </div>
            </div>
        </div>

        </form>
    </div>

    <div class="photo">
        <button id="downloadPage">
            Download PNG
        </button>
        <button id="downloadVCard" onclick="cardVcf(<?php echo intval($user_id); ?>)">
            Download vCard
        </button>
    </div>



    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script>
        const baseURL = "aiot-global.com/";
        const userName = "<?php echo addslashes($user->name); ?>";
        const data = baseURL + userName;
        const qrCodeCanvas = document.getElementById("qrcode");

        QRCode.toCanvas(qrCodeCanvas, data, {
            width: 70,
            margin: 2
        }, function(error) {
            if (error) console.error("Lỗi tạo mã QR:", error);
            else console.log("QR code đã được tạo!");
        });
    </script>


</body>

</html>