let correctAnswer = "";
let timer;
let timeLeft = 40;
let canNext = false; // flag to allow Next button click

const qEl = document.getElementById("question");
const optEl = document.getElementById("options");
const hintEl = document.getElementById("hint");
const hintBtn = document.getElementById("hintBtn");
const timerEl = document.getElementById("timer");
const progressEl = document.getElementById("progress");
const nextBtn = document.getElementById("nextBtn");
const resultEl = document.getElementById("result");
const restartBtn = document.getElementById("restartBtn");
const backBtn = document.getElementById("backBtn");
const audio = document.getElementById("audioPlayer");

// Load the current question from API
function loadQuestion() {
    canNext = false; // reset flag for each question
    fetch("api/api_audio.php", { method: "POST", headers: {"Content-Type": "application/x-www-form-urlencoded"} })
        .then(r => r.json())
        .then(d => {

            if (d.finished) {
                stopTimer();
                audio.pause();
                audio.src = "";
                showResult(d.score, d.total);
                return;
            }

            qEl.style.display = "block";
            optEl.style.display = "block";
            nextBtn.style.display = "inline-block"; // visible, color unchanged
            timerEl.style.display = "inline-block";
            progressEl.style.display = "block";
            audio.style.display = "inline-block";

            qEl.innerText = d.index + ". " + d.question;
            correctAnswer = d.answer;

            audio.pause();
            audio.src = d.audio;
            audio.load();
            audio.play();

            // Options
            optEl.innerHTML = "";
            d.options.forEach(o => {
                optEl.innerHTML += `
                    <label>
                        <input type="radio" name="opt" value="${o}">
                        ${o}
                    </label>`;
            });

            hintEl.innerText = d.hint;
            hintEl.style.display = "none";
            hintBtn.style.display = "inline-block";

            progressEl.style.width = ((d.index - 1) / d.total) * 100 + "%";

            startTimer();
        });
}

// Handle option click
optEl.onclick = e => {
    if (e.target.tagName !== "INPUT") return;
    let selected = e.target.value;

    // allow next button click
    canNext = true;

    fetch("api/api_audio.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "answer=" + encodeURIComponent(selected)
    });

    document.querySelectorAll("#options label").forEach(l => {
        let v = l.querySelector("input").value;
        if (v === correctAnswer) l.classList.add("correct");
        else if (v === selected) l.classList.add("incorrect");
        l.querySelector("input").disabled = true;
    });
};

// Next question
nextBtn.onclick = () => {
    if (!canNext) return; // ignore click if user hasn't selected answer
    stopTimer();
    fetch("api/api_audio.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "next=1"
    }).then(loadQuestion);
};

// Show hint
hintBtn.onclick = () => {
    hintEl.style.display = "block";
    hintBtn.style.display = "none";
};

// Restart quiz
restartBtn.onclick = () => {
    stopTimer();
    fetch("api/api_audio.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "restart=1"
    }).then(() => location.reload());
};

// Timer
function startTimer() {
    clearInterval(timer);
    timeLeft = 40;
    timerEl.innerText = "40s";

    timer = setInterval(() => {
        timerEl.innerText = timeLeft + "s";
        if (timeLeft-- <= 0) {
            clearInterval(timer);
            if (canNext) nextBtn.click(); // auto-next only if answered
        }
    }, 1000);
}

function stopTimer() {
    clearInterval(timer);
}

// Show result
function showResult(score, total) {
    qEl.style.display = "none";
    optEl.style.display = "none";
    hintBtn.style.display = "none";
    nextBtn.style.display = "none";
    timerEl.style.display = "none";
    progressEl.style.display = "none";
    audio.style.display = "none";

    resultEl.innerHTML = `
        <h3>🎉 Quiz Completed</h3>
        <p>Your Score: <b>${score}/${total}</b></p>
    `;

    restartBtn.style.display = "inline-block";
    backBtn.style.display = "inline-block";
}

// Initial load
loadQuestion();
