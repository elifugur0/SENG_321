<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanında ara
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Kullanıcı varsa ve şifre doğruysa
    if ($user && password_verify($password, $user['password'])) {
        // Oturumu başlat
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Panele yönlendir
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Hatalı email veya şifre!'); window.location.href='index.php';</script>";
    }
}
?>