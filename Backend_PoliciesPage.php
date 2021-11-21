<script>
listCategPolicies();
function callPolicies(){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var divs = document.querySelectorAll('.policyDivs');
               await myObj.forEach(async function(element,index){
                    await listPolicyDetails(divs,element,index);
                })
            }
        }
        xmlhttp.open("GET", "Request_AllPolicies.php", true);
        xmlhttp.send();
}
 function listPolicyDetails(div,element,index){
    for(a = 0; a<div.length; a++){
        if(div[a].id == element.p_ct_ID){
        var div2 = document.createElement('div');
        div2.innerHTML = element.p_description + '<br>';
        div[a].appendChild(div2);
        }
    }
}
 function listCategPolicies(){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var mainDiv = document.getElementById('policies');      
                await myObj.forEach(async function(element,index){
                await listPolicies(mainDiv,element,index);
                });
                callPolicies();
            }
        }
        xmlhttp.open("GET", "Request_CategoryPolicies.php", true);
        xmlhttp.send();
}
function listPolicies(mainDiv, element,index){
    var categories = document.createElement('div');
    categories.id = element.ct_ID;
    categories.className = 'policyDivs';
    var categoryType = document.createElement('p');
    categoryType.innerHTML = element.ct_Name + '<br>';
    categories.appendChild(categoryType);
    mainDiv.appendChild(categories);
    // categories.appendChild(categoryType);
    // var div2 = document.createElement('div');
    // div2.innerHTML = element.p_description + '<br>';
    // mainDiv.appendChild(categories);
    // mainDiv.appendChild(div2);
}
</script>