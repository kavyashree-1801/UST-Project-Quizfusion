<?php
session_start();
include 'config.php'; // DB connection ($con)

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user email
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$user_email = $user['email'] ?? "";

// --- USER STATS ---

// 1) Total quizzes attempted
$totalQuizzes = 0;
if ($q = $con->prepare("SELECT COUNT(*) AS total FROM quiz_results WHERE email = ?")) {
    $q->bind_param("s", $user_email);
    $q->execute();
    $q->bind_result($totalQuizzes);
    $q->fetch();
    $q->close();
}

// 2) Top category based on highest average score
$topCategory = "No data";
if ($q = $con->prepare("
    SELECT category, AVG(score/total_questions) AS avg_score
    FROM quiz_results
    WHERE email = ?
    GROUP BY category
    ORDER BY avg_score DESC
    LIMIT 1
")) {
    $q->bind_param("s", $user_email);
    $q->execute();
    $q->bind_result($catName, $avgScore);
    if ($q->fetch()) {
        $topCategory = $catName; // only category name
    }
    $q->close();
}

// 3) Last 5 attempts
$recentAttempts = [];
if ($q = $con->prepare("
    SELECT quiz_id, category, total_questions, score, taken_on 
    FROM quiz_results 
    WHERE email = ? 
    ORDER BY taken_on DESC 
    LIMIT 5
")) {
    $q->bind_param("s", $user_email);
    $q->execute();
    $res = $q->get_result();
    while ($row = $res->fetch_assoc()) {
        $recentAttempts[] = $row;
    }
    $q->close();
}

// 4) Pie chart data
$chartLabels = [];
$chartData = [];
if ($q = $con->prepare("
    SELECT category, COUNT(*) AS cnt 
    FROM quiz_results 
    WHERE email = ? 
    GROUP BY category
")) {
    $q->bind_param("s", $user_email);
    $q->execute();
    $res = $q->get_result();
    while ($r = $res->fetch_assoc()) {
        $chartLabels[] = $r['category'];
        $chartData[] = (int)$r['cnt'];
    }
    $q->close();
}

// 5) Highest score achieved
$highestScore = "—";
if ($q = $con->prepare("SELECT MAX(score/total_questions*100) AS highest FROM quiz_results WHERE email = ?")) {
    $q->bind_param("s", $user_email);
    $q->execute();
    $q->bind_result($highest);
    if ($q->fetch()) {
        $highestScore = round($highest, 2) . "%";
    }
    $q->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | User Report</title>
<style>
:root{
    --brand:#1a73e8;
    --accent:#00bfa5;
    --card:#ffffff;
    --muted:#6b7280;
}
*{box-sizing:border-box}
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: url('https://png.pngtree.com/thumb_back/fh260/background/20220314/pngtree-business-year-end-summary-synthetic-report-image_1048521.jpg') center/cover fixed;
    min-height:100vh;
    color:#111827;
    display:flex;
    flex-direction:column;
}
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 28px;
    background:var(--brand);
    color:white;
    flex-wrap:wrap;
}
.logo{font-weight:700; font-size:20px}
.nav-links{display:flex; gap:20px; list-style:none; padding:0; margin:0;}
.nav-links a{ color:white; text-decoration:none; font-weight:600; }
.nav-links a:hover{ text-decoration:underline; }
.email-text{color:#ffeb3b; font-weight:600;}
.container{
    max-width:1100px;
    width:100%;
    margin:28px auto;
    padding:28px;
    background: rgba(255,255,255,0.9);
    border-radius:10px;
    box-shadow:0 8px 30px rgba(2,6,23,0.08);
    flex:1;
}
h2.section-title{ text-align:center; margin:4px 0 22px 0; color:var(--brand);}
.cards{ display:flex; gap:18px; flex-wrap:wrap; justify-content:center; margin-bottom:22px; }
.card{
    background:var(--card);
    padding:18px 20px;
    border-radius:10px;
    width:200px;
    box-shadow:0 4px 18px rgba(2,6,23,0.06);
    text-align:center;
}
.card h3{ margin:0 0 8px 0; font-size:15px; color:var(--muted); font-weight:600;}
.card p{ margin:0; font-size:26px; font-weight:700; color:var(--brand);}
.flex-row{ display:flex; gap:20px; flex-wrap:wrap; align-items:flex-start; justify-content:space-between; }
.chart-box{ flex:1 1 340px; max-width:460px; background:white; padding:16px; border-radius:10px; box-shadow:0 4px 18px rgba(2,6,23,0.06);}
.table-box{ flex:1 1 520px; background:white; padding:16px; border-radius:10px; box-shadow:0 4px 18px rgba(2,6,23,0.06);}
table{ width:100%; border-collapse:collapse;}
th, td{ text-align:left; padding:10px 12px; font-size:14px; }
th{ background:var(--brand); color:white; font-weight:600; border-bottom:1px solid rgba(0,0,0,0.06);}
tr:nth-child(even){ background:#f8fafc; }
tr:hover{ background:#f1f5f9; }
footer{
    padding:12px; 
    text-align:center; 
    color:#ffffff; 
    background:var(--brand); 
    border-radius:0; 
    margin-top:auto;
}
@media (max-width:820px){
    .cards{ justify-content:stretch; }
    .card{ width:100%; }
    .flex-row{ flex-direction:column; }
    .chart-box, .table-box{ max-width:100%; }
}
</style>
</head>
<body>

<nav>
    <div class="logo">QuizFusion</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <!-- EMAIL + PROFILE BUTTON -->
    <div style="display:flex; align-items:center; gap:12px;">
        <div class="email-text">Hello👋<?php echo htmlspecialchars($user_email); ?></div>

        <a href="profile.php"
           style="
                background:white;
                color:#1a73e8;
                padding:6px 14px;
                border-radius:6px;
                font-weight:600;
                text-decoration:none;
                border:1px solid #fff;
                transition:0.3s;
           "
           onmouseover="this.style.background='#e2e2e2'"
           onmouseout="this.style.background='white'"
        >Profile</a>
    </div>
</nav>

<div class="container">
    <h2 class="section-title">User Report</h2>

    <div class="cards">
        <div class="card">
            <h3>Total Quizzes Attempted</h3>
            <p><?php echo (int)$totalQuizzes; ?></p>
        </div>
        <div class="card">
            <h3>Top Category</h3>
            <p><?php echo htmlspecialchars($topCategory); ?></p>
        </div>
        <div class="card">
            <h3>Latest Score</h3>
            <p><?php
                if (!empty($recentAttempts)) {
                    $percentage = round(($recentAttempts[0]['score'] / $recentAttempts[0]['total_questions']) * 100, 2);
                    echo $percentage . "%";
                } else {
                    echo "—";
                }
            ?></p>
        </div>
        <div class="card">
            <h3>Highest Score Achieved</h3>
            <p><?php echo $highestScore; ?></p>
        </div>
    </div>

    <div class="flex-row">
        <div class="chart-box">
            <h3 style="margin-top:0; margin-bottom:12px;">Category Distribution</h3>
            <canvas id="pieChart" width="400" height="400"></canvas>
        </div>

        <div class="table-box">
            <h3 style="margin-top:0; margin-bottom:12px;">Your Latest Attempts</h3>
            <table>
                <thead>
                    <tr>
                        <th>Quiz ID</th>
                        <th>Category</th>
                        <th>Score</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($recentAttempts)): ?>
                    <?php foreach ($recentAttempts as $r): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($r['quiz_id']); ?></td>
                            <td><?php echo htmlspecialchars($r['category']); ?></td>
                            <td><?php echo htmlspecialchars($r['score']); ?> / <?php echo htmlspecialchars($r['total_questions']); ?></td>
                            <td><?php
                                $dt = $r['taken_on'];
                                echo (!empty($dt) && strtotime($dt) ? date("Y-m-d H:i", strtotime($dt)) : htmlspecialchars($dt));
                            ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center; color:#6b7280;">No quiz attempts yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>© <?php echo date("Y"); ?> QuizFusion. All Rights Reserved.</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = <?php echo json_encode($chartLabels); ?>;
const dataValues = <?php echo json_encode($chartData); ?>;
const ctx = document.getElementById('pieChart').getContext('2d');

if(labels.length > 0 && dataValues.length > 0){
    new Chart(ctx, {
        type:'pie',
        data:{
            labels: labels,
            datasets:[{
                data: dataValues,
                backgroundColor: ['#ff6384','#36a2eb','#ffce56','#4bc0c0','#ab47bc','#26c6da','#ff9f40'],
                borderColor:'#ffffff',
                borderWidth:1
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{
                    position:'bottom',
                    labels:{
                        color:'Black',
                        font:{size:14, family:'Poppins'}
                    }
                }
            }
        }
    });
}
</script>

</body>
</html>
