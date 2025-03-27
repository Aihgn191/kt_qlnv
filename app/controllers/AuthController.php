<?php
require_once './app/models/UserModel.php';

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $userModel = new UserModel();
            $user = $userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Đăng nhập thành công, lưu session
                session_start();
                $_SESSION['user'] = $user;

                // Nếu có chọn "Ghi nhớ đăng nhập"
                if (isset($_POST['remember'])) {
                    setcookie('username', $username, time() + (86400 * 30), "/"); // Lưu cookie 30 ngày
                }

                // Chuyển hướng đến danh sách nhân viên
                header("Location: /kt_qlnv/staff/index");
                exit;
            } else {
                // Sai thông tin đăng nhập
                $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
                include('./app/views/login.php');
            }
        } else {
            include('./app/views/login.php');
        }
    }

    public function logout()
    {
        session_start();
        session_destroy(); // Hủy toàn bộ session
        header("Location: /kt_qlnv/auth/login");
        exit();
    }
}
