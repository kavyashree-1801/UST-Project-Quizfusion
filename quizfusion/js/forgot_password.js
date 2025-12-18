document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const nextBtn = document.getElementById('nextBtn');
    const errorDiv = document.getElementById('error');

    nextBtn.addEventListener('click', function() {
        errorDiv.innerText = '';
        const email = emailInput.value.trim();
        if(!email){ errorDiv.innerText = "Please enter your email"; return; }

        fetch('api/check_email.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'email=' + encodeURIComponent(email)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                // store email in session and redirect
                window.location.href = 'verify_security.php?email=' + encodeURIComponent(email);
            } else {
                errorDiv.innerText = data.message;
            }
        })
        .catch(err => {
            errorDiv.innerText = "Error connecting to server";
            console.error(err);
        });
    });
});
