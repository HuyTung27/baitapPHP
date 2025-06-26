document.addEventListener("DOMContentLoaded", function() {
    var overlap2 = document.querySelector(".overlap-2");
    var sticky = overlap2.offsetTop;

    function stickyFunction() {
        if (window.pageYOffset >= sticky) {
            overlap2.classList.remove("overlap-2");
            overlap2.classList.add("sticky");
        } else {
            overlap2.classList.add("overlap-2");
            overlap2.classList.remove("sticky");
        }
    }

    window.onscroll = stickyFunction; // Gọi hàm khi cuộn
});

// LÊN ĐẦU TRANG
function scrollToTop() {
  window.scrollTo({
      top: 0,
      behavior: 'smooth' // Hiệu ứng cuộn mượt mà
  });
}

// 
// menu
// Lấy các phần tử cần dùng
const menubarIcon = document.querySelector('.icon-menubar');
const container = document.getElementById('container');
const closeIcon = document.getElementById('close-icon');

// Sự kiện nhấn vào icon menubar để hiện container
menubarIcon.addEventListener('click', () => {
  container.style.display = 'block';  // Hiển thị container
  menubarIcon.style.display = 'none'; // Ẩn icon menubar
});

// Sự kiện nhấn vào icon close để ẩn container
const closeButton = document.querySelector('.close-button i');

closeButton.addEventListener('click', () => {
  menubarIcon.style.display = 'block';
  document.getElementById('container').style.display = 'none';
});


// chuyển ảnh
let currentIndex = 0; // Chỉ số hiện tại
const imagesContainer = document.querySelector('.images');
const images = document.querySelectorAll('.bai_giang');

// Lấy tổng số ảnh
const totalImages = images.length;

// Lấy các icon left và right
const leftArrow = document.querySelector('.polygon');
const rightArrow = document.querySelector('.polygon-2');

// Function để cập nhật vị trí của ảnh
function updateSliderPosition() {
    const imageWidth = images[0].clientWidth + parseFloat(getComputedStyle(images[0]).marginLeft) + parseFloat(getComputedStyle(images[0]).marginRight);
    imagesContainer.style.transform = `translateX(${-currentIndex * imageWidth}px)`;
    updateImageVisibility();
}

// Function để kiểm tra và cập nhật hiển thị ảnh
function updateImageVisibility() {
    images.forEach((image, index) => {
        if (index >= currentIndex && index < currentIndex + 3) { // Kiểm tra ảnh nằm trong khoảng
            image.classList.add('show'); // Thêm class để hiển thị
        } else {
            image.classList.remove('show'); // Xóa class để ẩn
        }
    });
}

// Sự kiện khi nhấn nút phải
rightArrow.addEventListener('click', () => {
    if (currentIndex < totalImages - 3) { // Trừ 3 vì đang hiển thị 3 ảnh
        currentIndex++;
    } else {
        // Quay về đầu nếu đến kịch
        currentIndex = 0;
    }
    updateSliderPosition();
});

// Sự kiện khi nhấn nút trái
leftArrow.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        // Quay về cuối nếu đang ở đầu
        currentIndex = totalImages - 3; // Hiển thị 3 ảnh, trừ 3 để hiện đủ
    }
    updateSliderPosition();
});

// Gọi hàm hiển thị khi tải trang
updateImageVisibility();


// chuyển ảnh tài liệu
// tài liệu 1
let currentIndex2 = 0; // Chỉ số hiện tại cho slider tài liệu
const imagesContainer2 = document.querySelector('.images-2'); // Lấy phần tử chứa ảnh
const images2 = document.querySelectorAll('.tai_lieu'); // Lấy tất cả các ảnh tài liệu

// Lấy tổng số ảnh tài liệu
const totalImages2 = images2.length; // Tổng số ảnh

// Lấy các icon left và right cho slider tài liệu
const leftArrow2 = document.querySelector('.polygon-3'); // Icon mũi tên trái
const rightArrow2 = document.querySelector('.polygon-4'); // Icon mũi tên phải

// Function để cập nhật vị trí của ảnh
function updateSliderPosition2() {
    const imageWidth2 = images2[0].clientWidth + parseFloat(getComputedStyle(images2[0]).marginLeft) + parseFloat(getComputedStyle(images2[0]).marginRight);
    imagesContainer2.style.transform = `translateX(${-currentIndex2 * imageWidth2}px)`; // Cập nhật vị trí của slider
    updateImageVisibility2(); // Gọi hàm để cập nhật hiển thị ảnh
}

// Function để kiểm tra và cập nhật hiển thị ảnh
function updateImageVisibility2() {
    images2.forEach((image, index) => {
        if (index >= currentIndex2 && index < currentIndex2 + 3) { // Kiểm tra ảnh nằm trong khoảng
            image.classList.add('show'); // Thêm class để hiển thị
        } else {
            image.classList.remove('show'); // Xóa class để ẩn
        }
    });
}

// Sự kiện khi nhấn nút phải
rightArrow2.addEventListener('click', () => {
    if (currentIndex2 < totalImages2 - 3) { // Trừ 3 vì đang hiển thị 3 ảnh
        currentIndex2++;
    } else {
        // Quay về đầu nếu đến kịch
        currentIndex2 = 0;
    }
    updateSliderPosition2(); // Cập nhật vị trí slider
});

// Sự kiện khi nhấn nút trái
leftArrow2.addEventListener('click', () => {
    if (currentIndex2 > 0) {
        currentIndex2--;
    } else {
        // Quay về cuối nếu đang ở đầu
        currentIndex2 = totalImages2 - 3; // Hiển thị 3 ảnh, trừ 3 để hiện đủ
    }
    updateSliderPosition2(); // Cập nhật vị trí slider
});

// Gọi hàm hiển thị khi tải trang
updateImageVisibility2();


// -----------------------------------------
const dialogh = document.getElementById('dialog_thongtin');
const openButton = document.querySelector('.thongtin');
const cancelButton = dialogh.querySelector('button[value="cancel"]');  // Nút hủy bỏ

if (openButton) {
    openButton.addEventListener('click', () => {
        dialogh.showModal();
    });
}

// Đóng dialog khi click ra ngoài form
dialogh.addEventListener('click', (event) => {
    if (event.target === dialogh) {
        dialogh.close();
    }
});

// Đóng dialog khi nhấn nút "Hủy Bỏ"
if (cancelButton) {
    cancelButton.addEventListener('click', () => {
        dialogh.close();
    });
}

// --------------------------
const dialogh2 =document.getElementById('dialog-form-huy');
const openButton2 =document.querySelector('.doimk');
if (openButton2) {
    openButton2.addEventListener('click', () => {
        dialogh2.showModal();
    });
}

dialogh2.addEventListener('click', (event) => {
    if (event.target === dialogh2) {  // Kiểm tra nếu click ngoài form
        dialogh2.close();  // Đóng dialog
    }
});


// Thêm sự kiện click cho từng ảnh tài liệu
documentImages.forEach((img, index) => {
  img.addEventListener('click', () => {
    // Lấy phần tử dialog
    const dialog = document.getElementById('dialog-image-info');
    
    // Lấy phần mô tả bên trong dialog
    const dialogDescription = document.getElementById('image-info-description');
    
    // Cập nhật mô tả theo hình ảnh đã nhấn
    dialogDescription.textContent = imageInfo[index].description;
    
    // Hiển thị dialog
    dialog.showModal();
  });
});

// 

// tbaio

function showNotifications() {
    fetch('../QTV/noti.txt')
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

// 
function openTeacherDialog(element) {
    // Lấy thông tin từ các thuộc tính dữ liệu của hình ảnh
    const teacherName = element.getAttribute('data-teacher-name');
    const teacherId = element.getAttribute('data-teacher-id');
    const teacherIntro = element.getAttribute('data-teacher-intro');

    // Cập nhật các trường thông tin trong dialog
    document.getElementById('teacher_id').value = teacherId;
    document.getElementById('teacher-name').value = teacherName;
    document.getElementById('teacher-intro').value = teacherIntro;

    // Hiển thị dialog
    document.getElementById('dialog-teacher').showModal();
}

// 
