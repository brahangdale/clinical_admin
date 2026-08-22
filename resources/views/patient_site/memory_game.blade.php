<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Brain Fitness Hub Ultimate</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
/*
body::before,
body::after{
content:'';
position:fixed;
width:300px;
height:300px;
border-radius:50%;
filter:blur(80px);
z-index:-1;
animation:float 8s ease-in-out infinite;
}

body::before{
background:#7c3aed;
top:-100px;
right:-100px;
}

body::after{
background:#06b6d4;
bottom:-100px;
left:-100px;
}

@keyframes float{
50%{
transform:translateY(-30px);
}
}*/

body{
    font-family:'Segoe UI',sans-serif;
    background:
    radial-gradient(circle at top right,#7c3aed22,transparent 30%),
    radial-gradient(circle at bottom left,#06b6d422,transparent 30%),
    linear-gradient(135deg,#0f172a,#111827,#1e1b4b);
    color:#fff;
    padding:15px;
    min-height:100vh;
}

/* HEADER */

.top{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:18px;
}

.back{
    text-decoration:none;
    color:#fff;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    padding:12px 16px;
    border-radius:14px;
    font-weight:600;
    box-shadow:0 5px 20px rgba(37,99,235,.35);
    transition:.3s;
}

.back:hover{
    transform:translateY(-2px);
}

/* GLASS CARD */

.card{
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(16px);
    border:1px solid rgba(255,255,255,.08);
    border-radius:24px;
    padding:20px;
    margin-bottom:18px;
    box-shadow:
    0 10px 35px rgba(0,0,0,.25),
    inset 0 1px 0 rgba(255,255,255,.05);
}



/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:12px;
}

.stat{
    background:rgba(255,255,255,.05);
    border-radius:18px;
    padding:15px;
    text-align:center;
    transition:.3s;
}

.stat:hover{
    transform:translateY(-4px);
    background:rgba(255,255,255,.08);
}

/* XP BAR */

.progress{
    height:12px;
    background:#1e293b;
    border-radius:50px;
    overflow:hidden;
    margin-top:10px;
}

.bar{
    height:100%;
    width:0%;
    border-radius:50px;
    background:linear-gradient(
    90deg,
    #22c55e,
    #06b6d4,
    #3b82f6
    );
    box-shadow:0 0 15px #06b6d4;
}

/* MEMORY GRID */

.memory-game{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
}

/* CARD */

.memory-card{
    height:85px;
    border-radius:20px;
    background:
    linear-gradient(
    135deg,
    #2563eb,
    #7c3aed
    );
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:32px;
    cursor:pointer;
    transition:.3s;
    box-shadow:
    0 8px 25px rgba(124,58,237,.25);
    transform-style:preserve-3d;
    transition:.5s;
}

.memory-card:hover{
transform:
translateY(-6px)
rotateX(8deg)
rotateY(8deg);
}

.memory-card:active{
    transform:scale(.96);
}

.flipped{
    background:#fff;
    color:#111;
}

.matched{
    background:
    linear-gradient(
    135deg,
    #22c55e,
    #16a34a
    );
    box-shadow:
    0 0 20px #22c55e,
    0 0 40px #22c55e66;
}

/* BUTTONS */

button{
    border:none;
    border-radius:14px;
    padding:12px 18px;
    font-weight:600;
    cursor:pointer;
    color:#fff;
    background:
    linear-gradient(
    135deg,
    #2563eb,
    #7c3aed
    );
    transition:.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:
    0 8px 20px rgba(124,58,237,.35);
}

input{
    width:100%;
    padding:14px;
    margin-top:10px;
    border:none;
    border-radius:14px;
    outline:none;
}

/* MODAL */

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.8);
    backdrop-filter:blur(6px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.box{
    width:340px;
    text-align:center;
    padding:30px;
    border-radius:24px;
    background:#fff;
    color:#111;
    animation:popup .4s ease;
}

@keyframes popup{
    from{
        transform:scale(.7);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.avatar{
    font-size:100px;
    animation:bounce 1s infinite;
}

@keyframes bounce{
    50%{
        transform:translateY(-12px);
    }
}

.sad{
    animation:shake .4s infinite;
}

@keyframes shake{
    25%{
        transform:translateX(-6px);
    }
    75%{
        transform:translateX(6px);
    }
}

/* CONFETTI */

.conf{
    position:fixed;
    top:-20px;
    font-size:24px;
    animation:fall 3s linear forwards;
}

@keyframes fall{
    to{
        transform:translateY(110vh);
    }
}

/* MOBILE */

@media(max-width:768px){

    .stats{
        grid-template-columns:repeat(2,1fr);
    }

    .memory-card{
        height:70px;
        font-size:26px;
    }

    .box{
        width:90%;
    }

}
</style>
</style>
</head>
<body>

<div class="top">
<a href="index.html" class="back">← Back</a>
<h2>🧠 Brain Game</h2>
</div>

<div class="card">
<h3>👤 Profile</h3>
Level: <span id="level">1</span> |
XP: <span id="xp">0</span> |
Coins: <span id="coins">0</span>
<div class="progress"><div class="bar" id="xpbar"></div></div>
</div>

<div class="card stats">
<div class="stat">⭐<br><span id="best">0</span></div>
<div class="stat">🔥<br><span id="combo">0</span></div>
<div class="stat">🏆<br><span id="match">0</span></div>
<div class="stat">🎯<br><span id="moves">0</span></div>
<div class="stat">⏱<br><span id="timer">60</span></div>
</div>

<div class="card"><div id="game" class="memory-game"></div></div>

<div class="card">
<h3>🏆 Daily Challenge</h3>
<p>Finish under 25 moves.</p>
<button id="claim" disabled>Claim +100 XP +50 Coins</button>
<p id="reward"></p>
</div>

<!-- <div class="card">
<h3>🔢 Number Memory</h3>
<button onclick="startNumberGame()">Start</button>
<div id="numberArea"></div>
</div> -->

<div class="modal" id="modal">
<div class="box">
<div id="avatar" class="avatar">🥳</div>
<h2 id="title">You Win!</h2>
<p id="msg"></p>
<button onclick="playAgain()">🔄 Play Again</button>
</div>
</div>

<audio id="flip"
src="https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3"></audio>

<audio id="matchs"
src="https://assets.mixkit.co/active_storage/sfx/270/270-preview.mp3"></audio>

<audio id="wrong"
src="https://assets.mixkit.co/active_storage/sfx/1435/1435-preview.mp3"></audio>

<audio id="win"
src="https://assets.mixkit.co/active_storage/sfx/2018/2018-preview.mp3"></audio>




<script>
const icons=['🧠','🧠','⚡','⚡','🚀','🚀','👑','👑','💎','💎','🎯','🎯','🎮','🎮','🔥','🔥'];
let first=null,second=null,lock=false,matches=0,moves=0,combo=0,time=60,timer,challenge=false;
let xp=+localStorage.xp||0, coins=+localStorage.coins||0;

function save(){
localStorage.xp=xp; localStorage.coins=coins;
xpbar.style.width=(xp%100)+'%';
level.innerText=Math.floor(xp/100)+1;
document.getElementById('xp').innerText=xp;
document.getElementById('coins').innerText=coins;
}
function shuffle(a){return a.sort(()=>Math.random()-0.5)}
function confetti(){
for(let i=0;i<60;i++){
let d=document.createElement('div');
d.className='conf'; d.innerHTML=['🎉','✨','🎊','⭐'][Math.floor(Math.random()*4)];
d.style.left=Math.random()*100+'%';
document.body.appendChild(d);
setTimeout(()=>d.remove(),3000);
}}
function showModal(winState){
modal.style.display='flex';
if(winState){
avatar.innerHTML='🥳'; avatar.className='avatar';
title.innerText='Level Complete!';
msg.innerHTML='🏆 XP +100<br>💰 Coins +50';
confetti();

const winAudio =
document.getElementById('win');

winAudio.currentTime = 0;

winAudio.play().catch(()=>{});

}else{
avatar.innerHTML='😢'; avatar.className='avatar sad';
title.innerText='Time Over';
msg.innerHTML='Try Again';
}
}
function board(){
game.innerHTML='';
shuffle([...icons]).forEach(icon=>{
let c=document.createElement('div');
c.className='memory-card'; c.innerHTML='?'; c.dataset.icon=icon;
c.onclick=()=>{
if(lock||c===first||c.classList.contains('matched')) return;

const flipAudio =
document.getElementById('flip');

flipAudio.currentTime = 0;

flipAudio.play().catch(()=>{});

c.classList.add('flipped'); c.innerHTML=icon;
if(!first){first=c;return;}
second=c; moves++; document.getElementById('moves').innerText=moves;
if(first.dataset.icon===second.dataset.icon){

const matchAudio =
document.getElementById('matchs');

matchAudio.currentTime = 0;

matchAudio.play().catch(()=>{});

first.classList.add('matched'); second.classList.add('matched');
matches++; combo++; xp+=10; coins+=5; save();
match.innerText=matches; comboEl.innerText=combo;
first=second=null;
if(matches===8){
xp+=100; coins+=50; save();
if(moves<=25){challenge=true; claim.disabled=false;}
showModal(true);
}
}else{

document.getElementById('wrong')
.currentTime = 0;

document.getElementById('wrong')
.play().catch(()=>{});

combo=0;
comboEl.innerText=0;
lock=true;

setTimeout(()=>{first.classList.remove('flipped');second.classList.remove('flipped');first.innerHTML='?';second.innerHTML='?';first=second=null;lock=false;},700);
}
};
game.appendChild(c);
});
}
function startTimer(){
clearInterval(timer); time=60; timerEl.innerText=time;
timer=setInterval(()=>{
time--; timerEl.innerText=time;
if(time<=0){clearInterval(timer); showModal(false);}
},1000);
}
function playAgain(){
modal.style.display='none';
matches=0;moves=0;combo=0;challenge=false;
match.innerText=0; movesEl.innerText=0; comboEl.innerText=0;
claim.disabled=true;
board(); startTimer();
}
function startNumberGame(){
let num=Math.floor(100000+Math.random()*900000);
numberArea.innerHTML='<h2>'+num+'</h2><p>Memorize...</p>';
setTimeout(()=>{
numberArea.innerHTML='<input id="ninput" placeholder="Enter Number"><button onclick="checkNum('+num+')">Submit</button>';
},3000);
}
function checkNum(num){
let v=document.getElementById('ninput').value;
numberArea.innerHTML=(v==num)?'✅ Correct +20 XP':'❌ Wrong. Number was '+num;
if(v==num){xp+=20;save();}
}
claim.onclick=()=>{if(challenge){xp+=100;coins+=50;save();reward.innerText='Reward Claimed!';claim.disabled=true;}}

const game=document.getElementById('game'), modal=document.getElementById('modal');
const level=document.getElementById('level'), timerEl=document.getElementById('timer');
const match=document.getElementById('match'), movesEl=document.getElementById('moves');
const comboEl=document.getElementById('combo'), xpbar=document.getElementById('xpbar');
save(); board(); startTimer();



/*let soundEnabled=true;

function playSound(audio){

   if(!soundEnabled) return;

   audio.currentTime=0;

   audio.play().catch(()=>{});
}
*/
// =======================
// SOUND SYSTEM
// =======================

let soundEnabled = true;

// Audio Elements
const flipAudio  = document.getElementById("flip");
const matchAudio = document.getElementById("matchs");
const wrongAudio = document.getElementById("wrong");
const winAudio   = document.getElementById("win");

// Sound Toggle
document.getElementById("soundToggle").addEventListener("click", () => {

    soundEnabled = !soundEnabled;

    document.getElementById("soundToggle").innerText =
        soundEnabled
        ? "🔊 Sound ON"
        : "🔇 Sound OFF";

});

// Common Play Function
function playSound(audio) {

    if (!soundEnabled) return;

    if (!audio) return;

    audio.pause();
    audio.currentTime = 0;

    audio.play().catch(err => {
        console.log("Sound blocked:", err);
    });

}


</script>
</body>
</html>