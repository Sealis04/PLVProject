<script>
    callPolicies();
    function callPolicies() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = async function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                var mainDiv = document.getElementById('policies');
                myObj.forEach(async function(element, index) {
                    var x = listPolicyDetails(mainDiv, element, index);
                })
            }
        }
        xmlhttp.open("GET", "Request_AllPolicies.php", true);
        xmlhttp.send();
    }

    function listPolicyDetails(div, element, index) {
        var categories = document.createElement('div');
        categories.id = element.p_ct_ID;
        categories.className = 'policyDivs';
        categories.innerHTML += '<br>';
        var dupe = false;
        document.querySelectorAll('.policyDivs').forEach(function(e) {
            if (e.id == element.p_ct_ID) {
                dupe = true;
            }
        })
        if (!dupe) {
            var categoryType = document.createElement('p');
            categoryType.innerHTML = element.p_category + '<br>';
            categories.appendChild(categoryType);
        }
        categories.innerHTML += element.p_description + '<br>';
        div.appendChild(categories);
    }
</script>