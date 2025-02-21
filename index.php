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
    <script>
        let remainingTime = <?php echo $remainingTime; ?>;
        function updateCountdown() {
            if (remainingTime <= 0) {
                document.getElementById("countdown").innerHTML = "Time's up!";
                return;
            }
            let days = Math.floor(remainingTime / (60 * 60 * 24));
            let hours = Math.floor((remainingTime % (60 * 60 * 24)) / (60 * 60));
            let minutes = Math.floor((remainingTime % (60 * 60)) / 60);
            let seconds = remainingTime % 60;

            document.getElementById("countdown").innerHTML = 
                days + "d " + hours + "h " + minutes + "m " + seconds + "s";
            remainingTime--;
            setTimeout(updateCountdown, 1000);
        }
        window.onload = updateCountdown;
    </script>
</head>
<body>
    <h1>Countdown Timer Go Home</h1>
    <p id="countdown"></p>
</body>
</html>



