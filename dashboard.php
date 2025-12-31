<?php
session_start();

// Giriş yapılmamışsa giriş sayfasına at
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Panel - Hoşgeldiniz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark p-3">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Sınav Sistemi</span>
        <a href="logout.php" class="btn btn-danger btn-sm">Çıkış Yap</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="card">
        <div class="card-body text-center">
            <h3>Hoşgeldin, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h3>
            <p class="lead">
                Şu an sisteme 
                <strong><?php echo $_SESSION['role'] == 1 ? 'Öğretmen' : 'Öğrenci'; ?></strong> 
                olarak giriş yaptın.
            </p>
            
            <hr>
            
            <?php if ($_SESSION['role'] == 1): ?>
                <button class="btn btn-success btn-lg">Sınav Oluştur</button>
                <button class="btn btn-info btn-lg">Sonuçları Gör</button>
            <?php else: ?>
                <button class="btn btn-primary btn-lg">Sınavlara Katıl</button>
                <button class="btn btn-warning btn-lg">Notlarımı Gör</button>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>