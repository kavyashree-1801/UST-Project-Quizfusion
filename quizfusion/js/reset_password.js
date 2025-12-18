document.getElementById("resetForm").addEventListener("submit", function(e){

    const password = document.getElementById("password").value.trim();
    const confirm  = document.getElementById("confirm").value.trim();

    if(password.length < 6){
        alert("Password must be at least 6 characters.");
        e.preventDefault();
        return;
    }

    if(password !== confirm){
        alert("Passwords do not match.");
        e.preventDefault();
        return;
    }
});
