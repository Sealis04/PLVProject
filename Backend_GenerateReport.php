<head>
    <title>PLVRS</title>
    <link rel="icon" href="assets/plv.png">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-3.4.1-dist/bootstrap-3.4.1-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js" type="text/javascript"></script>
</head>

<body>
    <?php
    session_start();
    ?>
    <div id='mainBody'>

    </div>
</body>
<script>
    var url = window.location.href;
    var url_string = new URL(url);
    var month = url_string.searchParams.get('month');
    var year = url_string.searchParams.get('year');
    onLoad(year, month);
    createButton();
    function createButton() {
        var main = document.getElementById('mainBody');
        var buttonsDiv = document.createElement('div');
        buttonsDiv.id = 'buttonsDiv';
        var print = document.createElement('input');
        print.className = 'header-btn btn printBtn';
        var save = document.createElement('input');
        save.className = 'header-btn btn printBtn';
        print.type = 'button';
        print.value = 'Print';
        save.type = 'button';
        save.value = 'Save as PDF';
        print.addEventListener('click', function(e) {
            window.print();
        });
        save.addEventListener('click', Modal)
        buttonsDiv.appendChild(print);
        buttonsDiv.appendChild(save);
        main.appendChild(buttonsDiv);
    }

    function Modal() {
        modalBody = document.createElement('div');
        invisibleContainer = document.createElement('div');
        invisibleContainer.className = 'fullscreenContainer';
        modalBody.className = 'modalConfirm shadow p-3 mb-5 bg-white rounded'
        modalMessage = document.createElement('h4');
        modalMessage.textContent = "Instructions to save as PDF";
        modalImg = document.createElement('img');
        modalImg.src = "assets/saveaspdfGuide.png";
        modalConfirm = document.createElement('input');
        modalConfirm.className = 'btn btn-primary okay';
        modalConfirm.type = 'button';
        modalConfirm.style = "font-size:15px; margin-left:45%;"
        modalConfirm.value = "Ok";
        modalBody.appendChild(modalMessage);
        modalBody.appendChild(modalImg);
        modalBody.appendChild(modalConfirm);
        invisibleContainer.appendChild(modalBody);
        modalConfirm.addEventListener('click', function(e) {
            invisibleContainer.remove();
            window.print();
        });
        document.body.appendChild(invisibleContainer);
    }

    function onLoad(year, month) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                console.log(myObj)
                var mainDiv = document.createElement('div');
                mainDiv.innerHTML += '<h4> Monthly Report (Based on the last date of each reservation) </h4>';
                if(myObj.length == 0){
                    mainDiv.innerHTML += '<h4> No reservations this month </h4>';
                }else{
                mainDiv.innerHTML += '<h4> Number of Reservations this month:' + myObj[2];
                document.getElementById('mainBody').appendChild(mainDiv);
                listRoomDetails(myObj[0], mainDiv);
                listEquipDetails(myObj[1],mainDiv);
                listBrokenEquipment(myObj[3],mainDiv)
                listBrokenEquipment(mainDiv);
                }
              
            }
        }
        xmlhttp.open("GET", "/Request_GenerateReport.php?month=" + month + '&year=' + year, true);
        xmlhttp.send();
    }

    function listRoomDetails(roomArr, mainDiv) {
        if(roomArr.length == 0){
            mainDiv.innerHTML += '<h4> No Room borrowed this month </h4>';
        }else{
        var newarr = [];
        for (c = 0; c < roomArr.length; c++) {
            newarr.push(roomArr[c].value)
        }
        var sum = newarr.reduce((a, b) => a + b, 0);
        mainDiv.innerHTML += '<h4> Number of Rooms Reserved this month:' + sum;
        var div = document.createElement('div');
        div.id = 'roomChartContainer';
        mainDiv.appendChild(div);
        anychart.onDocumentReady(function() {
            var chart = anychart.pie();
            chart.title("Rooms reserved");
            chart.legend().position("right");
            // set items layout
            chart.legend().itemsLayout("vertical");
            chart.data(roomArr);
            chart.container('roomChartContainer');
            chart.draw();
            var textarr = document.getElementsByClassName('anychart-credits')
            for(d = 0; d<textarr.length;d++){
                textarr[d].remove();
            }
        })
    }
    }
    function listEquipDetails(equipArr, mainDiv) {
        if(equipArr.length == 0){
            mainDiv.innerHTML += '<h4> No equipment borrowed this month </h4>';
        }else{
        var newarr = [];
        for (c = 0; c < equipArr.length; c++) {
            newarr.push(equipArr[c].value)
        }
        var sum = newarr.reduce((a, b) => a + b, 0);
        mainDiv.innerHTML += '<h4> Number of Equipment Reserved this month:' + sum;
        var div = document.createElement('div');
        div.id = 'equipChartContainer';
        mainDiv.appendChild(div);
        anychart.onDocumentReady(function() {
            var chart = anychart.pie();
            chart.title("Equipment reserved");
            chart.legend().position("right");
            // set items layout
            chart.legend().itemsLayout("vertical");
            chart.data(equipArr);
            chart.container('equipChartContainer');
            chart.draw();
            var textarr = document.getElementsByClassName('anychart-credits')
            for(d = 0; d<textarr.length;d++){
                textarr[d].remove();
            }
        })
    }
    }
    function listBrokenEquipment(brokenArr,mainDiv){
        console.log(brokenArr)
        if(brokenArr.length == 0){
            mainDiv.innerHTML += '<h4> No broken equipment this month </h4>';
        }else{
            var newarr = [];
        for (c = 0; c < brokenArr.length; c++) {
            newarr.push(brokenArr[c].value)
        }
        var sum = newarr.reduce((a, b) => a + b, 0);
        mainDiv.innerHTML += '<h4> Number of Equipment that broke/to be replaced this month:' + sum;
        var div = document.createElement('div');
        div.id = 'brokenChartContainer';
        mainDiv.appendChild(div);
        anychart.onDocumentReady(function() {
            var chart = anychart.pie();
            chart.title("Equipment reserved");
            chart.legend().position("right");
            // set items layout
            chart.legend().itemsLayout("vertical");
            chart.data(brokenArr);
            chart.container('brokenChartContainer');
            chart.draw();
            var textarr = document.getElementsByClassName('anychart-credits')
            for(d = 0; d<textarr.length;d++){
                textarr[d].remove();
            }
        })
        }
    }
</script>

</html>