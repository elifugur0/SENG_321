<?php
session_start();
require_once 'config.php';

// Güvenlik: ID gelmediyse geri dön
if (!isset($_SESSION['user_id']) || !isset($_GET['examID'])) {
    header("Location: dashboard.php");
    exit;
}

$examID = $_GET['examID'];

// Sınav bilgilerini çekelim ki ekranda dersin adı yazsın
$stmt = $pdo->prepare("SELECT * FROM exams WHERE examID = ?");
$stmt->execute([$examID]);
$exam = $stmt->fetch();

if (!$exam) { die("Exam not found!"); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam: <?php echo htmlspecialchars($exam['subject']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <span>Subject: <strong><?php echo htmlspecialchars($exam['subject']); ?></strong></span>
                    <span>Duration: <?php echo $exam['duration']; ?> Min.</span>
                </div>
                <div class="card-body">
                    <p class="lead">Please write your answer / code below:</p>
                    
                    <form action="submitExam.php" method="POST">
                        <input type="hidden" name="examID" value="<?php echo $examID; ?>">
                        
                        <div class="mb-3">
                            <textarea name="answer" class="form-control" rows="10" placeholder="Type your answer here..." required></textarea>
                        </div>

                        <div class="alert alert-warning">
                            <small>⚠️ Once you click submit, you cannot change your answer.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg">Submit Exam</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>