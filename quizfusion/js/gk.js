let selected = null;
let correctAnswer = null;
let timer;
let timeLeft = 30;

const qEl = document.getElementById("question");
const optEl = document.getElementById("options");
const hintEl = document.getElementById("hint");
const hintBtn = document.getElementById("hintBtn");
const timerEl = document.getElementById("timer");
const progressContainer = document.querySelector(".progress-bar");
const progressEl = document.getElementById("progress");
const resultEl = document.getElementById("result");
const formEl = document.getElementById("quizForm");

function startTimer() {
    clearInterval(timer);
    timeLeft = 30;
    timerEl.innerText = timeLeft + "s";

    timer = setInterval(() => {
        timeLeft--;
        timerEl.innerText = timeLeft + "s";

        if (timeLeft <= 0) {
            clearInterval(timer);
            loadQuestion(true);
        }
    }, 1000);
}

function loadQuestion(next = false) {
    clearInterval(timer);

    const fd = new FormData();
    if (selected) fd.append("answer", selected);
    if (next) fd.append("next", 1);

    fetch("api/api_gk.php", { method: "POST", body: fd })
        .then(res => res.json())
        .then(data => {

            if (data.error) {
                qEl.innerText = "ERROR: " + data.error;
                formEl.style.display = "none";
                hintBtn.style.display = "none";
                hintEl.style.display = "none";
                timerEl.style.display = "none";
                progressContainer.style.display = "none";
                return;
            }

            if (data.finished) {
                clearInterval(timer);

                qEl.style.display = "none";
                optEl.style.display = "none";
                hintBtn.style.display = "none";
                hintEl.style.display = "none";
                timerEl.style.display = "none";
                progressContainer.style.display = "none";
                formEl.style.display = "none";

                resultEl.innerHTML = `
                    Quiz Completed!<br>
                    Score: <strong>${data.score} / ${data.total}</strong><br><br>
                    <button class="btn" id="restartBtn">Restart Quiz</button>
                    <a href="categories.php" class="btn">Back to Categories</a>
                `;

                document.getElementById("restartBtn").onclick = () => {
                    const fdRestart = new FormData();
                    fdRestart.append("restart", "1");

                    fetch("api/api_gk.php", { method: "POST", body: fdRestart })
                        .then(() => location.reload());
                };

                return;
            }

            qEl.style.display = "block";
            optEl.style.display = "block";
            hintBtn.style.display = "inline-block";
            hintEl.style.display = "none";
            timerEl.style.display = "block";
            progressContainer.style.display = "block";
            formEl.style.display = "block";
            resultEl.innerHTML = "";

            qEl.innerText = data.question;
            correctAnswer = data.answer;

            /* ===== ONLY CHANGE IS HERE ===== */
            if (data.hint && data.hint.trim() !== "") {
                hintEl.innerText = "Hint: " + data.hint;
            } else {
                hintEl.innerText = "";
            }
            /* ===== END CHANGE ===== */

            optEl.innerHTML = "";
            selected = null;

            data.options.forEach(opt => {
                const label = document.createElement("label");
                label.innerHTML = `<input type="radio"> ${opt}`;

                label.onclick = () => {
                    if (selected) return;
                    selected = opt;

                    document.querySelectorAll(".options label").forEach(l => {
                        const text = l.innerText.trim();

                        if (text === correctAnswer) l.classList.add("correct");
                        else if (text === selected) l.classList.add("wrong");

                        l.querySelector("input").disabled = true;
                    });
                };

                optEl.appendChild(label);
            });

            progressEl.style.width =
                ((data.index - 1) / data.total) * 100 + "%";

            startTimer();
        })
        .catch(err => {
            qEl.innerText = "FETCH ERROR: " + err;
        });
}

formEl.addEventListener("submit", e => {
    e.preventDefault();
    if (!selected) return;
    loadQuestion(true);
});

hintBtn.onclick = () => {
    hintEl.style.display = "block";
    hintBtn.style.display = "none";
};

loadQuestion();
