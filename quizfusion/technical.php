<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Technical Quiz</title>
<link rel="stylesheet" href="css/technical.css">
</head>
<body>

<div class="quiz-box">
    <h2>Technical Quiz</h2>

    <div class="progress-bar">
        <div class="progress" id="progress"></div>
    </div>

    <div class="timer" id="timer">15s</div>

    <p id="question"></p>

    <form id="quizForm">
        <div class="options" id="options"></div>

        <!-- Buttons in a row -->
        <div class="button-row">
            <button class="btn" type="button" id="hintBtn">Show Hint</button>
            <button class="btn" type="submit" id="nextBtn">Next</button>
        </div>
    </form>

    <p class="hint" id="hint"></p>
    <div class="result" id="result"></div>
</div>

<script src="js/technical.js"></script>
</body>
</html>
