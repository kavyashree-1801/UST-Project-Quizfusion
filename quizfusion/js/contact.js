document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("contactForm");
    const successMsg = document.getElementById("successMsg");

    form.addEventListener("submit", function(e) {
        e.preventDefault();

        // Frontend validation
        let valid = true;
        ["name", "email", "message"].forEach(id => {
            const el = document.getElementById(id);
            if (!el.value.trim()) {
                el.classList.add("is-invalid");
                valid = false;
            } else {
                el.classList.remove("is-invalid");
            }
        });

        if (!valid) return;

        // Submit via fetch (AJAX)
        const formData = new FormData(form);
        fetch("api/contact_submit.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                successMsg.classList.remove("d-none");
                form.reset();
                setTimeout(() => window.location.href = "homepage.php", 3000);
            } else {
                alert(data.message || "Something went wrong.");
            }
        })
        .catch(err => console.error(err));
    });
});
const toggle = document.getElementById("menuToggle");
const navLinks = document.getElementById("navLinks");

toggle.addEventListener("click", () => {
    navLinks.classList.toggle("show");
});
