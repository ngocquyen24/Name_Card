function cardPNG() {
    document.getElementById('downloadPage').addEventListener('click', function () {
        // Lấy phần tử bạn muốn chụp, ví dụ: phần tử có lớp 'name-card-container'
        var elementToCapture = document.querySelector('.name-card');

        // Sử dụng html2canvas để chụp phần tử đó
        html2canvas(elementToCapture, {
            scale: 2,
            useCORS: true,
            width: 1050,
            height: 320,
        }).then(function (canvas) {

            const link = document.createElement('a');
            link.download = 'profile.png';
            link.href = canvas.toDataURL('image/png'); // Chuyển đổi canvas thành URL
            link.click(); // Tải file
        }).catch(function (error) {
            console.error('Lỗi khi chụp phần tử:', error);
        });
    });
}

function cardVcf(user_id) {
    var contactId = user_id; // Lấy ID từ PHP
    // Tạo URL để tải vCard
    var vCardUrl = window.location.origin + window.location.pathname + '?id=' + contactId + '&download_vcard=1';
    // Tạo liên kết và kích hoạt tải vCard
    var link = document.createElement('a');
    link.href = vCardUrl;
    link.download = 'contact.vcf'; // Đặt tên file tải về
    link.click();
}


cardPNG();