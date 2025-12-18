// Elements
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const updateProfileBtn = document.getElementById("updateProfile");
const oldPassInput = document.getElementById("old_password");
const newPassInput = document.getElementById("new_password");
const updatePasswordBtn = document.getElementById("updatePassword");
const successMsg = document.getElementById("successMsg");
const errorMsg = document.getElementById("errorMsg");

// Toggle password visibility
function togglePass(id, el) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        el.textContent = "🙈";
    } else {
        input.type = "password";
        el.textContent = "👁";
    }
}

// Show messages
function showMessage(type, message) {
    if (type === "success") {
        successMsg.style.display = "block";
        successMsg.innerText = message;
        errorMsg.style.display = "none";
    } else {
        errorMsg.style.display = "block";
        errorMsg.innerText = message;
        successMsg.style.display = "none";
    }

    setTimeout(() => {
        successMsg.style.display = "none";
        errorMsg.style.display = "none";
    }, 4000);
}

// Update profile
updateProfileBtn.addEventListener("click", () => {
    const name = nameInput.value.trim();
    const email = emailInput.value.trim();

    fetch("api/update_profile.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) showMessage("success", data.message);
        else showMessage("error", data.message);
    });
});

// Update password
updatePasswordBtn.addEventListener("click", () => {
    const old_pass = oldPassInput.value.trim();
    const new_pass = newPassInput.value.trim();

    fetch("api/update_profile.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `old_password=${encodeURIComponent(old_pass)}&new_password=${encodeURIComponent(new_pass)}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            showMessage("success", data.message);
            oldPassInput.value = "";
            newPassInput.value = "";
        } else showMessage("error", data.message);
    });
});
