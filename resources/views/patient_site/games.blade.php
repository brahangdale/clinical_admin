<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Fun Zone</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:linear-gradient(180deg,#f4f9ff,#eaf6ff);
min-height:100vh;
padding:20px;
}


.top-bar{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
}

.top-bar h1{
    font-size:22px;
    margin:0;
    color:#0d4b87;
}

.top-bar span{
    font-size:12px;
    color:#888;
}


.container{
max-width:500px;
margin:auto;
}

/* Header */

.header{
/*text-align:center;
margin-bottom:25px;*/
}

.header h1{
font-size:32px;
color:#0d4b87;
/*margin-bottom:10px;*/
}

.header p{
color:#666;
font-size:15px;
line-height:1.5;
}

.waiting-box{
background:#fff;
border-radius:25px;
padding:18px;
margin-top:20px;
display:flex;
align-items:center;
gap:15px;
box-shadow:0 8px 25px rgba(0,0,0,.08);
}

.waiting-icon{
width:70px;
height:70px;
background:#e9f5ff;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:30px;
color:#0d8fff;
}

.waiting-text h3{
color:#333;
margin-bottom:5px;
}

.waiting-text p{
font-size:13px;
color:#666;
}

/* Game Cards */

.game-card{
background:#fff;
padding:18px;
border-radius:25px;
margin-top:18px;
display:flex;
align-items:center;
justify-content:space-between;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
cursor:pointer;
}

.game-card:hover{
transform:translateY(-5px);
}

.left{
display:flex;
align-items:center;
gap:15px;
}

.game-icon{
width:75px;
height:75px;
border-radius:20px;
display:flex;
align-items:center;
justify-content:center;
font-size:34px;
color:#fff;
}

.math{
background:linear-gradient(135deg,#4facfe,#00c6ff);
}

.memory{
background:linear-gradient(135deg,#b16cea,#8e54e9);
}

.number{
background:linear-gradient(135deg,#36d1dc,#5b86e5);
}

.game-info h2{
font-size:22px;
margin-bottom:5px;
}

.game-info p{
font-size:13px;
color:#666;
}

.play-btn{
width:55px;
height:55px;
border-radius:50%;
background:#f2f7ff;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
color:#0d8fff;
}

.features{
background:#fff;
margin-top:25px;
padding:20px;
border-radius:25px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
display:grid;
grid-template-columns:repeat(2,1fr);
gap:15px;
}

.feature{
text-align:center;
}

.feature i{
font-size:26px;
margin-bottom:8px;
color:#0d8fff;
}

.feature span{
display:block;
font-size:14px;
color:#444;
}

.footer{
text-align:center;
margin-top:25px;
color:#777;
font-size:14px;
}

@media(max-width:480px){

.header h1{
font-size:28px;
}

.game-info h2{
font-size:18px;
}

.game-icon{
width:65px;
height:65px;
font-size:28px;
}

.play-btn{
width:50px;
height:50px;
}

}

.top-bar a {
    background: aquamarine;
    padding: 0px 14px;
    text-decoration: none;
    border: 1px solid chartreuse;
    border-radius: 10px;
}


a{
    text-decoration: none;
}
</style>
</head>

<body>


<div class="container">

<div class="header">
<div class="top-bar">

    <a href="{{ route('patient_site.home') }}" class="back-btn">
        <i class="fas fa-chevron-left"></i> Back
    </a>

    <div>
        <h1>Patient Fun Zone</h1>
        <span>Hospital Waiting Area</span>
    </div>

</div>
</div>

<div class="waiting-box">
<div class="waiting-icon">
<i class="fas fa-heartbeat"></i>
</div>

<div class="waiting-text">
<h3>Welcome!</h3>
<p>Enjoy short brain games while you wait.</p>
</div>
</div>



<!-- Memory Game -->
<a href="{{ route('patient_site.memory_game') }}">
<div class="game-card">

<div class="left">

<div class="game-icon memory">
🧠
</div>

<div class="game-info">
<h2>Memory Game</h2>
<p>Match cards and test memory.</p>
</div>

</div>


<div class="play-btn">
<i class="fas fa-arrow-right"></i>
</div>


</div>
</a>


<!-- Number Game -->
<a href="{{ route('patient_site.number_game') }}">
<div class="game-card">

<div class="left">

<div class="game-icon number">
🔢
</div>

<div class="game-info">
<h2>Number Game</h2>
<p>Fun with numbers and patterns.</p>
</div>

</div>


<div class="play-btn">
<i class="fas fa-arrow-right"></i>
</div>
</div>
</a>

<!-- Math Game -->

<a href="{{ route('patient_site.math_plane_game') }}">
<div class="game-card">

<div class="left">

<div class="game-icon math">
✈️
</div>

<div class="game-info">
<h2>Math Plane Game</h2>
<p>Solve math and fly higher.</p>
</div>

</div>


<div class="play-btn">
<i class="fas fa-arrow-right"></i>
</div>


</div>
</a>

<div class="features">

<div class="feature">
<i class="fas fa-clock"></i>
<span>Short Games</span>
</div>

<div class="feature">
<i class="fas fa-brain"></i>
<span>Brain Exercise</span>
</div>

<div class="feature">
<i class="fas fa-smile"></i>
<span>Stress Free</span>
</div>

<div class="feature">
<i class="fas fa-shield-heart"></i>
<span>Patient Friendly</span>
</div>

</div>

<div class="footer">
❤️ Reachmeonline
</div>

</div>

<script>

function openGame(type){

if(type=="math"){
window.location.href="math-plane-game.html";
}

if(type=="memory"){
window.location.href="memory-game.html";
}

if(type=="number"){
window.location.href="number-game.html";
}

}

</script>

</body>
</html>