<script>
    callCourseList();
        function callCourseList(){
                var  xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status==200){
                                 var myObj = JSON.parse(this.responseText);
                                 myObj.forEach(listOptions);
                            }
                        }
                        xmlhttp.open("GET", "Request_CourseList.php", true);
                        xmlhttp.send();
            }

        function listOptions(element, index){
            var selectID = document.getElementById("course");
            var options = document.createElement("option");
            options.text = element.courseName;
            options.value = element.courseID;
            selectID.add(options);
        }
    </script>