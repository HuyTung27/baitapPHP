document.addEventListener("DOMContentLoaded", function () {
  // Hàm mở dialog
  function showDialog(dialogId) {
    const dialog = document.getElementById(dialogId);
    if (dialog) {
      dialog.showModal();  // Hiển thị dialog
    }
  }

  // Hàm đóng dialog
  function closeDialog(dialogId) {
    const dialog = document.getElementById(dialogId);
    if (dialog) {
      dialog.close();  // Đóng dialog
    }
  }


  // Hiệu ứng cuộn mượt mà khi nhấn vào liên kết
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth"
      });
    });
  });

  // Thêm hiệu ứng hover vào nút thêm, xóa, sửa
  const buttons = document.querySelectorAll(".nut");
  buttons.forEach(button => {
    button.addEventListener("mouseenter", () => {
      button.style.transform = "scale(1.1)";
    });

    button.addEventListener("mouseleave", () => {
      button.style.transform = "scale(1)";
    });
  });

  // Hiển thị thông báo pop-up khi nhấn nút "Đăng Thông Báo"
  const notifyButton = document.querySelector(".noi-dung-thong-bao button");
  if (notifyButton) {
    notifyButton.addEventListener("click", () => {
      alert("Thông báo đã được đăng thành công!");
    });
  }

  // Mở và đóng dialog cho các nút thêm, xóa, sửa sinh viên và giảng viên
  const dialogs = [
    { buttonClass: '.tsv', dialogId: 'dialog-form-tsv' },
    { buttonClass: '.tgv', dialogId: 'dialog-form-tgv' },
    { buttonClass: '.xsv', dialogId: 'dialog-form-xsv' },
    { buttonClass: '.xgv', dialogId: 'dialog-form-xgv' },
    { buttonClass: '.ssv', dialogId: 'dialog-form-ssv' },
    { buttonClass: '.sgv', dialogId: 'dialog-form-sgv' },
    { buttonClass: '.tkh', dialogId: 'dialog-form-tkh' },
    { buttonClass: '.ksv', dialogId: 'dialog-form-ksv' },
    { buttonClass: '.kkh', dialogId: 'dialog-form-kkh' },
    { buttonClass: '.ktc', dialogId: 'dialog-form-ktc' },
  ];

  dialogs.forEach(({ buttonClass, dialogId }) => {
    const button = document.querySelector(buttonClass);
    if (button) {
      button.addEventListener('click', () => showDialog(dialogId)); // Mở dialog

      const dialog = document.getElementById(dialogId);
      dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {  // Kiểm tra nếu click ngoài form
          closeDialog(dialogId);  // Đóng dialog
        }
      });
    }
  });
});


// menu
document.addEventListener("DOMContentLoaded", function () {
  const menuIcon = document.querySelector('.menu-icon');
  const container = document.getElementById('container');
  const closeButton = document.querySelector('.close-button');

  // Hiển thị hoặc ẩn container khi nhấn vào icon menu
  menuIcon.addEventListener('click', function () {
    container.style.display = container.style.display === 'block' ? 'none' : 'block';
  });

  // Đóng container khi nhấn vào nút đóng
  closeButton.addEventListener('click', function () {
    container.style.display = 'none';
  });


  // Đóng dialog thông tin khi nhấn nút "Hủy"
  const cancelButton = document.querySelector('button[value="cancel"]');
  if (cancelButton) {
    cancelButton.addEventListener('click', (event) => {
      event.preventDefault(); // Ngăn chặn hành động mặc định của nút
      dialogh.close(); // Đóng dialog
      container.style.display = 'none'; // Ẩn container
    });
  }

  // Mở dialog đổi mật khẩu
  const dialogh2 = document.getElementById('dialog-form-huy');
  const openButton2 = document.querySelector('.doimk');
  if (openButton2) {
    openButton2.addEventListener('click', () => {
      dialogh2.showModal();
    });
  }

  // Đóng dialog đổi mật khẩu khi nhấn ra ngoài
  dialogh2.addEventListener('click', (event) => {
    if (event.target === dialogh2) {
      dialogh2.close();
    }
  });

  // Mở dialog xác nhận khi nhấn nút "Đổi Mật Khẩu"
  const confirmDialog = document.getElementById('dialog-confirm');
  const confirmButton = document.querySelector('.confirm-btn');
  if (confirmButton) {
    confirmButton.addEventListener('click', () => {
      confirmDialog.showModal();
    });
  }

  // Đóng dialog xác nhận khi nhấn ra ngoài
  confirmDialog.addEventListener('click', (event) => {
    if (event.target === confirmDialog) {
      confirmDialog.close();
    }
  });

  // Khi nhấn "Xác nhận", submit form đổi mật khẩu
document.querySelector('.btn_xacnhan').addEventListener('click', function () {
  document.querySelector('.form-dang-ky').submit();
});

// Đóng dialog xác nhận khi nhấn "Hủy"
document.querySelector('.btn_huy').addEventListener('click', function () {
  document.getElementById('dialog-confirm').close();
});
document.querySelector('.btn_xacnhan').addEventListener('click', function () {
  console.log('Form submitted!');
  document.querySelector('.form-dang-ky').submit();
});
});






