<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Maths & Logic Quiz</title>
<link rel="stylesheet" href="css/math_logic.css">
</head>
<body>

<div class="quiz-box">

<h2>Maths & Logic Quiz</h2>

<div class="progress-bar">
    <div id="progress"></div>
</div>

<div class="timer" id="timer">40s</div>

<div id="question" class="question"></div>
<div id="options"></div>

<button class="btn" id="hintBtn">Show Hint</button>
<p class="hint" id="hint"></p>

<button class="btn" id="nextBtn">Next</button>

<div id="result"></div>

<div class="center">
    <button class="btn" id="restartBtn" style="display:none;">Restart Quiz</button>
    <a href="categories.php" class="btn" id="backBtn" style="display:none;">Back to Categories</a>
</div>

</div>

<script src="js/math_logic.js"></script>
</body>
</html>
