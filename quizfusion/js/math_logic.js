let correctAnswer = "";
let selectedAnswer = null;
let timer;
let timeLeft = 60;

const qEl = document.getElementById("question");
const optEl = document.getElementById("options");
const hintEl = document.getElementById("hint");
const hintBtn = document.getElementById("hintBtn");
const timerEl = document.getElementById("timer");
const progressContainer = document.querySelector(".progress-bar"); // full container
const progressEl = document.getElementById("progress"); // inner bar
const nextBtn = document.getElementById("nextBtn");
const resultEl = document.getElementById("result");
const restartBtn = document.getElementById("restartBtn");
const backBtn = document.getElementById("backBtn");

nextBtn.disabled = true; // disable Next initially

// Load a question
function loadQuestion(){
    fetch("api/api_math_logic.php")
    .then(r => r.json())
    .then(d => {
        if(d.finished){
            showResult(d.score, d.total);
            return;
        }

        qEl.innerText = d.index + ". " + d.question;
        correctAnswer = d.answer;
        selectedAnswer = null;
        nextBtn.disabled = true;

        optEl.innerHTML = "";
        d.options.forEach(o => {
            const label = document.createElement("label");
            label.innerHTML = `<input type="radio" name="opt" value="${o}"> ${o}`;
            label.addEventListener("click", () => {
                selectedAnswer = o;
                nextBtn.disabled = false;

                // mark correct/incorrect
                document.querySelectorAll("#options label").forEach(l => {
                    const val = l.querySelector("input").value;
                    if(val === correctAnswer) l.classList.add("correct");
                    else if(val === selectedAnswer) l.classList.add("incorrect");
                    l.querySelector("input").disabled = true;
                });

                fetch("api/api_math_logic.php", {
                    method: "POST",
                    headers: {"Content-Type":"application/x-www-form-urlencoded"},
                    body: "answer=" + encodeURIComponent(selectedAnswer)
                });
            });
            optEl.appendChild(label);
        });

        hintEl.innerText = d.hint;
        hintEl.style.display = "none";
        hintBtn.style.display = "inline-block";

        // Show progress only while quiz is active
        if(progressContainer && progressEl){
            progressContainer.style.display = "block";
            progressEl.style.width = ((d.index - 1)/d.total)*100 + "%";
        }

        startTimer();
    });
}

// Next button
nextBtn.onclick = () => {
    if(!selectedAnswer) return;
    fetch("api/api_math_logic.php", {
        method:"POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body:"next=1"
    }).then(() => loadQuestion());
};

// Hint button
hintBtn.onclick = () => {
    hintEl.style.display = "block";
    hintBtn.style.display = "none";
};

// Restart button
restartBtn.onclick = () => {
    fetch("api/api_math_logic.php", {
        method:"POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body:"restart=1"
    }).then(()=> location.reload());
};

// Back button
backBtn.onclick = () => {
    window.location.href = "categories.php";
};

// Timer
function startTimer(){
    clearInterval(timer);
    timeLeft = 60;
    timerEl.innerText = timeLeft + "s";

    timer = setInterval(()=>{
        timerEl.innerText = timeLeft + "s";
        if(timeLeft-- <= 0){
            clearInterval(timer);
            nextBtn.click();
        }
    },1000);
}

// Show result
function showResult(score,total){
    qEl.style.display = "none";
    optEl.style.display = "none";
    nextBtn.style.display = "none";
    timerEl.style.display = "none";
    hintBtn.style.display = "none";
    hintEl.style.display = "none";

    // ✅ HIDE progress bar container and inner bar on score page
    if(progressContainer){
        progressContainer.style.display = "none";
    }
    if(progressEl){
        progressEl.style.width = "0%";
    }

    resultEl.innerHTML = `
        <h3>🎉 Quiz Completed</h3>
        <p>Your Score: <b>${score}/${total}</b></p>
    `;
    restartBtn.style.display = "inline-block";
    backBtn.style.display = "inline-block";
}

// Initial load
loadQuestion();
