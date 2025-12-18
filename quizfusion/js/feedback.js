const form = document.getElementById("feedbackForm");
const successMsg = document.getElementById("successMsg");

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    form.classList.remove("was-validated");
    successMsg.classList.add("d-none");

    if (!form.checkValidity()) {
        form.classList.add("was-validated");
        return;
    }

    const formData = new FormData(form);
    const res = await fetch("api/feedback_submit.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.status === "success") {
        successMsg.textContent = data.message;
        successMsg.classList.remove("d-none");
        form.reset();
    } else {
        alert(data.message || "Submission failed.");
    }
});
