<?php
require_once('app/config/database.php');
require_once('app/models/StaffModel.php');
require_once './app/models/DepartmentModel.php';
class StaffController
{
    private $model;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->model = new StaffModel($this->db);
    }

    // public function index()
    // {
    //     $students = $this->model->getAllStaffs();
    //     include('app/views/student/index.php');
    // }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /kt_qlnv/auth/login");
            exit;
        }

        // Số nhân viên mỗi trang
        $limit = 5;

        // Xác định trang hiện tại
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        // Lấy danh sách nhân viên theo trang
        $staffs = $this->model->getStaffsByPage($page, $limit);

        // Tính tổng số trang
        $totalPages = $this->model->getTotalPages($limit);

        include 'app/views/staff/index.php';
    }


    public function add()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: /kt_qlnv/staff/index");
            exit;
        }
        $departmentModel = new DepartmentModel();
        $departments = $departmentModel->getAllDepartments();
        include 'app/views/staff/add.php';
    }

    // Xử lý thêm nhân viên
    public function store()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: /kt_qlnv/staff/index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ten_nv' => $_POST['ten_nv'],
                'phai' => $_POST['phai'],
                'noi_sinh' => $_POST['noi_sinh'],
                'ma_phong' => $_POST['ma_phong'],
                'luong' => $_POST['luong']
            ];

            $this->model->addStaff($data);
            header("Location: /kt_qlnv/staff/index");
            exit;
        }
    }

    // Hiển thị trang sửa nhân viên
    public function edit()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: /kt_qlnv/staff/index");
            exit;
        }

        if (!isset($_GET['id'])) {
            die("Thiếu ID nhân viên.");
        }

        $id = $_GET['id'];
        $staff = $this->model->getStaffById($id);
        $departmentModel = new DepartmentModel();
        $departments = $departmentModel->getAllDepartments(); // Lấy danh sách phòng ban
        if (!$staff) {
            die("Nhân viên không tồn tại.");
        }

        include 'app/views/staff/edit.php';
    }



    // Xử lý cập nhật nhân viên
    public function update()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: /kt_qlnv/staff/index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['ma_nv'];
            $data = [
                'ten_nv' => $_POST['ten_nv'],
                'phai' => $_POST['phai'],
                'noi_sinh' => $_POST['noi_sinh'],
                'ma_phong' => $_POST['ma_phong'],
                'luong' => $_POST['luong']
            ];

            $this->model->updateStaff($id, $data);
            header("Location: /kt_qlnv/staff/index");
            exit;
        }
    }

    // Xóa nhân viên
    public function delete()
    {
        session_start();
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: /kt_qlnv/staff/index");
            exit;
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->model->deleteStaff($id);
        }

        header("Location: /kt_qlnv/staff/index");
        exit;
    }
}
