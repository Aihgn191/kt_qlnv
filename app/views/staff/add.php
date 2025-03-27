<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'app/views/share/header.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center">Thêm Nhân Viên</h2>

        <form action="/kt_qlnv/staff/store" method="POST">
            <div class="mb-3">
                <label for="ten_nv" class="form-label">Tên Nhân Viên</label>
                <input type="text" class="form-control" id="ten_nv" name="ten_nv" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Giới Tính</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="phai" id="nam" value="NAM" checked>
                    <label class="form-check-label" for="nam">Nam</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="phai" id="nu" value="NU">
                    <label class="form-check-label" for="nu">Nữ</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="noi_sinh" class="form-label">Nơi Sinh</label>
                <input type="text" class="form-control" id="noi_sinh" name="noi_sinh" required>
            </div>

            <div class="mb-3">
                <label for="ma_phong" class="form-label">Phòng Ban</label>
                <select class="form-select" id="ma_phong" name="ma_phong" required>
                    <option value="" disabled selected>Chọn phòng ban</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['Ma_Phong'] ?>"><?= $dept['Ten_Phong'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="luong" class="form-label">Lương</label>
                <input type="number" class="form-control" id="luong" name="luong" required>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
            <a href="/kt_qlnv/staff/index" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>