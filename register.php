<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - Sistem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2 class="login-header">Yeni Hesap Oluştur</h2>
    
    <form action="register_action.php" method="POST">
        <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Ad Soyad" required>
        </div>

        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email Adresi" required>
        </div>
        
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Şifre" required>
        </div>

        <div class="form-group">
            <select name="role" class="form-control">
                <option value="0">Öğrenci</option>
                <option value="1">Öğretmen</option>
            </select>
        </div>
        
        <button type="submit" class="btn-primary">Kayıt Ol</button>
    </form>

    <div class="footer-link">
        Zaten hesabın var mı? <a href="index.php">Giriş Yap</a>
    </div>
</div>

</body>
</html>