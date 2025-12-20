let correctAnswer = "";
let timer;
let timeLeft = 30;
let answerSelected = false; // Flag to track if user answered

const qEl = document.getElementById("question");
const imgEl = document.getElementById("quizImage");
const optEl = document.getElementById("options");
const hintEl = document.getElementById("hint");
const hintBtn = document.getElementById("hintBtn");
const timerEl = document.getElementById("timer");
const progressContainer = document.querySelector(".progress-bar"); // Progress container
const progressEl = document.getElementById("progress");
const nextBtn = document.getElementById("nextBtn");
const resultEl = document.getElementById("result");
const restartBtn = document.getElementById("restartBtn");
const backBtn = document.getElementById("backBtn");

// Function to load question
function loadQuestion() {
    fetch("api/api_pictionary.php")
        .then(r => r.json())
        .then(d => {
            if (d.finished) {
                showResult(d.score, d.total);
                return;
            }

            answerSelected = false; // Reset flag for new question

            // Show progress container
            progressContainer.style.display = "block";

            qEl.innerText = d.index + ". " + d.question;
            correctAnswer = d.answer;

            // ✅ Preload image
            const newImg = new Image();
            newImg.src = d.image;
            newImg.onload = () => {
                imgEl.src = newImg.src;
                // ✅ Force image size same for all
                imgEl.style.width = "500px";  // set your fixed width
                imgEl.style.height = "500px"; // set your fixed height
                imgEl.style.objectFit = "cover"; // maintain aspect ratio, crop if needed
            };

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

            // Progress bar width
            progressEl.style.width = ((d.index - 1) / d.total) * 100 + "%";

            startTimer();
        });
}

// Option selection
optEl.onclick = e => {
    if (e.target.tagName !== "INPUT") return;

    let selected = e.target.value;
    answerSelected = true;

    fetch("api/api_pictionary.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "answer=" + selected
    });

    document.querySelectorAll("label").forEach(l => {
        let v = l.querySelector("input").value;
        if (v === correctAnswer) l.classList.add("correct");
        else if (v === selected) l.classList.add("incorrect");
        l.querySelector("input").disabled = true;
    });
};

// Next question
nextBtn.onclick = () => {
    if (!answerSelected) return;
    fetch("api/api_pictionary.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "next=1"
    }).then(loadQuestion);
};

// Hint
hintBtn.onclick = () => {
    hintEl.style.display = "block";
    hintBtn.style.display = "none";
};

// Restart quiz
restartBtn.onclick = () => {
    fetch("api/api_pictionary.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "restart=1"
    }).then(() => location.reload());
};

// Timer
function startTimer() {
    clearInterval(timer);
    timeLeft = 30;
    timerEl.innerText = "30s";

    timer = setInterval(() => {
        timerEl.innerText = timeLeft + "s";
        if (timeLeft-- <= 0) {
            clearInterval(timer);
            nextBtn.click();
        }
    }, 1000);
}

// Show result
function showResult(score, total) {
    qEl.style.display = "none";
    imgEl.style.display = "none";
    optEl.style.display = "none";
    hintBtn.style.display = "none";
    nextBtn.style.display = "none";
    timerEl.style.display = "none";
    progressContainer.style.display = "none";

    resultEl.innerHTML = `
        <h3>🎉 Quiz Completed</h3>
        <p>Your Score: <b>${score}/${total}</b></p>
    `;

    restartBtn.style.display = "inline-block";
    backBtn.style.display = "inline-block";
}

// Initial load
loadQuestion();
