<?php
require_once './app/config/database.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('BASE_URL', '/kt_qlnv');
// Lấy tham số từ URL
$controller = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'DefaultController';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null; // Lấy id từ URL (nếu có)

// Kiểm tra file Controller có tồn tại không
$controllerFile = "app/controllers/$controller.php";
if (file_exists($controllerFile)) {
    include $controllerFile;

    if (class_exists($controller)) {
        $obj = new $controller();

        // Kiểm tra method (action) có tồn tại trong class Controller không
        if (method_exists($obj, $action)) {
            if ($id !== null) {
                $obj->$action($id); // Gọi hàm edit() với ID
            } else {
                $obj->$action(); // Gọi hàm không có ID
            }
        } else {
            die("Lỗi: Phương thức '$action' không tồn tại trong $controller.");
        }
    } else {
        die("Lỗi: Class '$controller' không tồn tại.");
    }
} else {
    die("Lỗi: Không tìm thấy file controller '$controllerFile'.");
}

// Khởi tạo đối tượng Database
// $database = new Database();
// $conn = $database->getConnection();

// // Kiểm tra kết nối
// if ($conn) {
//     echo "✅ Kết nối database thành công!";
// } else {
//     echo "❌ Kết nối database thất bại!";
// }
