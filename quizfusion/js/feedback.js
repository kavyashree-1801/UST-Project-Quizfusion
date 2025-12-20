const form = document.getElementById("feedbackForm");
const successMsg = document.getElementById("successMsg");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const rating = document.getElementById("rating").value;
    const comments = document.getElementById("comments").value.trim();

    if (!name || !email || !rating || !comments) {
        alert("Please fill all fields");
        return;
    }

    try {
        const formData = new FormData();
        formData.append("name", name);
        formData.append("email", email);
        formData.append("rating", rating);
        formData.append("comments", comments);

        const res = await fetch("api/feedback_submit.php", {
            method: "POST",
            body: formData
        });

        const data = await res.json();

        if (data.status === "success") {
            successMsg.classList.remove("d-none");
            form.reset();
        } else {
            alert(data.message);
        }
    } catch (err) {
        console.error(err);
        alert("Server error. Please try again.");
    }
});
