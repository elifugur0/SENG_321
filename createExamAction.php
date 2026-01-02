<?php
session_start();
require_once 'config.php';

// Güvenlik: Sadece giriş yapmış öğretmenler (role = 1) işlem yapabilir
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    // Yetkisiz giriş, panele geri postala
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $subject = $_POST['subject'];
    $date = $_POST['exam_date'];
    $duration = $_POST['duration'];
    
    // Şu an giriş yapmış öğretmenin ID'sini alıyoruz
    $teacherID = $_SESSION['user_id']; 

    try {
        // Veritabanına ekleme sorgusu
        $sql = "INSERT INTO exams (teacherID, subject, exam_date, duration) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teacherID, $subject, $date, $duration]);

        // Başarılıysa uyarı ver ve panele dön
        echo "<script>alert('Sınav başarıyla oluşturuldu!'); window.location.href='dashboard.php';</script>";
    } catch (PDOException $e) {
        // Hata varsa ekrana bas
        die("Veritabanı Hatası: " . $e->getMessage());
    }
} else {
    // Eğer biri formu doldurmadan direkt linkle gelirse panele at
    header("Location: dashboard.php");
    exit;
}
?>