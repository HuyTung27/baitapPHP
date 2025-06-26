document.addEventListener("DOMContentLoaded", function () {
    // Hiệu ứng cuộn mượt mà khi nhấn vào liên kết
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute("href")).scrollIntoView({
                behavior: "smooth"
            });
        });
    });

    const itemsPerPage = 6; // Số lượng thẻ mỗi trang
    let currentPage = 1; // Trang hiện tại

    const discussionItems = document.querySelectorAll('.discussion-item'); // Lấy tất cả các thẻ thảo luận từ PHP
    const totalPages = Math.ceil(discussionItems.length / itemsPerPage); // Tính tổng số trang

    const renderDiscussions = (page) => {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        // Ẩn tất cả các thẻ thảo luận
        discussionItems.forEach((item, index) => {
            item.style.display = 'none';
            if (index >= start && index < end) {
                item.style.display = 'block'; // Chỉ hiển thị các thẻ thuộc trang hiện tại
            }
        });

        // Cập nhật thông tin trang
        document.getElementById("page-info").innerText = `Trang ${currentPage} / ${totalPages}`;

        // Quản lý trạng thái nút
        document.getElementById("prev").disabled = currentPage === 1;
        document.getElementById("next").disabled = currentPage === totalPages;
    };

    // Sự kiện cho các nút điều hướng
    document.getElementById("prev").addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            renderDiscussions(currentPage);
        }
    });

    document.getElementById("next").addEventListener("click", () => {
        if (currentPage < totalPages) {
            currentPage++;
            renderDiscussions(currentPage);
        }
    });

    // Khởi tạo hiển thị ban đầu
    renderDiscussions(currentPage);
    const replyButtons = document.querySelectorAll('.nut-tra-loi');
    replyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const questionId = this.getAttribute('data-question-id');
            // Xử lý hiển thị form trả lời tại đây, có thể là một dialog hoặc redirect
            alert('Trả lời câu hỏi ID: ' + questionId);
        });
    });
});
