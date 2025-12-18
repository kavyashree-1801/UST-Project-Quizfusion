let num1, num2;

// CAPTCHA
function generateCaptcha() {
    num1 = Math.floor(Math.random() * 10);
    num2 = Math.floor(Math.random() * 10);
    document.getElementById("captchaQuestion").innerText = `${num1} + ${num2}`;
}
generateCaptcha();

// Password toggle
document.getElementById("togglePassword").onclick = () => {
    const pwd = document.getElementById("password");
    pwd.type = pwd.type === "password" ? "text" : "password";
};

// Bootstrap validation + API call
document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const form = this;

    if (!form.checkValidity()) {
        form.classList.add("was-validated");
        return;
    }

    const captchaInput = parseInt(form.captcha.value);
    if (captchaInput !== num1 + num2) {
        showError("Incorrect CAPTCHA");
        generateCaptcha();
        return;
    }

    fetch("api/login_api.php", {
        method: "POST",
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            window.location.href = data.redirect;
        } else {
            showError(data.message);
            generateCaptcha();
        }
    });
});

function showError(msg) {
    const box = document.getElementById("errorBox");
    box.innerText = msg;
    box.classList.remove("d-none");
}
