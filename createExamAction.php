<?php
session_start();
require_once 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $subject = $_POST['subject'];
    $date = $_POST['exam_date'];
    $duration = $_POST['duration'];
    
   
    $teacherID = $_SESSION['user_id']; 

    try {
       
        $sql = "INSERT INTO exams (teacherID, subject, exam_date, duration) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teacherID, $subject, $date, $duration]);

        
        echo "<script>alert('Sınav başarıyla oluşturuldu!'); window.location.href='dashboard.php';</script>";
    } catch (PDOException $e) {
       
        die("Veritabanı Hatası: " . $e->getMessage());
    }
} else {
    
    header("Location: dashboard.php");
    exit;
}
?>
