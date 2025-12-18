const form = document.getElementById("registerForm");
const msgBox = document.getElementById("msgBox");
const captchaQuestion = document.getElementById("captchaQuestion");

const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm_password");

const togglePassword = document.getElementById("togglePassword");
const toggleConfirm = document.getElementById("toggleConfirm");

const strengthBar = document.getElementById("strengthBar");

/* ================= CAPTCHA ================= */
function loadCaptcha() {
    fetch("api/register.php?action=captcha")
        .then(res => res.json())
        .then(data => {
            captchaQuestion.textContent = data.question;
        })
        .catch(() => {
            captchaQuestion.textContent = "Reload page";
        });
}
loadCaptcha();

/* ================= PASSWORD STRENGTH ================= */
password.addEventListener("input", () => {
    let score = 0;
    if (password.value.length >= 6) score++;
    if (/[A-Z]/.test(password.value)) score++;
    if (/[0-9]/.test(password.value)) score++;
    if (/[@#$%^&*!]/.test(password.value)) score++;

    const width = ["0%","25%","50%","75%","100%"];
    const color = ["","bg-danger","bg-warning","bg-info","bg-success"];

    strengthBar.style.width = width[score];
    strengthBar.className = "progress-bar " + (color[score] || "");
});

/* ================= EYE TOGGLES ================= */
togglePassword.onclick = () => {
    password.type = password.type === "password" ? "text" : "password";
};

toggleConfirm.onclick = () => {
    confirmPassword.type =
        confirmPassword.type === "password" ? "text" : "password";
};

/* ================= FORM SUBMIT ================= */
form.addEventListener("submit", async (e) => {
    e.preventDefault();

    msgBox.classList.add("d-none");

    if (password.value !== confirmPassword.value) {
        msgBox.textContent = "Passwords do not match";
        msgBox.className = "alert alert-danger";
        msgBox.classList.remove("d-none");
        return;
    }

    const res = await fetch("api/register.php", {
        method: "POST",
        body: new FormData(form)
    });

    const data = await res.json();

    msgBox.textContent = data.message;
    msgBox.className = "alert alert-" +
        (data.status === "success" ? "success" : "danger");
    msgBox.classList.remove("d-none");

    if (data.status === "success") {
        setTimeout(() => location.href = "login.php", 1500);
    } else {
        loadCaptcha(); // 🔁 reload CAPTCHA on error
    }
});
