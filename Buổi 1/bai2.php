<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black; 
            padding: 8px;
            text-align: center;     
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            text-align: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #000;
        }
        .pagination a.active {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    $mang = [];
    for($i=1; $i<=100; $i++){
        $mang[] = [
            'stt' => $i,
            'tensach' => "Tên sách $i",
            'ndsach' => "Nội dung $i",
        ];
    }

    $so_sach_tren_trang = 10;

    $tong_sach = count($mang);

    $tong_so_trang = ceil($tong_sach / $so_sach_tren_trang);

    $trang_hien_tai = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($trang_hien_tai < 1) {
        $trang_hien_tai = 1;
    } elseif ($trang_hien_tai > $tong_so_trang) {
        $trang_hien_tai = $tong_so_trang;
    }
    $bat_dau = ($trang_hien_tai - 1) * $so_sach_tren_trang;

    $sach_hien_tai = array_slice($mang, $bat_dau, $so_sach_tren_trang);
    ?>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Nội dung sách</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($sach_hien_tai as $item): ?>
            <tr>
                <td><?= $item['stt'] ?></td>
                <td><?= $item['tensach'] ?></td>
                <td><?= $item['ndsach'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ($trang_hien_tai > 1): ?>
            <a href="?page=<?= $trang_hien_tai - 1 ?>">Trước</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $tong_so_trang; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i == $trang_hien_tai ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($trang_hien_tai < $tong_so_trang): ?>
            <a href="?page=<?= $trang_hien_tai + 1 ?>">Sau</a>
        <?php endif; ?>
    </div>
</body>
</html>
