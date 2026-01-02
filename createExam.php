<?php
session_start();
// Öğretmen değilse (role != 1) bu sayfaya giremesin, panele atılsın
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Create New Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4>Create New Exam</h4>
                </div>
                <div class="card-body">
                    <form action="createExamAction.php" method="POST">
                        <div class="mb-3">
                            <label>Subject/ Class Name</label>
                            <input type="text" name="subject" class="form-control" placeholder="EX: Calculus 101 - Midterm" required>
                        </div>

                        <div class="mb-3">
                            <label>Exam Date</label>
                            <input type="datetime-local" name="exam_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Time (Minutes)</label>
                            <input type="number" name="duration" class="form-control" value="60" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Save Exam</button>
                        <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>