<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: dashboard.php");
    exit;
}

$studentID = $_SESSION['user_id'];
$examID = $_POST['examID'];
$answer = $_POST['answer']; // Öğrencinin yazdığı cevap

// --- AI SIMULATION (YAPAY ZEKA TAKLİDİ) ---
// Rastgele bir puan üret (50 ile 100 arası)
$randomScore = rand(50, 100); 

// Puana göre otomatik feedback oluşturma
if ($randomScore >= 90) {
    $feedback = "Excellent work! Your answer is very detailed and accurate.";
} elseif ($randomScore >= 70) {
    $feedback = "Good job. You covered the main points but missed some details.";
} else {
    $feedback = "You need to study more. Several key concepts are missing.";
}
// --- SİMÜLASYON BİTTİ ---

try {
    // Sonucu veritabanına kaydet
    $sql = "INSERT INTO results (studentID, examID, score, feedback, isReleased) VALUES (?, ?, ?, ?, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentID, $examID, $randomScore, $feedback]);

    // Başarılı uyarısı ver ve panele dön
    echo "<script>
        alert('Exam submitted successfully! Your AI Score: $randomScore');
        window.location.href = 'dashboard.php';
    </script>";

} catch (PDOException $e) {
    die("Error saving result: " . $e->getMessage());
}
?>