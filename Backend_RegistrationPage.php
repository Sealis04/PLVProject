<script>
    var select = document.getElementById('Type');
    select.addEventListener('change',callifUser);
    select.dispatchEvent(new Event('change'));
    function callifUser(e) {
        if(e.currentTarget.value == 1){
            var select2 = document.createElement('select');
            select2.id = 'course';
            var select3 = document.createElement('select');
            select3.id = 'section';
            var space = document.createElement('br');
            space.id ='spacing';
            e.currentTarget.parentElement.appendChild(space);
            e.currentTarget.parentElement.appendChild(select2);
            e.currentTarget.parentElement.appendChild(select3);
            callCourseList(select2);
            callSectionList(select3);
        }else{
            if(document.getElementById('course') && document.getElementById('section')){
                document.getElementById('course').remove();
                document.getElementById('spacing').remove();
                document.getElementById('section').remove();
            }
        }
    }
    function callCourseList(select) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                myObj.forEach(function(element,index){
                    listOptions(select,element,index)
                });
            }
        }
        xmlhttp.open("GET", "Request_CourseList.php", true);
        xmlhttp.send();
    }

    function callSectionList(select) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                myObj.forEach(function(element,index){
                    listSection(select,element,index)
                });
            }
        }
        xmlhttp.open("GET", "Request_SectionList.php", true);
        xmlhttp.send();
    }

    function listOptions(selectID, element, index) {
        var options = document.createElement("option");
        options.text = element.courseName;
        options.value = element.courseID;
        selectID.add(options);
    }

    function listSection(selectID,element, index) {
        var options = document.createElement("option");
        options.text = element.sectionName;
        options.value = element.sectionID;
        selectID.add(options);
    }
</script>