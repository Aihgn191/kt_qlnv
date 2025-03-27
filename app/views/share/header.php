<?php

if (!isset($_SESSION['user'])) {
    header("Location: index.php?controller=auth&action=login");
    exit();
}
?>


<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/kt_qlnv/staff/index">Quản lý nhân viên</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    Xin chào, <strong><?= $_SESSION['user']['fullname'] ?></strong>
                    (<?= ucfirst($_SESSION['user']['role']) ?>)
                </span>
                <a href="/kt_qlnv/index.php?controller=auth&action=logout" class="btn btn-danger btn-sm">Đăng xuất</a>
            </div>
        </div>
    </nav>
</body>

</html>