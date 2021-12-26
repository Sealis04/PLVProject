<script>
    var resend = document.getElementById('Resend');

    var label = document.getElementById('timer');
    label.textContent = 60;
    resend.addEventListener('click', startInterval);

    function startInterval(e) {
        var timer = 60;
        e.preventDefault();
        e.currentTarget.disabled = true;
        var timers = setInterval(function() {
            if (timer <= 0) {
                resend.disabled = false;
                clearInterval(timers);
            } else {
                timer -= 1;
            }
            label.textContent = timer;
        }, 1000)
        timers.buttonParam = e.currentTarget;
    }
</script>