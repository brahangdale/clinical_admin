<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Math Flight Ultimate</title>
<style>


	#options{
display:grid;
grid-template-columns:1fr 1fr;
gap:10px;
margin-top:15px;
}

.opt{
padding:14px;
font-size:22px;
font-weight:bold;
background:#fff;
color:#333;
cursor:pointer;
border:none;
border-radius:12px;
transition:.3s;
}

.opt:hover{
transform:scale(1.05);
background:#f5f5f5;
}



*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial;overflow:hidden}
#game{height:100vh;position:relative;overflow:hidden;background:linear-gradient(#4facfe,#87ceeb);transition:1s}
#game.night{background:linear-gradient(#0f172a,#1e293b,#312e81)}
.sun,.moon{position:absolute;right:30px;top:20px;font-size:60px}
.moon{display:none}
#game.night .sun{display:none}
#game.night .moon{display:block}
.cloud{position:absolute;font-size:50px;animation:cloud 18s linear infinite}
@keyframes cloud{from{left:-100px}to{left:110%}}
#plane{
position:absolute;left:8vw;bottom:240px;width:min(140px,28vw);
transition:bottom .6s ease;animation:fly 2s infinite ease-in-out;
}
@keyframes fly{50%{transform:translateY(-8px)}}
#propeller{
position:absolute;left:8vw;bottom:278px;width:20px;height:20px;
border-radius:50%;border:3px solid rgba(255,255,255,.8);
animation:spin .08s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg)}}
#hud{position:absolute;top:10px;left:10px;right:10px;display:flex;justify-content:space-between;z-index:5}
.card{background:rgba(255,255,255,.25);padding:10px 12px;border-radius:12px;color:#fff;font-weight:bold}
#panel{position:absolute;left:50%;transform:translateX(-50%);bottom:110px;width:min(95%,520px);background:rgba(255,255,255,.2);padding:18px;border-radius:18px;text-align:center;color:#fff}
#q{font-size:clamp(28px,8vw,42px);font-weight:bold}
input{width:100%;padding:14px;margin-top:10px;border:none;border-radius:12px;font-size:22px}
button{padding:12px 22px;margin-top:10px;border:none;border-radius:12px}
#ground{position:absolute;bottom:0;height:100px;width:100%;background:linear-gradient(#43a047,#2e7d32)}
#over{display:none;position:absolute;inset:0;background:rgba(0,0,0,.8);color:#fff;justify-content:center;align-items:center;flex-direction:column}
</style>
</head>
<body>
<div id="game">
<div class="sun">☀️</div><div class="moon">🌙</div>
<div class="cloud" style="top:50px">☁️</div>
<div class="cloud" style="top:150px;animation-delay:-7s">☁️</div>

<img id="plane" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 120'><path fill='white' d='M20 60 L140 40 L240 45 L285 60 L240 75 L140 80 Z'/><rect x='90' y='48' width='80' height='20' fill='lightblue'/><polygon points='100,40 70,10 120,40' fill='white'/><polygon points='100,80 70,110 120,80' fill='white'/></svg>">
<div id="propeller"></div>

<div id="hud">
<div class="card">Score: <span id="score">0</span></div>
<div class="card">Level: <span id="lvl">1</span></div>
<div class="card">Time: <span id="time">7</span></div>
</div>

<div id="panel">
<div id="q"></div>

<div id="options">
<button class="opt" onclick="selectAns(this)"></button>
<button class="opt" onclick="selectAns(this)"></button>
<button class="opt" onclick="selectAns(this)"></button>
<button class="opt" onclick="selectAns(this)"></button>
</div>

<div id="msg"></div>
</div>

<div id="ground"></div>

<div id="over">
<h1>💥 Plane Crashed</h1>
<h2>Score: <span id="final"></span></h2>
<button onclick="location.reload()">Play Again</button>
</div>
</div>

<script>
let score = 0,
    count = 0,
    correct = 0,
    h = 240,
    t = 15,
    intv;

const ctx = new (window.AudioContext || window.webkitAudioContext)();

function sound(f, d) {
    let o = ctx.createOscillator(),
        g = ctx.createGain();

    o.connect(g);
    g.connect(ctx.destination);

    o.frequency.value = f;
    o.start();

    g.gain.value = .08;
    g.gain.exponentialRampToValueAtTime(.0001, ctx.currentTime + d);

    o.stop(ctx.currentTime + d);
}

function rnd(a, b) {
    return Math.floor(Math.random() * (b - a + 1)) + a;
}

function makeQ() {

    count++;
    lvl.textContent = Math.floor(count / 5) + 1;

    if (count == 15)
        document.getElementById('game').classList.add('night');

    let a, b, op;

    if (count <= 20) {

        a = rnd(1, 10);
        b = rnd(1, 10);
        op = '+';
        correct = a + b;

    } else if (count <= 40) {

        a = rnd(5, 25);
        b = rnd(1, 15);

        op = Math.random() > .5 ? '+' : '-';
        correct = op == '+' ? a + b : a - b;

    } else {

        a = rnd(3, 15);
        b = rnd(2, 10);

        let r = Math.random();

        if (r < .33) {
            op = '+';
            correct = a + b;
        } else if (r < .66) {
            op = '-';
            correct = a - b;
        } else {
            op = '×';
            correct = a * b;
        }
    }

    q.innerHTML = `${a} ${op} ${b} = ?`;

    setOptions();
    timerStart();
}

function setOptions() {

    let opts = [correct];

    while (opts.length < 4) {

        let wrongAns = Math.max(0, correct + rnd(-10, 10));

        if (
            wrongAns !== correct &&
            !opts.includes(wrongAns)
        ) {
            opts.push(wrongAns);
        }
    }

    opts.sort(() => Math.random() - 0.5);

    document.querySelectorAll('.opt').forEach((btn, i) => {
        btn.textContent = opts[i];
    });
}

function timerStart() {

    clearInterval(intv);

    t = 15;
    time.textContent = t;

    intv = setInterval(() => {

        t--;
        time.textContent = t;

        if (t <= 0) {

            clearInterval(intv);
            wrong('⏰ Time Up');
        }

    }, 1000);
}

function selectAns(btn) {

    clearInterval(intv);

    if (Number(btn.textContent) === correct) {

        score += 10;
        scoreEl();

        h += 35;

        plane.style.bottom = h + 'px';
        propeller.style.bottom = (h + 38) + 'px';

        msg.innerHTML = '✅ Correct';

        sound(900, .12);

        setTimeout(() => {
            makeQ();
        }, 300);

    } else {

        wrong('❌ Wrong');
    }
}

function wrong(m) {

    clearInterval(intv);

    msg.innerHTML = m;

    h -= 45;

    plane.style.bottom = h + 'px';
    propeller.style.bottom = (h + 38) + 'px';

    sound(220, .25);

    if (h <= 100) {

        sound(90, .7);

        final.textContent = score;

        over.style.display = 'flex';

        return;
    }

    setTimeout(() => {
        makeQ();
    }, 500);
}

function scoreEl() {
    score.textContent = score;
}

makeQ();
</script>
</body>
</html>