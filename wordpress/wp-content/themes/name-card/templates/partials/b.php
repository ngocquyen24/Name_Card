
<?php

/**
 * Template Name: Template A
 * Description: A template for displaying user details.
 */

$user = json_decode(get_query_var('user', '')); // Lấy user từ set_query_var
$company = json_decode(get_query_var('company', '')); // Lấy company từ set_query_var

$user_id = json_decode(get_query_var('user_id', ''));
$card = json_decode(get_query_var('card', ''));





if (isset($_GET['download_vcard']) && !empty($user_id)) {
    if ($card) {
        $address .= esc_attr($card->address) . "\r\n"; // Dùng $card->address thay vì $card['address']
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:" .esc_attr($card->name). "\r\n";
        $vcard .= "EMAIL:" . esc_attr($card->email) . "\r\n";
        $vcard .= "TEL:" . esc_attr($card->phone) . "\r\n";
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
            <div class="name-card-b front-card-b">
                <div class="front">
                    <div class="row box-infor">
                        <div class="col-md-5 line">
                            <div class="jobname"><?php echo esc_html($user->jobname); ?></div>
                            <div class="name-b"><?php echo esc_html($user->name); ?></div>
                        </div>
                        <div class="col-md-7">
                            <div class="mail-b gr-infor">
                                <div class="icon-infor-b icon-mail"><i class="fa-solid fa-envelope"></i></div>
                                <div class="infor-b"><?php echo esc_html($user->email); ?></div>
                            </div>
                            <div class="network-b gr-infor">
                                <div class="icon-infor-b icon-network"><i class="fa-solid fa-globe"></i></div>
                                <div class="infor-b"><?php echo esc_html($user->email); ?></div>
                            </div>
                            <div class="phone-b gr-infor">
                                <div class="icon-infor-b icon-phone"><i class="fa-solid fa-phone-volume"></i></div>
                                <div class="infor-b"><?php echo esc_html($user->phone); ?></div>
                            </div>
                            <div class="location-b gr-infor">
                                <div class="icon-infor-b icon-location"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="infor-b">
                                    <p>
                                        東京都中央区京橋1-1-5 セントラルビル2階
                                        Tokyo, Chou, Kyobashi 1-1-5 Central
                                        Building 2F
                                    </p>
                                    <p>
                                        5th Floor, 50 Cuu Long, Ward 2, Tan Binh
                                        District, Ho Chi Minh City, Vietnam
                                    </p>
                                    <p>
                                        6th Floor, 132 Le Đinh Ly, Thanh Khe
                                        District, Da Nang City, Vietnam
                                    </p>
                                </div>
                            </div>
                            <span class="location-b infor-b">


                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="name-card-b back-card-b">
                <div class="back">
                    <div class="title-b">事業紹介</div>
                    <p>
                        IoT, AI, DX, システム統合、ローコード、システム開発 <br>
                        コンサルティング、アウトソーシング、ウェブ制作、M&A支援
                        <br>
                        IoT, AI, DX, System Intergration, Low Code, System Development
                        Consulting, Outsourcing, Web Development, M&A Support
                    </p>
                    <div class="title-b">CEO紹介</div>
                    <p>
                        AIoT株式会社 - 代表取締役 / AIoT Inc. - CEO <br>
                        日越DX協会 - 副会長 / VADX JAPAN - Vice Chairman
                        <br>
                        在日ベトナム起業家支援協会 - 副会長 <br>
                        Vietnam Japan Association of Entrepreneuship - Vice Chairman
                    </p>
                </div>
            </div>
        </div>

    </form>
</div>


<button id="downloadPage"
    style="position: fixed; z-index: 9999; margin-top:300px; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
    Tải trang dưới dạng PNG
</button>
<button
    id="downloadVCard"
    onclick="cardVcf(<?php echo intval($user_id); ?>)"
    style="position: fixed; z-index: 9999; margin-top:350px; padding: 10px; background: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
    Tải Contact vCard
</button>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>
    

</body>

</html>