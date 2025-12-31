<?php
$host = 'localhost';
$dbname = 'seng321_db';
$username = 'root';
$password = ''; // XAMPP kullanıyorsan genelde boştur. Mac MAMP ise 'root' olabilir.

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>