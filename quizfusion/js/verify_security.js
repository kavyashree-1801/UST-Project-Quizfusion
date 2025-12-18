document.addEventListener('DOMContentLoaded', function() {

    const answerInput = document.getElementById('answer');
    const verifyBtn = document.getElementById('verifyBtn');
    const errorDiv = document.getElementById('error');
    const toggleAnswer = document.getElementById('toggleAnswer');
    const questionText = document.getElementById('questionText');

    // Fetch question from server
    fetch('api/get_security_question.php')
    .then(res => res.json())
    .then(data => {
        if(data.success){
            questionText.innerText = data.question;
        } else {
            errorDiv.innerText = data.message;
        }
    });

    verifyBtn.addEventListener('click', function() {
        errorDiv.innerText = '';
        const answer = answerInput.value.trim();
        if(!answer){ errorDiv.innerText = "Please enter your answer"; return; }

        fetch('api/verify_answer.php', {
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'answer=' + encodeURIComponent(answer)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert('Your password is: ' + data.password);
                sessionStorage.clear();
                window.location.href = 'login.php';
            } else {
                errorDiv.innerText = data.message;
            }
        });
    });

    toggleAnswer.addEventListener('click', function() {
        answerInput.type = answerInput.type === 'password' ? 'text' : 'password';
    });

});
