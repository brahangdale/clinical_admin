<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ultimate Number Game</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}
body{background:linear-gradient(135deg,#4facfe,#00f2fe);min-height:100vh;padding:15px;transition:.5s}
body.night{background:linear-gradient(#091428,#1b3358);color:#fff}
body.space{background:linear-gradient(#000428,#004e92);color:#fff}
.container{max-width:520px;margin:auto}
.card{background:#fff;border-radius:25px;padding:20px;box-shadow:0 10px 25px rgba(0,0,0,.15)}
body.night .card,body.space .card{background:#1f2940;color:#fff}
h1{text-align:center;margin-bottom:15px}
.top{display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;font-weight:bold}
.progress{height:12px;background:#ddd;border-radius:20px;margin:15px 0;overflow:hidden}
.bar{height:100%;width:0;background:#0d8fff}
.seq{text-align:center;font-size:32px;margin:25px 0}
.options{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.opt{padding:14px;border:none;border-radius:12px;background:#0d8fff;color:#fff;font-size:20px}
.msg{text-align:center;font-weight:bold;margin-top:10px;min-height:25px}
.badge{text-align:center;margin:10px 0;font-size:18px}
.timer{font-size:20px;color:#ff5722}
</style>
</head>
<body>
<div class="container">
<div class="card">
<h1>🔢 Number Master</h1>

<div class="top">
<div>❤️ <span id="lives">3</span></div>
<div>⭐ <span id="score">0</span></div>
<div>🏆 Lv <span id="level">1</span></div>
<div>🔥 <span id="streak">0</span></div>
<div class="timer">⏱️ <span id="timer">15</span></div>
</div>

<div class="progress"><div class="bar" id="bar"></div></div>

<div class="badge" id="badge">🥉 Beginner</div>

<div class="seq" id="seq"></div>

<div class="options" id="options"></div>

<div class="msg" id="msg"></div>

</div>
</div>

<script>
let level=1,score=0,lives=3,streak=0,answer=0,time=15,interval;

function beep(freq){
const ctx=new(window.AudioContext||window.webkitAudioContext)();
const o=ctx.createOscillator();
const g=ctx.createGain();
o.frequency.value=freq;
o.connect(g);g.connect(ctx.destination);
o.start();
g.gain.exponentialRampToValueAtTime(0.0001,ctx.currentTime+0.2);
o.stop(ctx.currentTime+0.2);
}

function startTimer(){
clearInterval(interval);
time=level<15?15:level<30?12:8;
document.getElementById('timer').innerText=time;

interval=setInterval(()=>{
time--;
document.getElementById('timer').innerText=time;
if(time<=0){
clearInterval(interval);
wrongAnswer();
}
},1000);
}

function generate(){

if(level<15){
let s=Math.floor(Math.random()*10)+1;
answer=s+3;
show(`${s}, ${s+1}, ${s+2}, ?`);
}
else if(level<30){
document.body.className='night';
let s=Math.floor(Math.random()*20)+5;
answer=s+6;
show(`${s}, ${s+2}, ${s+4}, ?`);
}
else{
document.body.className='space';
let s=Math.floor(Math.random()*5)+2;
answer=s*8;
show(`${s}, ${s*2}, ${s*4}, ?`);
}

startTimer();
updateBadge();
document.getElementById('bar').style.width=Math.min(level,50)*2+'%';
}

function show(text){
document.getElementById('seq').innerText=text;

let arr=[answer];
while(arr.length<4){
let n=answer+(Math.floor(Math.random()*12)-6);
if(n!==answer && !arr.includes(n)) arr.push(n);
}
arr.sort(()=>Math.random()-0.5);

let html='';
arr.forEach(v=>{
html+=`<button class="opt" onclick="check(${v})">${v}</button>`;
});
document.getElementById('options').innerHTML=html;
}

function check(v){

if(v===answer){

let bonus=time>=10?20:0;

score+=10+bonus;
level++;
streak++;

if(streak==5){
score+=50;
document.getElementById('msg').innerHTML='🔥 Combo x5 Bonus +50';
}
else if(streak==10){
score+=100;
document.getElementById('msg').innerHTML='⚡ Super Brain Bonus +100';
}
else{
document.getElementById('msg').innerHTML='✅ Correct';
}

beep(900);

}else{
wrongAnswer();
return;
}

update();
generate();
}

function wrongAnswer(){

lives--;
streak=0;

document.getElementById('msg').innerHTML='❌ Wrong / Time Up';

beep(180);

if(lives<=0){

let best=localStorage.getItem('best')||0;
if(score>best){
localStorage.setItem('best',score);
best=score;
}

alert(
'💥 Game Over\\n\\nScore: '+score+
'\\nBest Score: '+best
);

location.reload();
return;
}

update();
generate();
}

function update(){
document.getElementById('score').innerText=score;
document.getElementById('level').innerText=level;
document.getElementById('lives').innerText=lives;
document.getElementById('streak').innerText=streak;
}

function updateBadge(){
let b='🥉 Beginner';
if(level>=10)b='🥈 Smart Player';
if(level>=25)b='🥇 Number Master';
if(level>=40)b='👑 Genius';
document.getElementById('badge').innerText=b;
}

generate();
update();
</script>
</body>
</html>
