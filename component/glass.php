<link rel="stylesheet" href="assets/app/glass/glass.css">
<style>
    .countdown1>li {
    display: inline-block;
    font-size: 1em;
    list-style-type: none;
    padding: 1em;
    text-transform: uppercase;
    }

    .countdown1>li>span {
    display: block;
    font-size: 2.5rem;
    }

    .message {
    font-size: 4rem;
    }

    #content {
    display: none;
    padding: 1rem;
    }

    .emoji {
    padding: 0.25rem;
    }

    @media all and (max-width: 768px) {
    
        .countdown1>li {
            font-size: 1.125rem;
            padding: .5rem;
        }

        .countdown1>li>span {
            font-size: 1.375rem;
        }
    }
</style>
<div class="glass-card animate__animated xfadeIn animate__fadeIn w-75 mx-auto">
    <div class="row">
        <div class="col-12">
            <h2 class="text-white" id="headline">Graduation Countdown:</h2>
            <div id="countdown">
                <ul class="countdown1">
                    <li><span id="days"></span>days</li>
                    <li><span id="hours"></span>Hours</li>
                    <li><span id="minutes"></span>Minutes</li>
                    <li><span id="seconds"></span>Seconds</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
    const second = 1000,
          minute = second * 60,
          hour = minute * 60,
          day = hour * 24;

    let tenantturnover = "Nov 21, 2024 00:00:00",
        countDown = new Date(tenantturnover).getTime(),
        x = setInterval(function() {    

          let now = new Date().getTime(),
              distance = countDown - now;

          // Calculate and display the remaining time
          document.getElementById("days").innerText = Math.floor(distance / day);
          document.getElementById("hours").innerText = Math.floor((distance % day) / hour);
          document.getElementById("minutes").innerText = Math.floor((distance % hour) / minute);
          document.getElementById("seconds").innerText = Math.floor((distance % minute) / second);

          // When the countdown reaches zero
          if (distance < 0) {
            let headline = document.getElementById("headline"),
                countdown = document.getElementById("countdown"),
                content = document.getElementById("content");

            headline.innerText = "Hooray!";
            countdown.style.display = "none";
            content.style.display = "block";

            clearInterval(x); // Stop the interval
          }
        }, 1000); // Update every second (1000 ms)
  }());
</script>
<script src="/UTM/assets/app/odometer/odometer.js"></script>