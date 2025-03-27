<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS & Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php include 'app/views/share/header.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center">Danh sách nhân viên</h2>

        <!-- Chỉ hiển thị nút Thêm nếu user là admin -->
        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
            <div class="text-end mb-3">
                <a href="/kt_qlnv/index.php?controller=staff&action=add" class="btn btn-success">➕ Thêm nhân viên</a>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã NV</th>
                    <th>Tên Nhân Viên</th>
                    <th>Phái</th>
                    <th>Nơi Sinh</th>
                    <th>Phòng Ban</th>
                    <th>Lương</th>
                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                        <th>Hành động</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($staffs)): ?>
                    <?php foreach ($staffs as $staff): ?>
                        <tr>
                            <td><?= htmlspecialchars($staff['Ma_NV']) ?></td>
                            <td><?= htmlspecialchars($staff['Ten_NV']) ?></td>
                            <td class="text-center">
                                <?php
                                $genderImg = ($staff['Phai'] == 'NU') ? 'woman.jpg' : 'man.jpg';
                                ?>
                                <img src="<?= BASE_URL ?>/public/img/<?= $genderImg ?>" alt="<?= $staff['Phai'] ?>" width="30">
                            </td>
                            <td><?= htmlspecialchars($staff['Noi_Sinh']) ?></td>
                            <td><?= htmlspecialchars($staff['Ten_Phong']) ?></td>
                            <td><?= number_format($staff['Luong']) ?></td>

                            <!-- Chỉ admin có quyền Sửa/Xóa -->
                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                <td class="text-center">
                                    <a href="/kt_qlnv/index.php?controller=staff&action=edit&id=<?= $staff['Ma_NV'] ?>" class="btn btn-primary btn-sm">✏ Sửa</a>
                                    <!-- Nút mở modal xác nhận -->
                                    <a href="" class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-id="<?= $staff['Ma_NV'] ?>">
                                        🗑 Xóa
                                    </a>

                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có nhân viên nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == ($_GET['page'] ?? 1)) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa nhân viên này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Xác nhận</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lắng nghe sự kiện khi mở modal
            var deleteModal = document.getElementById("confirmDeleteModal");
            deleteModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget; // Nút mở modal
                var staffId = button.getAttribute("data-id"); // Lấy ID nhân viên từ data-id

                // Cập nhật link xóa vào nút xác nhận
                var confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
                confirmDeleteBtn.href = "/kt_qlnv/index.php?controller=staff&action=delete&id=" + staffId;
            });
        });
    </script>

</body>

</html>