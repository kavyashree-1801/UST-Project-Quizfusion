let selected = null;
let correctAnswer = null;
let currentHint = "";
let timer;
let timeLeft = 30;

const qEl = document.getElementById("question");
const optEl = document.getElementById("options");
const hintEl = document.getElementById("hint");
const hintBtn = document.getElementById("hintBtn");
const timerEl = document.getElementById("timer");
const progressContainer = document.querySelector(".progress-bar"); // ✅ ADD
const progressEl = document.getElementById("progress");
const resultEl = document.getElementById("result");
const formEl = document.getElementById("quizForm");
const nextBtn = document.getElementById("nextBtn");

/* ===== TIMER ===== */
function startTimer() {
    clearInterval(timer);
    timeLeft = 30;
    timerEl.innerText = timeLeft + "s";

    timer = setInterval(() => {
        timeLeft--;
        timerEl.innerText = timeLeft + "s";
        if (timeLeft <= 0) {
            clearInterval(timer);
        }
    }, 1000);
}

/* ===== LOAD QUESTION ===== */
function loadQuestion(next = false) {
    clearInterval(timer);

    const fd = new FormData();
    if (selected) fd.append("answer", selected);
    if (next) fd.append("next", 1);

    fetch("api/technical_api.php", { method: "POST", body: fd })
        .then(res => res.json())
        .then(data => {

            if (data.finished) {
                showResult(data.score, data.total);
                return;
            }

            /* RESET */
            selected = null;
            nextBtn.disabled = true;
            hintEl.style.display = "none";

            // ✅ SHOW progress bar like GK
            progressContainer.style.display = "block";
            timerEl.style.display = "block";
            formEl.style.display = "block";

            currentHint = data.hint;
            qEl.innerText = data.question;
            correctAnswer = data.answer;
            optEl.innerHTML = "";

            // ✅ Progress bar calculation (same as GK)
            progressEl.style.width =
                ((data.index - 1) / data.total) * 100 + "%";

            data.options.forEach(opt => {
                const label = document.createElement("label");
                label.innerHTML = `<input type="radio"> ${opt}`;

                label.onclick = () => {
                    if (selected) return;
                    selected = opt;
                    nextBtn.disabled = false;

                    document.querySelectorAll("#options label").forEach(l => {
                        const text = l.innerText.trim();
                        if (text === correctAnswer) l.classList.add("correct");
                        else if (text === selected) l.classList.add("incorrect");
                        l.querySelector("input").disabled = true;
                    });
                };

                optEl.appendChild(label);
            });

            startTimer();
        });
}

/* ===== NEXT ===== */
formEl.addEventListener("submit", e => {
    e.preventDefault();
    if (!selected) return;
    loadQuestion(true);
});

/* ===== SHOW HINT ===== */
hintBtn.onclick = () => {
    hintEl.innerText = currentHint;
    hintEl.style.display = "block";
};

/* ===== SHOW RESULT ===== */
function showResult(score, total) {
    qEl.style.display = "none";
    optEl.style.display = "none";
    hintBtn.style.display = "none";
    hintEl.style.display = "none";
    timerEl.style.display = "none";
    progressContainer.style.display = "none"; // ✅ FIX
    formEl.style.display = "none";

    resultEl.innerHTML = `
        🎉 Quiz Completed<br>
        <strong>${score} / ${total}</strong><br><br>
        <button class="btn" id="restartBtn">Restart Quiz</button>
        <a href="categories.php" class="btn">Back to Categories</a>
    `;

    document.getElementById("restartBtn").onclick = () => {
        const fd = new FormData();
        fd.append("restart", 1);
        fetch("api/technical_api.php", { method: "POST", body: fd })
            .then(() => location.reload());
    };
}

/* ===== INITIAL LOAD ===== */
loadQuestion();
