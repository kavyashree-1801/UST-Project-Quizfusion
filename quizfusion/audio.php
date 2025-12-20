<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Audio Quiz</title>
<link rel="stylesheet" href="css/audio.css">
</head>
<body>

<div class="quiz-box">
    <h2>🎧 Audio Quiz</h2>

    <div class="progress-bar">
        <div id="progress"></div>
    </div>

    <div id="timer">40s</div>

    <p id="question"></p>

    <audio id="audioPlayer" controls preload="auto"></audio>

    <div id="options"></div>

    <button id="hintBtn" class="btn">Show Hint</button>
    <p id="hint"></p>

    <button id="nextBtn" class="btn">Next</button>

    <div id="result"></div>

    <button id="restartBtn" class="btn" style="display:none;">Restart Quiz</button>
    <a href="categories.php" id="backBtn" class="btn" style="display:none;">Back to Categories</a>
</div>

<script src="js/audio.js"></script>
</body>
</html>
