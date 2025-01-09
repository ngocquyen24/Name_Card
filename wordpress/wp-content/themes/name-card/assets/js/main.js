function cardPNG(){
    document.getElementById('downloadPage').addEventListener('click', function () {
        // Lấy phần tử bạn muốn chụp
        var frontCard = document.querySelector('.front-card-b'); // Mặt trước
        var backCard = document.querySelector('.back-card-b');  // Mặt sau

        //upload imagees
        function captureAndDownload(element, fileName) {
            html2canvas(element, {
                scale: 2,
                useCORS: true,
            }).then(function (canvas) {
                const link = document.createElement('a');
                link.download = fileName;
                link.href = canvas.toDataURL('image/png'); // canva -> url
                link.click(); // .download
            }).catch(function (error) {
                console.error('Lỗi khi chụp phần tử:', error);
            });
        }

        //font
        captureAndDownload(frontCard, 'front-card.png');
        //back
        captureAndDownload(backCard, 'back-card.png');
    });
}
function cardVcf(user_id) {
    var contactId = user_id; // Lấy ID từ PHP
    // Tạo URL để tải vCard
    var vCardUrl = window.location.origin + window.location.pathname + '?id=' + contactId + '&download_vcard=1';

    console.log(window.location.pathname);
    // Tạo liên kết và kích hoạt tải vCard
    var link = document.createElement('a');
    link.href = vCardUrl;
    link.download = 'contact.vcf'; // Đặt tên file tải về
    link.click();
}


cardPNG();