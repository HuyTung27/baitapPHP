function validateForm() {
    var tenSach = document.forms["bookForm"]["tenSach"].value.trim();
    var tacGia = document.forms["bookForm"]["tacGia"].value.trim();
    var nhaXuatBan = document.forms["bookForm"]["nhaXuatBan"].value.trim();
    var namXuatBan = document.forms["bookForm"]["namXuatBan"].value.trim();
    var valid = true;

    if (tenSach === "") {
        var tenSachInput = document.getElementById("tenSach");
        tenSachInput.placeholder = "Tên sách là bắt buộc.";
        tenSachInput.classList.add("error");
        valid = false;
    } else {
        var tenSachInput = document.getElementById("tenSach");
        tenSachInput.placeholder = "";
        tenSachInput.classList.remove("error");
    }

    if (tacGia === "") {
        var tacGiaInput = document.getElementById("tacGia");
        tacGiaInput.placeholder = "Tác giả là bắt buộc.";
        tacGiaInput.classList.add("error");
        valid = false;
    } else {
        var tacGiaInput = document.getElementById("tacGia");
        tacGiaInput.placeholder = "";
        tacGiaInput.classList.remove("error");
    }

    if (nhaXuatBan === "") {
        var nhaXuatBanInput = document.getElementById("nhaXuatBan");
        nhaXuatBanInput.placeholder = "Nhà xuất bản là bắt buộc.";
        nhaXuatBanInput.classList.add("error");
        valid = false;
    } else {
        var nhaXuatBanInput = document.getElementById("nhaXuatBan");
        nhaXuatBanInput.placeholder = "";
        nhaXuatBanInput.classList.remove("error");
    }

    if (namXuatBan === "" || isNaN(namXuatBan) || namXuatBan <= 0) {
        var namXuatBanInput = document.getElementById("namXuatBan");
        namXuatBanInput.placeholder = "Năm xuất bản phải là một số dương.";
        namXuatBanInput.classList.add("error");
        valid = false;
    } else {
        var namXuatBanInput = document.getElementById("namXuatBan");
        namXuatBanInput.placeholder = "";
        namXuatBanInput.classList.remove("error");
    }

    return valid;
}