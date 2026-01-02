<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$userID = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

// --- IF TEACHER ---
if ($userRole == 1) {
    // Fetch all exams
    $stmt = $pdo->query("SELECT * FROM exams ORDER BY exam_date DESC");
    $exams = $stmt->fetchAll();
} 
// --- IF STUDENT ---
else {
    // 1. Available Exams (Not taken yet)
    $sqlNotTaken = "SELECT * FROM exams 
                    WHERE examID NOT IN (SELECT examID FROM results WHERE studentID = ?)";
    $stmt1 = $pdo->prepare($sqlNotTaken);
    $stmt1->execute([$userID]);
    $availableExams = $stmt1->fetchAll();

    // 2. Past Exams (Taken)
    $sqlTaken = "SELECT e.*, r.score, r.feedback, r.resultID 
                 FROM exams e 
                 JOIN results r ON e.examID = r.examID 
                 WHERE r.studentID = ?";
    $stmt2 = $pdo->prepare($sqlTaken);
    $stmt2->execute([$userID]);
    $pastExams = $stmt2->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Exam System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark p-3">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Exam System</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white">Hello, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h3>Welcome!</h3>
            <p class="mb-0">Role: <strong><?php echo $userRole == 1 ? 'Teacher' : 'Student'; ?></strong></p>
            <?php if ($userRole == 1): ?>
                <a href="createExam.php" class="btn btn-success mt-3">+ Create New Exam</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($userRole == 1): ?>
        <h4>All Exams</h4>
        <table class="table table-bordered bg-white">
            <thead class="table-dark">
                <tr><th>Subject</th><th>Date</th><th>Duration</th></tr>
            </thead>
            <tbody>
                <?php foreach ($exams as $exam): ?>
                    <tr>
                        <td><?php echo $exam['subject']; ?></td>
                        <td><?php echo date("d.m.Y H:i", strtotime($exam['exam_date'])); ?></td>
                        <td><?php echo $exam['duration']; ?> Min.</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <h4 class="text-primary">Available Exams</h4>
        <div class="table-responsive mb-5">
            <table class="table table-hover bg-white shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($availableExams) > 0): ?>
                        <?php foreach ($availableExams as $exam): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($exam['subject']); ?></td>
                                <td><?php echo date("d.m.Y H:i", strtotime($exam['exam_date'])); ?></td>
                                <td><?php echo $exam['duration']; ?> Min.</td>
                                <td>
                                    <a href="takeExam.php?examID=<?php echo $exam['examID']; ?>" class="btn btn-primary btn-sm">Start Exam</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted">No exams available at the moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h4 class="text-success">Completed Exams & Reports</h4>
        <div class="table-responsive">
            <table class="table table-hover bg-white shadow-sm">
                <thead class="table-success">
                    <tr>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Report</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pastExams) > 0): ?>
                        <?php foreach ($pastExams as $exam): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($exam['subject']); ?></td>
                                <td><?php echo date("d.m.Y H:i", strtotime($exam['exam_date'])); ?></td>
                                <td><strong><?php echo $exam['score']; ?></strong></td>
                                <td>
                                    <a href="downloadReport.php?resultID=<?php echo $exam['resultID']; ?>" class="btn btn-warning btn-sm">
                                        📄 Download Report
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted">You haven't completed any exams yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</div>
</body>
</html>