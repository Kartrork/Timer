<?php
$targetDate = strtotime("2025-12-31 17:59:59");
$currentTime = time();
$remainingTime = $targetDate - $currentTime;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Countdown</title>

<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #1a1a2e;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        overflow: hidden;
    }

    canvas {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 0;
    }

    h1, .watch, .message {
        position: relative;
        z-index: 1;
    }

    h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        animation: fadeIn 2s ease;
    }

    .watch {
        display: flex;
        gap: 15px;
        padding: 25px 30px;
        border-radius: 20px;
        background: rgba(0, 0, 0, 0.55);
        box-shadow: 0 0 30px rgba(0, 255, 255, 0.35);
        backdrop-filter: blur(10px);
        animation: scaleUp 1.5s ease;
    }

    .time-box {
        background: #0f3460;
        border-radius: 15px;
        padding: 15px 18px;
        min-width: 95px;
        text-align: center;
        box-shadow: inset 0 0 12px rgba(0, 255, 255, 0.4);
    }

    .time-box span {
        display: block;
        font-size: 2.6rem;
        font-weight: bold;
        color: #00ffff;
    }

    .time-box small {
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #cccccc;
        margin-top: 6px;
        display: block;
    }

    .urgent {
        animation: pulse 1s infinite;
    }

    .message {
        margin-top: 20px;
        font-size: 1.2rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleUp {
        from { transform: scale(0.7); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
</head>

<body>

<canvas id="fireworks"></canvas>

<h1>Countdown Timer</h1>

<div class="watch">
    <div class="time-box"><span id="days">00</span><small>DAYS</small></div>
    <div class="time-box"><span id="hours">00</span><small>HOURS</small></div>
    <div class="time-box"><span id="minutes">00</span><small>MINUTES</small></div>
    <div class="time-box"><span id="seconds">00</span><small>SECONDS</small></div>
</div>

<div class="message" id="message"></div>

<script>
let remainingTime = <?php echo max(0, $remainingTime); ?>;

// COUNTDOWN
function updateCountdown() {
    if (remainingTime <= 0) {
        document.querySelector(".watch").innerHTML =
            "<h2>🎆 Happy New Year 2026 🎆</h2>";
        return;
    }

    let days = Math.floor(remainingTime / 86400);
    let hours = Math.floor((remainingTime % 86400) / 3600);
    let minutes = Math.floor((remainingTime % 3600) / 60);
    let seconds = remainingTime % 60;

    daysEl.textContent = String(days).padStart(2, '0');
    hoursEl.textContent = String(hours).padStart(2, '0');
    minutesEl.textContent = String(minutes).padStart(2, '0');
    secondsEl.textContent = String(seconds).padStart(2, '0');

    if (remainingTime < 3600) {
        document.querySelector('.watch').classList.add('urgent');
        message.textContent = "🎉 Almost time!";
    }

    remainingTime--;
    setTimeout(updateCountdown, 1000);
}

const daysEl = document.getElementById("days");
const hoursEl = document.getElementById("hours");
const minutesEl = document.getElementById("minutes");
const secondsEl = document.getElementById("seconds");
const message = document.getElementById("message");

updateCountdown();

// 🎆 FIREWORKS CANVAS
const canvas = document.getElementById("fireworks");
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

window.onresize = () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
};

function random(min, max) {
    return Math.random() * (max - min) + min;
}

class Firework {
    constructor() {
        this.x = random(0, canvas.width);
        this.y = random(0, canvas.height / 2);
        this.radius = 2;
        this.particles = [];
        this.createParticles();
    }

    createParticles() {
        for (let i = 0; i < 60; i++) {
            this.particles.push({
                x: this.x,
                y: this.y,
                angle: Math.random() * Math.PI * 2,
                speed: random(1, 5),
                life: 100,
                color: `hsl(${random(0, 360)}, 100%, 60%)`
            });
        }
    }

    update() {
        this.particles.forEach(p => {
            p.x += Math.cos(p.angle) * p.speed;
            p.y += Math.sin(p.angle) * p.speed;
            p.life--;
        });
    }

    draw() {
        this.particles.forEach(p => {
            ctx.fillStyle = p.color;
            ctx.beginPath();
            ctx.arc(p.x, p.y, 2, 0, Math.PI * 2);
            ctx.fill();
        });
    }
}

let fireworks = [];

function animateFireworks() {
    ctx.fillStyle = "rgba(0,0,0,0.2)";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    if (Math.random() < 0.05) fireworks.push(new Firework());

    fireworks.forEach((fw, i) => {
        fw.update();
        fw.draw();
        if (fw.particles[0].life <= 0) fireworks.splice(i, 1);
    });

    requestAnimationFrame(animateFireworks);
}

animateFireworks();
</script>

</body>
</html>
