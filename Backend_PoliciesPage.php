<script>
    var functionRunning = false;
callCategories();
callPolicies();
if(functionRunning == false){
    callPolicies();
}
function callPolicies(){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var mainDiv = document.getElementById('policies');
                var insertDiv = mainDiv.getElementsByTagName('div');
                for(a = 0; a<insertDiv.length; a++){
                myObj.forEach(function(element,index){
                listPolicies(insertDiv[a],element,index);
                });
                }
            }
        }
        xmlhttp.open("GET", "Request_Policies.php", true);
        xmlhttp.send();
}
function callCategories(){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                myObj.forEach(listCategories);
            }
        }
        xmlhttp.open("GET", "Request_CategoryPolicies.php", true);
        xmlhttp.send();
}

function listCategories(element,index){
    var div = document.createElement('div');
    div.id = element.ct_Name;
    var img = document.createElement('img');
    img.alt = element.ct_Name;
    var mainDiv = document.getElementById('policies');
    div.appendChild(img);
    mainDiv.appendChild(div);
}

function listPolicies(insertDiv, element,index){
    if(insertDiv.id == element.p_category){
    console.log('me in');
    functionRunning = true;
    var div2 = document.createElement('div');
    div2.innerHTML = '*' + element.p_description + '<br>';
    insertDiv.appendChild(div2);
    }
  
}
</script>