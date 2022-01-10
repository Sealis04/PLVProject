<script type="text/javascript" src="Backend_Modal.php"></script>
<script>
    var resend = document.getElementById('resend');
    var label = document.getElementById('timer');
    var url = window.location.href;
    var url_string = new URL(url);
    var c = url_string.searchParams.get('code');
    resend.addEventListener('click', sendEmail);
    if (localStorage.getItem('counter')) {
        var x = localStorage.getItem('startCount');
        const date1 = new Date(x);
        const date2 = new Date();
        const diffTime = Math.abs(date2 - date1);
        console.log(diffTime/1000);
        if(diffTime/1000 <= 60){
            var newCounter = Math.abs(60 - Math.ceil(diffTime/1000));
            localStorage.setItem('counter',newCounter);
            startInterval();
        }else{
            localStorage.setItem('counter',0);
        }
    }

    function startInterval() {
        if (!localStorage.getItem('counter')) {
            localStorage.setItem("startCount", new Date());
            localStorage.setItem("counter", 60);
        }
        var timer = localStorage.getItem('counter');
        label.textContent = timer;
        resend.disabled = true;
        var timers = setInterval(function() {
            if (timer <= 0) {
                resend.disabled = false;
                localStorage.removeItem('counter');
                clearInterval(timers);
            } else {
                timer -= 1;
                localStorage.setItem('counter', timer);
            }
            label.textContent = timer;
        }, 1000)

    }

    function sendEmail(e) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                modal('OTP resent!',function(){
                    startInterval();
                })
            }
        }
        xmlhttp.open("GET", "/sendEmailLink.php?var=" + c + '&type=OTP', true);
        xmlhttp.send();
    }
</script>