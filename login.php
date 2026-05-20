<?php
session_start();
// Jika sudah login, langsung lempar ke index.php
if (isset($_SESSION['role'])) { 
    header("Location: index.php"); 
    exit; 
}

$error = "";
if (isset($_POST['login'])) {
    if ($_POST['user'] == "admin_dkv" && $_POST['pass'] == "admin123") {
        $_SESSION['role'] = "Admin";
        header("Location: index.php");
        exit;
    } elseif ($_POST['user'] == "siswa_dkv" && $_POST['pass'] == "siswa123") {
        $_SESSION['role'] = "Siswa";
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah, cuy! ❌";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK Diponegoro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body-login">

<div class="login-container">
    <h2>Login Absensi</h2>
    <p class="subtitle">Sistem Informasi Absensi 12 DKV</p>
    
    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="user">Username</label>
            <input type="text" id="user" name="user" class="input-box" placeholder="Masukkan username Anda" required autocomplete="off">
        </div>
        
        <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" id="pass" name="pass" class="input-box" placeholder="Masukkan password Anda" required>
        </div>
        
        <button type="submit" name="login" class="btn-submit">Masuk Sistem</button>
    </form>
    
    <div class="footer-text">SMK Diponegoro &copy; 2026</div>
</div>

</body>
</html>