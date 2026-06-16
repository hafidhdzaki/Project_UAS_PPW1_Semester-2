<?php
include_once("config.php");
if (isLoggedIn()) { 
    header('Location: index.php'); 
    exit(); 
}
$errors = [];
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn,
    $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $full_name = mysqli_real_escape_string($conn,
    $_POST['full_name']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    // Validasi input
    if (empty($username)) {
        $errors[] = 'Username tidak boleh kosong';
    }
    if (empty($email)) {
        $errors[] = 'Email tidak boleh kosong';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid';
    }
    if (empty($full_name)) {
        $errors[] = 'Nama lengkap tidak boleh kosong';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter';
    }
    if ($password !== $confirm) {
        $errors[] = 'Konfirmasi password tidak cocok';
    }
    // Cek apakah username/email sudah terdaftar
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $errors[] = 'Username atau email sudah terdaftar';
    }
    if (empty($errors)) {
        // Hash password sebelum disimpan
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, full_name, password) VALUES ('$username','$email','$full_name','$hashed')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Registrasi berhasil! Silakan login.';
        } else {
            $errors[] = 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Roti Nusantara</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link href="assets/css/style_register.css" rel="stylesheet">
</head>
<body>

    <header data-aos="fade-down">
        <div class="container d-flex justify-content-center justify-content-md-start">
            <a class="navbar-brand" href="index.html">
                <i class="fa-solid fa-bread-slice"></i> Roti Nusantara
            </a>
        </div>
    </header>

    <main>
        <div class="container d-flex justify-content-center">
            <div class="signup-card p-4 p-md-5" data-aos="zoom-in" data-aos-duration="1000">
                
                <div class="card-top-icon">
                    <div class="icon-box">
                        <i class="fa-solid fa-wheat-awn"></i>
                    </div>
                </div>

                <h2>Buat Akun Baru</h2>
                <p class="login-prompt">Sudah punya akun? <a href="login.html">Masuk di sini</a></p>

                <form action="proses_daftar.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Buat password (min. 8 karakter)" required>
                            <span class="input-group-text toggle-password" data-target="password">
                                <i class="fa-regular fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
                            <span class="input-group-text toggle-password" data-target="confirm_password">
                                <i class="fa-regular fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Daftar Sekarang <i class="fa-solid fa-chevron-right" style="font-size: 0.8rem;"></i>
                    </button>
                    
                </form>

                <div class="divider">atau</div>

                <a href="login.html" class="btn btn-outline-primary w-100 text-decoration-none">
                    Masuk dengan Akun yang Ada
                </a>

            </div>
        </div>
    </main>

    <footer data-aos="fade-up" data-aos-delay="400">
        <div class="container">
            <p class="m-0">&copy; 2026 Roti Nusantara. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        AOS.init({ once: true });

        // Fitur Toggle Password
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                }
            });
        });
    </script>
</body>
</html>