document.getElementById("show-notification").addEventListener("click", function() {
    showNotifications(); // Gọi hàm để hiển thị thông báo
});

function showNotifications() {
    fetch('noti.txt')
        .then(response => response.text())
        .then(data => {
            if (data) {
                const notifications = data.split('\n').filter(Boolean); // Lọc các dòng trống
                const alertMessage = notifications.join('\n');
                alert(alertMessage); // Hiển thị thông báo
            } else {
                alert('Không có thông báo mới.');
            }
        })
        .catch(error => console.error('Lỗi:', error));
}
