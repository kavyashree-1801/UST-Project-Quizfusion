function togglePassword(id){
    const pwd = document.getElementById(id);
    pwd.type = pwd.type === "password" ? "text" : "password";
}

const errorBox = document.getElementById("error");
const successBox = document.getElementById("success");

function showError(msg) {
    errorBox.style.display = "block";
    successBox.style.display = "none";
    errorBox.innerText = msg;
}

function showSuccess(msg) {
    successBox.style.display = "block";
    errorBox.style.display = "none";
    successBox.innerText = msg;
}

function getQuestion() {
    errorBox.style.display = "none";
    successBox.style.display = "none";

    const email = document.getElementById("email").value.trim();
    if (!email) {
        showError("Email required");
        return;
    }

    fetch("api/forgot_passwords.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "step=1&email=" + encodeURIComponent(email)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById("step1").style.display = "none";
            document.getElementById("step2").style.display = "block";
            document.getElementById("question").innerText = data.question;
        } else {
            showError(data.error);
        }
    })
    .catch(() => showError("Server error"));
}

function resetPassword() {
    errorBox.style.display = "none";
    successBox.style.display = "none";

    const email = document.getElementById("email").value.trim();
    const answer = document.getElementById("answer").value.trim();
    const newPassword = document.getElementById("newPassword").value.trim();

    if (!answer || !newPassword) {
        showError("All fields required");
        return;
    }

    fetch("api/forgot_passwords.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body:
            "step=2" +
            "&email=" + encodeURIComponent(email) +
            "&answer=" + encodeURIComponent(answer) +
            "&newPassword=" + encodeURIComponent(newPassword)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showSuccess("Password reset successfully! Redirecting...");
            setTimeout(() => window.location.href = "login.php", 2000);
        } else {
            showError(data.error);
        }
    })
    .catch(() => showError("Server error"));
}
