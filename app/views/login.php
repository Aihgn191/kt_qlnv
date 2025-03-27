<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="/kt_qlnv/public/css/style.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Đăng nhập</h2>

            <!-- Hiển thị lỗi nếu có -->
            <?php if (!empty($error)) : ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>


            <form method="POST" action="/kt_qlnv/index.php?controller=auth&action=login" onsubmit="return validateForm();">
                <!-- Username Input -->
                <div class="input-box">
                    <input type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>

                <!-- Password Input -->
                <div class="input-box">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>

                <!-- Options: Remember Me -->
                <div class="options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-btn">Đăng nhập</button>

                <!-- Register Text -->

            </form>
        </div>
    </div>
</body>

</html>