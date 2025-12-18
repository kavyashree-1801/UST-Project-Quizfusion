<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>General Knowledge Quiz</title>
<link rel="stylesheet" href="css/gk.css">
</head>
<body>

<div class="quiz-box">
    <h2>General Knowledge Quiz</h2>

    <div class="progress-bar">
        <div class="progress" id="progress"></div>
    </div>

    <div class="timer" id="timer">15s</div>

    <p id="question"></p>

    <form id="quizForm">
        <div class="options" id="options"></div>

        <!-- Wrap buttons in a row -->
        <div class="button-row">
            <button class="btn" type="button" id="hintBtn">Show Hint</button>
            <button class="btn" type="submit" id="nextBtn">Next</button>
        </div>
    </form>

    <p class="hint" id="hint"></p>
    <div class="result" id="result"></div>
</div>

<script src="js/gk.js"></script>
</body>
</html>
