<?php
session_start();
include 'config.php';

// --------------------------
// 1. CHECK ADMIN LOGIN
// --------------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email, role FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') die("Access denied. Admins only.");

// --------------------------
// 2. GET QUESTION ID
// --------------------------
$question_id = intval($_GET['id']);
$q_res = mysqli_query($con, "SELECT * FROM questions WHERE id='$question_id'");
if (!$q_res || mysqli_num_rows($q_res) == 0) {
    die("Question not found.");
}
$question = mysqli_fetch_assoc($q_res);

// Get quiz_id & category
$quiz_id = $question['quiz_id'];
$qcat_res = mysqli_query($con, "SELECT category FROM quizzes WHERE id='$quiz_id'");
$quiz_row = mysqli_fetch_assoc($qcat_res);
$category = $quiz_row['category'];

// --------------------------
// 3. HANDLE FORM SUBMISSION
// --------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question'] ?? '';
    $option1 = $_POST['option1'] ?? '';
    $option2 = $_POST['option2'] ?? '';
    $option3 = $_POST['option3'] ?? '';
    $option4 = $_POST['option4'] ?? '';
    $answer = $_POST['answer'] ?? '';
    $hint = $_POST['hint'] ?? '';
    $link = $_POST['link'] ?? ''; // For audio or pictionary link

    // Update query
    if (strtolower($category) == 'audio') {
        $stmt = $con->prepare("
            UPDATE questions SET 
                question=?, option1=?, option2=?, option3=?, option4=?, answer=?, hint=?, audio=?
            WHERE id=?
        ");
    } elseif (strtolower($category) == 'pictionary') {
        $stmt = $con->prepare("
            UPDATE questions SET 
                question=?, option1=?, option2=?, option3=?, option4=?, answer=?, hint=?, image=?
            WHERE id=?
        ");
    } else {
        $stmt = $con->prepare("
            UPDATE questions SET 
                question=?, option1=?, option2=?, option3=?, option4=?, answer=?, hint=?
            WHERE id=?
        ");
        $stmt->bind_param("sssssssi", $question_text, $option1, $option2, $option3, $option4, $answer, $hint, $question_id);
        $stmt->execute();
        $stmt->close();
        header("Location: manage_questions.php?quiz_id=" . $quiz_id);
        exit;
    }

    $stmt->bind_param("ssssssssi", $question_text, $option1, $option2, $option3, $option4, $answer, $hint, $link, $question_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_questions.php?quiz_id=" . $quiz_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Question | Admin</title>
<style>
body { font-family:'Poppins',sans-serif; margin:0; padding:0; background:#f5f7ff; display:flex; flex-direction:column; min-height:100vh; }
.main-container{flex:1; padding:36px 28px; max-width:800px; margin:28px auto; background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15);}
h2{margin-bottom:20px;}
form label{display:block; margin-top:12px; font-weight:600;}
form input[type=text], form select, form textarea{width:100%; padding:8px; margin-top:4px; border-radius:6px; border:1px solid #ccc;}
form button{margin-top:20px; padding:10px 20px; background:#1a73e8; color:#fff; border:none; border-radius:6px; cursor:pointer;}
form button:hover{background:#0c59c3;}
footer{background:#1a73e8; color:white; text-align:center; padding:12px;}
</style>
</head>
<body>

<div class="main-container">
<h2>Edit Question (<?= htmlspecialchars($category) ?>)</h2>

<form method="POST">
    <label>Question</label>
    <textarea name="question" required><?= htmlspecialchars($question['question']) ?></textarea>

    <label>Option 1</label>
    <input type="text" name="option1" required value="<?= htmlspecialchars($question['option1']) ?>">
    <label>Option 2</label>
    <input type="text" name="option2" required value="<?= htmlspecialchars($question['option2']) ?>">
    <label>Option 3</label>
    <input type="text" name="option3" required value="<?= htmlspecialchars($question['option3']) ?>">
    <label>Option 4</label>
    <input type="text" name="option4" required value="<?= htmlspecialchars($question['option4']) ?>">

    <label>Answer</label>
    <select name="answer" required>
        <option value="">--Select Correct Answer--</option>
        <?php for($i=1;$i<=4;$i++):
            $opt = htmlspecialchars($question['option'.$i]);
            $selected = $question['answer']==$question['option'.$i] ? 'selected' : '';
        ?>
        <option value="<?= $opt ?>" <?= $selected ?>><?= $opt ?></option>
        <?php endfor; ?>
    </select>

    <label>Hint</label>
    <textarea name="hint"><?= htmlspecialchars($question['hint']) ?></textarea>

    <?php if(strtolower($category)=='audio'): ?>
        <label>Audio Link (MP3 URL)</label>
        <input type="text" name="link" value="<?= htmlspecialchars($question['audio']) ?>">
    <?php elseif(strtolower($category)=='pictionary'): ?>
        <label>Image Link (JPEG/PNG URL)</label>
        <input type="text" name="link" value="<?= htmlspecialchars($question['image']) ?>">
    <?php endif; ?>

    <button type="submit">Update Question</button>
</form>
</div>

<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
