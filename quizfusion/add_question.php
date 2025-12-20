<?php
session_start();
include 'config.php';

/* -----------------------------
   1. CHECK LOGIN & ADMIN ROLE
----------------------------- */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$stmt = $con->prepare("SELECT email, role FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') die("Access denied");

/* -----------------------------
   2. GET QUIZ ID
----------------------------- */
$quiz_id = $_GET['quiz_id'] ?? '';
if ($quiz_id == '') die("Quiz ID missing");

$stmt = $con->prepare("SELECT category FROM quizzes WHERE id=?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$stmt->bind_result($category);
$stmt->fetch();
$stmt->close();

if (!$category) die("Invalid quiz");

/* -----------------------------
   3. HANDLE FORM SUBMIT
----------------------------- */
if (isset($_POST['submit'])) {

    $question = $_POST['question'];
    $option1  = $_POST['option1'];
    $option2  = $_POST['option2'];
    $option3  = $_POST['option3'];
    $option4  = $_POST['option4'];
    $answer   = $_POST['answer'];
    $hint     = $_POST['hint'];

    $image_link = NULL;
    $audio_link = NULL;

    // Pictionary image
    if (strtolower($category) === 'pictionary') {
        $image_link = trim($_POST['image_link']);
    }

    // Audio file upload
    if (strtolower($category) === 'audio') {
        if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/audio/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $filename = time() . '_' . basename($_FILES['audio_file']['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $targetFile)) {
                $audio_link = $targetFile;
            } else {
                die("Failed to upload audio.");
            }
        } else {
            die("Audio file is required.");
        }
    }

    $stmt = $con->prepare("
        INSERT INTO questions 
        (quiz_id, question, option1, option2, option3, option4, answer, hint, image, audio)
        VALUES (?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "isssssssss",
        $quiz_id,
        $question,
        $option1,
        $option2,
        $option3,
        $option4,
        $answer,
        $hint,
        $image_link,
        $audio_link
    );

    $stmt->execute();
    $stmt->close();

    header("Location: manage_questions.php?quiz_id=".$quiz_id);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Question</title>
<style>
body{font-family:Poppins;background:#f4f6fb;padding:20px;}
form{max-width:700px;margin:auto;background:#fff;padding:25px;border-radius:12px;}
input,textarea,select{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:1px solid #ccc;}
label{font-weight:600;}
button{background:#1a73e8;color:#fff;padding:10px;border:none;border-radius:6px;font-weight:600;cursor:pointer;}
button:hover{opacity:.9}
</style>
</head>
<body>

<h2>Add Question – <?= htmlspecialchars($category) ?></h2>

<form method="POST" enctype="multipart/form-data">

<label>Question</label>
<textarea name="question" required></textarea>

<?php if (strtolower($category) === 'pictionary'): ?>
    <label>Image URL</label>
    <input type="url" name="image_link" placeholder="https://upload.wikimedia.org/....jpg" required>
<?php endif; ?>

<?php if (strtolower($category) === 'audio'): ?>
    <label>Upload Audio File</label>
    <input type="file" name="audio_file" accept=".mp3,.wav" required>
<?php endif; ?>

<label>Option 1</label>
<input type="text" name="option1" required>

<label>Option 2</label>
<input type="text" name="option2" required>

<label>Option 3</label>
<input type="text" name="option3" required>

<label>Option 4</label>
<input type="text" name="option4" required>

<label>Correct Answer</label>
<select name="answer" id="answer" required>
    <option value="">-- Select --</option>
</select>

<label>Hint</label>
<textarea name="hint"></textarea>

<button type="submit" name="submit">Add Question</button>

</form>

<script>
function updateAnswer(){
    const sel = document.getElementById('answer');
    sel.innerHTML = '<option value="">-- Select --</option>';
    for(let i=1;i<=4;i++){
        const v = document.querySelector(`input[name=option${i}]`).value;
        if(v){
            const o = document.createElement('option');
            o.value = v;
            o.textContent = v;
            sel.appendChild(o);
        }
    }
}
document.querySelectorAll('input[name^="option"]').forEach(i=>{
    i.addEventListener('input', updateAnswer);
});
</script>

</body>
</html>
