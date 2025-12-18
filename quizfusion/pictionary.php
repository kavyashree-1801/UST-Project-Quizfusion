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
<title>Pictionary Quiz</title>
<link rel="stylesheet" href="css/pictionary.css">
</head>
<body>

<div class="quiz-box">

<h2>Pictionary Quiz</h2>

<div class="progress-bar"><div id="progress"></div></div>
<div class="timer" id="timer">30s</div>

<div id="question"></div>
<img id="quizImage" style="max-width:100%;border-radius:10px;margin:10px 0;">

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

<script src="js/pictionary.js"></script>
</body>
</html>
