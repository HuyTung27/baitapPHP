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

// tài liệu 2
let currentIndex3 = 0; // Chỉ số hiện tại cho slider tài liệu
const imagesContainer3 = document.querySelector('.images-3'); // Lấy phần tử chứa ảnh
const images3 = document.querySelectorAll('.tai_lieu1'); // Lấy tất cả các ảnh tài liệu

// Lấy tổng số ảnh tài liệu
const totalImages3 = images3.length; // Tổng số ảnh

// Lấy các icon left và right cho slider tài liệu
const leftArrow3 = document.querySelector('.polygon-5'); // Icon mũi tên trái
const rightArrow3 = document.querySelector('.polygon-6'); // Icon mũi tên phải

// Function để cập nhật vị trí của ảnh
function updateSliderPosition3() {
  const imageWidth3 = images3[0].clientWidth + parseFloat(getComputedStyle(images3[0]).marginLeft) + parseFloat(getComputedStyle(images3[0]).marginRight);
  imagesContainer3.style.transform = `translateX(${-currentIndex3 * imageWidth3}px)`; // Cập nhật vị trí của slider
  
    updateImageVisibility3(); // Gọi hàm để cập nhật hiển thị ảnh
}

// Function để kiểm tra và cập nhật hiển thị ảnh
function updateImageVisibility3() {
    images3.forEach((image, index) => {
        if (index >= currentIndex3 && index < currentIndex3 + 3) { // Kiểm tra ảnh nằm trong khoảng
            image.classList.add('show'); // Thêm class để hiển thị
        } else {
            image.classList.remove('show'); // Xóa class để ẩn
        }
    });
}

// Sự kiện khi nhấn nút phải
rightArrow3.addEventListener('click', () => {
    if (currentIndex3 < totalImages3 - 3) { // Trừ 3 vì đang hiển thị 3 ảnh
        currentIndex3++;
    } else {
        // Quay về đầu nếu đến kịch
        currentIndex3 = 0;
    }
    updateSliderPosition3(); // Cập nhật vị trí slider
});

// Sự kiện khi nhấn nút trái
leftArrow3.addEventListener('click', () => {
  if (currentIndex3 > 0) {
      currentIndex3--;
  } else {
      currentIndex3 = totalImages3 - 3;
  }
  updateSliderPosition3();
});


// Gọi hàm hiển thị khi tải trang
updateImageVisibility3();

// -----------------------------------------
const dialogh = document.getElementById('dialog_thongtin');
const openButton = document.querySelector('.thongtin');
if (openButton) {
    openButton.addEventListener('click', () => {
        dialogh.showModal();
    });
}

dialogh.addEventListener('click', (event) => {
    if (event.target === dialogh) {  // Kiểm tra nếu click ngoài form
        dialogh.close();  // Đóng dialog
    }
});

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
//Mở form giới thiệu
const dialogh3 =document.getElementById('dialog-intro');
const openButton3 =document.querySelector('.intro');
if (openButton3) {
    openButton3.addEventListener('click', () => {
        dialogh3.showModal();
    });
}

dialogh3.addEventListener('click', (event) => {
    if (event.target === dialogh3) {  // Kiểm tra nếu click ngoài form
        dialogh3.close();  // Đóng dialog
    }
});
// dialog khóa học
// Lấy tất cả các phần tử hình ảnh trong slider
const images_kh = document.querySelectorAll('.bai_giang img');

// Lấy phần tử dialog
const dialog = document.getElementById('dialog-khoahoc');

// Thêm sự kiện click cho từng ảnh
images_kh.forEach((img) => {
    img.addEventListener('click', function() {
        dialog.showModal(); // Hiển thị dialog
    });
});
// Lấy phần tử dialog
const dialog_kh = document.getElementById('dialog-khoahoc');

// Đóng dialog khi nhấn ra ngoài vùng nội dung của dialog
dialog_kh.addEventListener('click', function(event) {
    const rect = dialog_kh.getBoundingClientRect();
    if (event.clientX < rect.left || event.clientX > rect.right ||
        event.clientY < rect.top || event.clientY > rect.bottom) {
        dialog_kh.close();
    }
});

// Nút "Hủy Bỏ" đóng dialog
const cancelButton = document.querySelector('.form-thong-tin-khoa-hoc button[type="button"]');
cancelButton.addEventListener('click', function() {
    dialog_kh.close();
});

// 
// Lấy tất cả các phần tử hình ảnh tài liệu
const images_tl = document.querySelectorAll('.tai_lieu img, .tai_lieu1 img');
const dialog_tl = document.getElementById('dialog-tailieu');

// Gắn sự kiện click cho mỗi hình ảnh
images_tl.forEach(image => {
    image.addEventListener('click', function() {
        // Hiển thị dialog khi ấn vào ảnh
        dialog_tl.showModal();
    });
});

// Đóng dialog khi nhấn ra ngoài vùng dialog
document.addEventListener('click', function(event) {
    const rect = dialog_tl.getBoundingClientRect();
    // Kiểm tra xem click có nằm ngoài dialog hay không
    if (event.clientX < rect.left || event.clientX > rect.right ||
        event.clientY < rect.top || event.clientY > rect.bottom) {
        dialog_tl.close();
    }
});

// Ngăn chặn việc đóng dialog khi click vào bên trong dialog
dialog_tl.addEventListener('click', function(event) {
    event.stopPropagation();
});
const confirmDialog1 = document.getElementById('dialog-confirm');
const confirmButton = document.querySelector('.confirm-btn');
const dialogForm = document.getElementById('dialog-form-huy');

// Mở dialog xác nhận khi nhấn nút "Đổi Mật Khẩu"
if (confirmButton) {
  confirmButton.addEventListener('click', () => {
    confirmDialog1.showModal();
  });
}

// Đóng dialog xác nhận khi nhấn nút "Hủy"
document.querySelector('.btn_huy').addEventListener('click', function () {
  confirmDialog.close();
});

// Khi nhấn "Xác nhận", submit form
document.querySelector('.btn_xacnhan').addEventListener('click', function () {
  dialogForm.querySelector('form').submit();  // Submit form đổi mật khẩu
});
