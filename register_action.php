<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Şifreyi güvenlik için karmaşıklaştırıyoruz (Hashing)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Veritabanına ekleme sorgusu
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $hashed_password, $role]);

        // Başarılıysa giriş sayfasına yönlendir
        echo "<script>alert('Kayıt Başarılı! Giriş yapabilirsiniz.'); window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        // Eğer email zaten varsa hata verir
        echo "Hata: Bu email zaten kayıtlı olabilir. <br>" . $e->getMessage();
    }
}
?>