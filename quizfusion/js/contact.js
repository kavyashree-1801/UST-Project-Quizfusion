document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("contactForm");
    const msgBox = document.getElementById("msgBox");

    // Prevent errors on other pages
    if (!form || !msgBox) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const message = document.getElementById("message").value.trim();

        if (name === "" || message === "") {
            msgBox.className = "alert alert-danger";
            msgBox.textContent = "All fields are required";
            msgBox.classList.remove("d-none");
            return;
        }

        const formData = new FormData(form);

        fetch("api/contact_submit.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            msgBox.classList.remove("d-none");
            msgBox.className =
                data.status === "success"
                ? "alert alert-success"
                : "alert alert-danger";
            msgBox.textContent = data.message;

            if (data.status === "success") {
                form.reset();
            }
        })
        .catch(() => {
            msgBox.className = "alert alert-danger";
            msgBox.textContent = "Server error. Try again.";
            msgBox.classList.remove("d-none");
        });
    });
});
