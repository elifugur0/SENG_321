<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Log In - Automated Evaluation System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2 class="login-header">System Login</h2>
    
    <form action="login.php" method="POST">
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email Adresi" required>
        </div>
        
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Şifre" required>
        </div>
        
        <button type="submit" class="btn-primary">Login</button>
    </form>

    <div class="footer-link">
     Don't you have an account?<a href="register.php">Register</a>
    </div>
</div>

</body>
</html>