<?php
include_once("config.php");

if (isLoggedIn()) {
    header('Location: index.php'); 
    exit();
}

$error = "";

if (isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user']; // di DB namanya id_user, bukan id
            $_SESSION['full_name'] = $user['nama_lengkap']; // di DB namanya nama_lengkap
            $_SESSION['role'] = $user['role'];
            if($user['role'] == 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="assets/css/style_login.css" rel="stylesheet">
</head>
<body>

    <header data-aos="fade-down" data-aos-duration="800">
        <div class="container d-flex justify-content-center justify-content-sm-start">
            <a class="navbar-brand" href="index.php">
                <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
            </a>
        </div>
    </header>

    <main>
        <div class="login-card-container">
            <div class="login-card p-4 p-md-5" data-aos="zoom-in" data-aos-duration="1000">
                
                <div class="card-top-icon">
                    <div class="icon-box">
                        <i class="fa-solid fa-wheat-awn"></i>
                    </div>
                </div>

                <h2>Masuk ke Akun</h2>
                <p class="register-text">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>

                <form action="" method="POST">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                            <span class="input-group-text" id="togglePassword">
                                <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="options-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="#" class="forgot-password">Lupa Password?</a>
                    </div>

                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger" style="border-radius: 10px; font-size: 0.9rem;" role="alert">
                            <?= $error; ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" name="login" class="btn btn-primary w-100 mb-3">Masuk</button>
                    
                </form>

                <div class="divider">atau</div>
                <a href="register.php" class="btn btn-outline-primary w-100 text-decoration-none text-center">Daftar Sekarang</a>       

            </div>
        </div>
    </main>

    <footer data-aos="fade-up" data-aos-delay="500">
        <div class="container">
            <p class="m-0">&copy; 2026 Roti Nusantara. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Inisialisasi AOS
        AOS.init({
            once: true, // Animasi hanya berjalan sekali
        });

        // Script untuk toggle visibilitas password
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle ikon mata
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>