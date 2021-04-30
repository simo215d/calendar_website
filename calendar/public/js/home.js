let calendar_div = document.getElementById("calendar-container").innerHTML;
let id = "";

function TaskClicked(e) {
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    console.log("LOL: "+e.id+" w:  "+document.getElementById("calendar-container").offsetWidth+" token: "+csrf);
    //find id of task which is in element id at the end
    for (var i = 0; i < e.id.length; i++) {
        if (!isNaN(e.id.charAt(i))) {
            id = e.id.substring(i);
            break;
        }
    }
    //screen is not always same size
    let width = document.getElementById("calendar-container").offsetWidth;
    let y = e.offsetTop;
    //depending on which day the task belonged to we need to make the popup appear near it on the x axis aswell
    let x = "";
    switch (e.id.substring(0,6)) {
        case "divmon":x="1"; break;
        case "divtue":x="2"; break;
        case "divwed":x="3"; break;
        case "divthu":x="4"; break;
        case "divfri":x="5"; break;
        case "divsat":x="6"; break;
        case "divsun":x="6.2"; break;
    }
    x = (width/7)*x;
    let popupdiv = '<div style="background-color: pink;width: 150px;position: absolute;left:'+x+'px;top:'+y+'px;"> <form action="home.destroy"> <input type="text" style="display: none;" name="id" value="'+id+'" > <input type="hidden" name="_token" value="'+csrf+'"> <button type="submit">Delete</button> </form> <p>Edit task</p> <form action=""> <label for="">Task name</label> <input type="text" name="" id=""> <label for="">Time</label></br> <input type="time" name="" id=""></br> <input type="submit" value="update"> </form> </div>';
    document.getElementById("calendar-container").innerHTML = calendar_div+popupdiv;
}

function DeleteClicked() {
    /*var xhttp = new XMLHttpRequest();
    console.log("deleting task: "+id+"yoyo: {{$tasks}}");
    xhttp.open("POST", "/home.destroy", true);
    xhttp.send();*/
    //location.reload();
}

function GetTask(id) {
    
}