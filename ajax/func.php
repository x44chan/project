<script type="text/javascript">
    function commentx() {
        postid = $("input[name = 'postid']").val();
        comment = $("input[name = 'comment']").val();
        accid = $("input[name = 'accid']").val();
        if(comment == "" || postid == ""){
            alert("Write your comment...");
        }else if(comment.length > 255){
            alert("You exceed 255 characters.");
        }else{
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("cmnt_tab").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET","ajax/ajaxowner.php?comment="+comment+"&postid="+postid+"&accid="+accid,true);
            xmlhttp.send();
            $("input[name = 'comment']").val("");
        }
    }
    setInterval(function(){
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("cmnt_tab").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajax/ajaxowner.php?refresh=1",true);
        xmlhttp.send();
    }, 1000);
</script>