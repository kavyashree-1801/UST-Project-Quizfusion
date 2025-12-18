let correctAnswer = "";
let timer;
let timeLeft = 40;

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

function loadQuestion(){
    fetch("api/api_math_logic.php")
    .then(r=>r.json())
    .then(d=>{
        if(d.finished){
            showResult(d.score,d.total);
            return;
        }

        qEl.innerText = d.index+". "+d.question;
        correctAnswer = d.answer;

        optEl.innerHTML = "";
        d.options.forEach(o=>{
            optEl.innerHTML += `
            <label>
                <input type="radio" name="opt" value="${o}">
                ${o}
            </label>`;
        });

        hintEl.innerText = d.hint;
        hintEl.style.display="none";
        hintBtn.style.display="inline-block";

        progressEl.style.width=((d.index-1)/d.total)*100+"%";

        startTimer();
    });
}

optEl.onclick = e=>{
    if(e.target.tagName!=="INPUT") return;

    let selected = e.target.value;

    fetch("api/api_math_logic.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"answer="+selected
    });

    document.querySelectorAll("label").forEach(l=>{
        let v=l.querySelector("input").value;
        if(v===correctAnswer) l.classList.add("correct");
        else if(v===selected) l.classList.add("incorrect");
        l.querySelector("input").disabled=true;
    });
};

nextBtn.onclick = ()=>{
    fetch("api/api_math_logic.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"next=1"
    }).then(loadQuestion);
};

hintBtn.onclick=()=>{
    hintEl.style.display="block";
    hintBtn.style.display="none";
};

restartBtn.onclick=()=>{
    fetch("api/api_math_logic.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"restart=1"
    }).then(()=>{
        location.reload();
    });
};

function startTimer(){
    clearInterval(timer);
    timeLeft=40;
    timerEl.innerText="40s";

    timer=setInterval(()=>{
        timerEl.innerText=timeLeft+"s";
        if(timeLeft--<=0){
            clearInterval(timer);
            nextBtn.click();
        }
    },1000);
}

function showResult(score,total){
    qEl.style.display="none";
    optEl.style.display="none";
    hintBtn.style.display="none";
    nextBtn.style.display="none";
    timerEl.style.display="none";
    progressEl.style.display="none";

    resultEl.innerHTML=`
        <h3>🎉 Quiz Completed</h3>
        <p>Your Score: <b>${score}/${total}</b></p>
    `;

    restartBtn.style.display="inline-block";
    backBtn.style.display="inline-block";
}

loadQuestion();
