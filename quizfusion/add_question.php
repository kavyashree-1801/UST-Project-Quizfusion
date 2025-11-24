<?php
session_start();
include 'config.php';

// Check admin login
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

if($role !== 'admin') die("Access denied.");

// Get category from URL
$category = $_GET['category'] ?? '';
if($category == '') die("Category not specified.");

// Handle form submission
if(isset($_POST['submit'])) {

    $question = $_POST['question'] ?? '';
    $option1 = $_POST['option1'] ?? '';
    $option2 = $_POST['option2'] ?? '';
    $option3 = $_POST['option3'] ?? '';
    $option4 = $_POST['option4'] ?? '';
    $answer  = $_POST['answer'] ?? '';
    $hint    = $_POST['hint'] ?? '';

    // Get quiz_id for the category
    $q = mysqli_query($con, "SELECT id FROM quizzes WHERE category='$category' LIMIT 1");
    $row = mysqli_fetch_assoc($q);
    $quiz_id = $row['id'];

    $image_file_name = NULL;
    $audio_file_name = NULL;

    // Pictionary: handle image upload
    if(strtolower($category) == 'pictionary' && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/images/';
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_file_name = uniqid('img_') . '.' . $ext;
        move_uploaded_file($tmp_name, $upload_dir . $image_file_name);
    }

    // Audio: use audio link instead of file
    if(strtolower($category) == 'audio' && !empty($_POST['audio_link'])) {
        $audio_file_name = trim($_POST['audio_link']); // store the URL directly
    }

    // Insert into questions table
    $stmt = $con->prepare("INSERT INTO questions (quiz_id, question, option1, option2, option3, option4, answer, hint, image, audio) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssssss", $quiz_id, $question, $option1, $option2, $option3, $option4, $answer, $hint, $image_file_name, $audio_file_name);
    $stmt->execute();

    // Redirect back to manage_questions
    header("Location: manage_questions.php?category=" . urlencode($category));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Question | <?= htmlspecialchars($category) ?></title>
<style>
body{font-family:'Poppins',sans-serif; background:#f5f7ff; padding:20px;}
form{max-width:700px; margin:auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
input, textarea, select{width:100%; padding:10px; margin:8px 0; border-radius:5px; border:1px solid #ccc;}
label{font-weight:600;}
.btn{background:#1a73e8; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer;}
.btn:hover{background:#0c59c3;}
</style>
</head>
<body>

<h2>Add Question for <?= htmlspecialchars($category) ?> Category</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Question</label>
    <textarea name="question" required></textarea>

    <?php if(strtolower($category) == 'pictionary'): ?>
        <label>Image File (PNG/JPG)</label>
        <input type="file" name="image" accept="image/*" required>
    <?php elseif(strtolower($category) == 'audio'): ?>
        <label>Audio Link (MP3 URL)</label>
        <input type="url" name="audio_link" placeholder="https://example.com/audio.mp3" required>
    <?php endif; ?>

    <label>Option 1</label>
    <input type="text" name="option1" required>
    <label>Option 2</label>
    <input type="text" name="option2" required>
    <label>Option 3</label>
    <input type="text" name="option3" required>
    <label>Option 4</label>
    <input type="text" name="option4" required>

    <label>Answer</label>
    <select name="answer" id="answer" required>
        <option value="">--Select Correct Answer--</option>
    </select>

    <label>Hint</label>
    <textarea name="hint"></textarea>

    <button type="submit" name="submit" class="btn">Add Question</button>
</form>

<script>
// Dynamically update answer options based on text fields
function updateAnswerOptions() {
    const answerSelect = document.getElementById('answer');
    answerSelect.innerHTML = '<option value="">--Select Correct Answer--</option>';
    for(let i=1;i<=4;i++){
        const val = document.querySelector('input[name="option'+i+'"]').value;
        if(val.trim() !== ''){
            const opt = document.createElement('option');
            opt.value = val;
            opt.textContent = val;
            answerSelect.appendChild(opt);
        }
    }
}

document.querySelectorAll('input[name^="option"]').forEach(input => {
    input.addEventListener('input', updateAnswerOptions);
});
</script>

</body>
</html>
