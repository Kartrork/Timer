<?php
$targetDate = strtotime("2025-4-10 23:59:59");
$currentTime = time(); 
$remainingTime = $targetDate - $currentTime;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Timer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #1a1a2e;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            transition: background 1s ease;
        }

        h1 {
            font-size: 2.5rem;
            animation: fadeIn 2s ease-in-out;
        }

        #countdown {
            font-size: 3rem;
            font-weight: bold;
            margin-top: 20px;
            animation: scaleUp 2s ease-in-out;
            display: inline-block;
            padding: 20px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleUp {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.3); }
            50% { transform: scale(1.1); box-shadow: 0px 0px 30px rgba(255, 255, 255, 0.6); }
            100% { transform: scale(1); box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.3); }
        }

        @keyframes highlight {
            0%, 100% { color: white; }
            50% { color: yellow; }
        }
    </style>
    <script>
        let remainingTime = <?php echo $remainingTime; ?>;
        
        function updateCountdown() {
            if (remainingTime <= 0) {
                document.getElementById("countdown").innerHTML = "It's sunrise!";
                document.body.style.background = "#ffcc00"; // Change background to sunrise color
                return;
            }

            let days = Math.floor(remainingTime / (60 * 60 * 24));
            let hours = Math.floor((remainingTime % (60 * 60 * 24)) / (60 * 60));
            let minutes = Math.floor((remainingTime % (60 * 60)) / 60);
            let seconds = remainingTime % 60;

            let countdownElement = document.getElementById("countdown");
            countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

            // Display messages and change background based on remaining time
            if (remainingTime < 6 * 60 * 60) {
                countdownElement.innerHTML += " - It's a few hours left!";
                document.body.style.background = "#ff5733"; // Change to orange for few hours left
                countdownElement.style.animation = "pulse 1s infinite"; // Add animation for urgency
            } else if (remainingTime < 60 * 60) {
                countdownElement.innerHTML += " - It's almost time!";
                document.body.style.background = "#ffc300"; // Change to yellow for almost time
                countdownElement.style.animation = "highlight 1s infinite"; // Highlight animation
            } else if (remainingTime < 24 * 60 * 60) {
                countdownElement.innerHTML += " - It's sunset!";
                countdownElement.style.animation = "pulse 1s infinite"; // Add animation for sunset
            }

            remainingTime--;
            setTimeout(updateCountdown, 1000);
        }

        window.onload = updateCountdown;
    </script>
</head>
<body>
    <h1>Countdown Timer</h1>
    <p id="countdown"></p>
</body>
</html>
