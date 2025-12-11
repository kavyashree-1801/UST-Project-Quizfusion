<?php
session_start();
include 'config.php';

// --------------------------------------------
// 1. FETCH USER EMAIL
// --------------------------------------------
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$uid = $_SESSION['user_id'];
$u = mysqli_query($con, "SELECT email FROM users WHERE id='$uid' LIMIT 1");
if (!$u) die("USER QUERY ERROR: " . mysqli_error($con));
$user = mysqli_fetch_assoc($u);
$email = $user['email'];

// --------------------------------------------
// 2. FETCH QUIZ ID FOR CATEGORY 'Math_Logic'
// --------------------------------------------
$category = "Maths & Logic";
$q1 = mysqli_query($con, "SELECT id FROM quizzes WHERE category='$category' LIMIT 1");
if (!$q1) die("QUIZ QUERY ERROR: " . mysqli_error($con));
$row = mysqli_fetch_assoc($q1);
if (!$row) die("<h2>Quiz '$category' not found.</h2>");
$quiz_id = $row['id'];

// --------------------------------------------
// 3. GET QUESTIONS
// --------------------------------------------
$q2 = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id='$quiz_id'");
if (!$q2) die("<h2>ERROR LOADING QUESTIONS: " . mysqli_error($con) . "</h2>");
$all_questions = mysqli_fetch_all($q2, MYSQLI_ASSOC);
if (count($all_questions) === 0) die("<h2>No questions found.</h2>");

// Shuffle questions on first load
if (!isset($_SESSION['math_questions'])) {
    shuffle($all_questions);
    $_SESSION['math_questions'] = $all_questions;
}
$questions = $_SESSION['math_questions'];

// --------------------------------------------
// 4. QUESTION INDEX
// --------------------------------------------
if (!isset($_SESSION['q_index_math'])) {
    $_SESSION['q_index_math'] = 0;
    $_SESSION['score_math'] = 0;
}
$index = $_SESSION['q_index_math'];
$total = count($questions);
$current = $questions[$index];

// --------------------------------------------
// 5. CHECK ANSWER
// --------------------------------------------
$selected_option = null;
$show_next = false;
$quiz_finished = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['option'])) {
    $selected_option = $_POST['option'];
    if ($selected_option == $current['answer']) {
        $_SESSION['score_math']++;
    }
    $show_next = true;
}

// --------------------------------------------
// 6. NEXT QUESTION
// --------------------------------------------
if (isset($_POST['next'])) {
    $_SESSION['q_index_math']++;
    $index = $_SESSION['q_index_math'];
    if ($index >= $total) {
        $score = $_SESSION['score_math'];
        $date = date("Y-m-d H:i:s");
        mysqli_query($con, "
            INSERT INTO quiz_results (quiz_id, email, category, total_questions, score, taken_on)
            VALUES ('$quiz_id', '$email', '$category', '$total', '$score', '$date')
        ");
        $quiz_finished = true;
        unset($_SESSION['q_index_math']);
        unset($_SESSION['score_math']);
        unset($_SESSION['math_questions']);
    } else {
        $current = $questions[$index];
        $selected_option = null;
        $show_next = false;
    }
}

// --------------------------------------------
// 7. RESTART QUIZ
// --------------------------------------------
if (isset($_POST['restart'])) {
    unset($_SESSION['q_index_math']);
    unset($_SESSION['score_math']);
    unset($_SESSION['math_questions']);
    header("Location: math_logic.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Math & Logic Quiz</title>
<style>
body {
    margin:0; padding:0;
    font-family: Arial, sans-serif;
    background: url('https://thumbs.dreamstime.com/b/abstract-brain-background-mathematical-formulas-mind-concept-d-rendering-240219247.jpg') no-repeat center center fixed;
    background-size: cover;
    color:#fff;
    display:flex; justify-content:center; align-items:center;
    min-height:100vh;
}
.quiz-box {
    background: rgba(0,0,0,0.85);
    border-radius: 15px;
    padding: 30px;
    width: 600px;
    max-width: 90%;
    text-align:center;
}
h2 { text-align:center; margin-bottom:20px; }
.question { font-size:20px; margin-bottom:20px; }
.options label { display:block; background:#222; padding:12px; margin:8px 0; border-radius:10px; cursor:pointer; transition:0.3s; }
.options input[type=radio] { margin-right:10px; }
.options label.correct { background:#00ff00; color:#000; }
.options label.incorrect { background:#ff4444; color:#fff; }
.options label:hover { background:#444; }
.btn { display:inline-block; background:#ff9900; color:black; padding:12px 25px; border-radius:8px; font-weight:bold; font-size:16px; border:none; cursor:pointer; margin-top:15px; }
.hint { display:none; margin-top:10px; background:#444; padding:10px; border-radius:8px; font-size:16px; color:#ffdd00; font-weight:bold; }
.progress-bar { width:100%; background:#333; border-radius:20px; overflow:hidden; height:20px; margin-bottom:20px; }
.progress { height:100%; background:#ff9900; width:<?= (($index)/$total)*100 ?>%; transition: width 0.5s; }
.timer { font-size:18px; margin-bottom:15px; text-align:center; }
.result { font-size:22px; margin-top:20px; color:#ffdd00; text-align:center; }
</style>
</head>
<body>

<div class="quiz-box">
<h2>Math & Logic Quiz</h2>

<?php if($quiz_finished): ?>
<div class="result">
    <p>🎉 Quiz Completed!</p>
    <p>Your Score: <strong><?= $score ?> / <?= $total ?></strong></p>
</div>
<form method="POST">
    <button name="restart" class="btn">Restart Quiz</button>
    <a href="categories.php" class="btn">Back to Categories</a>
</form>
<?php else: ?>

<div class="progress-bar"><div class="progress" id="progress"></div></div>
<div class="timer" id="timer">40s</div>
<div class="question"><?= ($index+1) ?>. <?= $current['question'] ?></div>

<button type="button" class="btn" id="showHintBtn">Show Hint</button>
<p class="hint" id="hintText"><?= $current['hint'] ?? "No hint available." ?></p>

<form method="POST" id="quizForm">
<div class="options">
<?php
foreach(['option1','option2','option3','option4'] as $opt){
    $value = $current[$opt];
    $class = '';
    if($selected_option){
        if($value == $current['answer']) $class='correct';
        elseif($value == $selected_option) $class='incorrect';
    }
    echo "<label class='$class'><input type='radio' name='option' value='$value' ".($selected_option ? "disabled" : "")."> $value</label>";
}
?>
</div>

<?php if($show_next): ?>
<button type="submit" name="next" class="btn">Next</button>
<?php else: ?>
<button type="submit" class="btn">Submit</button>
<?php endif; ?>
</form>

<?php endif; ?>
</div>

<script>
document.getElementById('showHintBtn').addEventListener('click', function(){
    document.getElementById('hintText').style.display='block';
    this.style.display='none';
});

// Timer
let timeLeft = 40;
const timerEl = document.getElementById('timer');
const form = document.getElementById('quizForm');

if(form && !<?= $show_next ? 'true':'false' ?>){
    const countdown = setInterval(() => {
        if(timeLeft <= 0){
            clearInterval(countdown);
            form.submit();
        } else {
            timerEl.innerText = timeLeft + "s";
        }
        timeLeft--;
    },1000);
}
</script>

</body>
</html>
