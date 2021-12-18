<script>
    listCategPolicies();

    function callPolicies(ID, categ) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var mainDiv = document.getElementsByClassName('.policyDivs');
                myObj.forEach(async function(element, index) {
                    var x = listPolicyDetails(categ, element, index);
                })
                   if(categ.getElementsByTagName('div').length == 0){
                       categ.remove();
                   }
            }
        }
        xmlhttp.open("GET", "Request_AllPolicies.php", true);
        xmlhttp.send();
    }

    function listPolicyDetails(div, element, index) {
            if (div.id == element.p_ct_ID) {
                var div2 = document.createElement('div');
                div2.innerHTML = element.p_description + '<br>';
                div.appendChild(div2);
            }
    }

    function listCategPolicies() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var mainDiv = document.getElementById('policies');
                console.log(myObj);
                myObj.forEach(async function(element, index) {
                    var x = await listPolicies(mainDiv, element, index);
                    callPolicies(x[0], x[1]);
                });

            }
        }
        xmlhttp.open("GET", "Request_CategoryPolicies.php", true);
        xmlhttp.send();
    }

    function listPolicies(mainDiv, element, index) {
        var categories = document.createElement('div');
        categories.id = element.ct_p_ID;
        categories.className = 'policyDivs';
        categories.innerHTML +='<br>';
        var categoryType = document.createElement('p');
        categoryType.innerHTML = element.ct_p_Name + '<br>';
        categories.appendChild(categoryType);
        mainDiv.appendChild(categories);
        return new Promise(resolve => {
            resolve([element.ct_p_ID, categories]);
        });
    }
</script>