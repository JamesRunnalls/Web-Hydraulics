function openModal(xmodal) {
    if (xmodal == null){
         document.getElementById("myModal").style.display = "block";
    } else {
    document.getElementById(xmodal).style.display = "block";
    }
}

function closeModal(xmodal) {
     if (xmodal == null){
         document.getElementById("myModal").style.display = "none";
    } else {
    document.getElementById(xmodal).style.display = "none";
    }
}

function ajaxconnect(query){
    var arr;        
    $.ajax({ 
        type: "Post",
        url: "php/fileexplorerqueries.php",                     
        dataType: 'json',
        data: {query : query},
        async: false,      
        success: function(data)          //on recieve of reply
        {
            arr = data;
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
        } 
    });
    return arr; 
}

function ajaxconnectdelete(query){
    var arr;        
    $.ajax({ 
        type: "Post",
        url: "php/deletefile.php",                     
        dataType: 'json',
        data: {query : query},
        async: false,      
        success: function(data)          //on recieve of reply
        {
            arr = data;
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
        }
    });
    return arr; 
}

function ajaxconnectduplicate(query){
    var arr;        
    $.ajax({ 
        type: "Post",
        url: "php/duplicatefile.php",                     
        dataType: 'json',
        data: {query : query},
        async: false,      
        success: function(data)          //on recieve of reply
        {
            arr = data;
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
        }
    });
    return arr; 
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
	ev.originalEvent.dataTransfer.setData('text', ev.target.name);
}

function drop(ev) {
    ev.preventDefault();
    var origin = ev.originalEvent.dataTransfer.getData("text");
    var target = ev.target.name;
    // Add info to update location of file
    var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[origin]]);
    ajaxconnect(['UPDATE folder SET Parent = ? WHERE id = ? AND User = ?;',[target,origin]]);
    link(data[0]["Parent"]);
}

function moveup(id){
    var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[id]]);
    var parent = data[0]["Parent"];
    if (parent != "None"){
        var data2 = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[parent]]);
        ajaxconnect(['UPDATE folder SET Parent = ? WHERE id = ? AND User = ?;',[data2[0]["Parent"],id]]);
        link(data2[0]["Parent"]);
    }
}

function wordcompare(a,b){
	for (i = 0; i < Math.min(a.length,b.length); i++) {
		if (a.toUpperCase().charCodeAt(i) != b.toUpperCase().charCodeAt(i)){break}}
    if (a.toUpperCase().charCodeAt(i) > b.toUpperCase().charCodeAt(i)){
		return 1;
	} else if (a.toUpperCase().charCodeAt(i) < b.toUpperCase().charCodeAt(i)){
		return -1;
	} else {
		return 0;
	}
}

function updatehtml(parentid){
    var data = ajaxconnect(['SELECT * FROM folder where Parent = ? AND User = ?;',[parentid]]);
	if (data.length == 0 && parentid == 'None'){
		openModal("welcome");
	}
    data = data.sort(function(a, b) {
	    return wordcompare(a["Name"],b["Name"]);
	});
    data = data.sort(function(a, b) {
	    return wordcompare(a["Type"],b["Type"]);
	});	
    var check = document.getElementById('checkbox').checked;
    if (check == false){var innerhtml = "";}
    else {var innerhtml = '<div class="customtable"><a href="#"><div class="customrow2"><div class="customcell1"></div><div class="customcell2"><b>Name</b></div><div class="customcell3"><b>Type</b></div><div class="customcell4"><b>Desription</b></div></div></a></div>'}  
    for (i = 0; i < data.length; i++) {
        if (data[i]["Type"] == "folder"){
            var href = "#";
        } else {
        	var href = data[i]["Type"]+".php?id="+data[i]["id"];
        }
        if (check == false){
            var newinnerhtml = '<a href="'+href+'" name="'+data[i]["id"]+'" class="folder" draggable="true" id="'+data[i]["id"]+'"><img src="img/'+data[i]["Type"]+'.png" class="imgfe" name="'+data[i]["id"]+'" style="height:50px;margin-bottom:8px;"><br>'+data[i]["Name"]+'</a>';
            innerhtml = innerhtml + newinnerhtml;
        } else {
            var newinnerhtml = '<a href="'+href+'" name="'+data[i]["id"]+'" draggable="true" id="'+data[i]["id"]+'"><div class="customrow"><div class="customcell1"><img src="img/'+data[i]["Type"]+'.png" class="imgfe" name="'+data[i]["id"]+'" style="width:15px"></div><div class="customcell2">'+data[i]["Name"]+'</div><div class="customcell3">'+data[i]["Type"]+'</div><div class="customcell4">'+data[i]["Description"]+'</div></div></a>'
            innerhtml = innerhtml + newinnerhtml;
        }
        
    }
    if (check == true){innerhtml = innerhtml + "</div>"}
    document.getElementById("fileexplorer").innerHTML = innerhtml;
    for (i = 0; i < data.length; i++) {
        document.getElementById(data[i]["id"]).addEventListener("contextmenu", function(e){ cmenu(e,this.id)}, false);
        if (document.getElementById(data[i]["id"]).getAttribute("href") == "#"){
        	document.getElementById(data[i]["id"]).addEventListener("click",function(evt){link(evt.target.getAttribute("name"))});
        	$('#'+data[i]["id"]).on('dragstart', function(evt) {
			   drag(evt);
			});
			$('#'+data[i]["id"]).on('drop', function(evt) {
			   drop(evt);
			});
			$('#'+data[i]["id"]).on('dragover', function(evt) {
			   allowDrop(evt);
			});
        } else {
			$('#'+data[i]["id"]).on('dragstart', function(evt) {
			   drag(evt);
			});
        }
    }
    document.getElementById("fileexplorer").addEventListener("contextmenu", function(e){ cmenu2(e,this.id)}, false);
}

function cmenu(e,id){
    e.preventDefault();
    e.stopPropagation();
    const origin = {
        left: e.pageX,
        top: e.pageY
        };
    setPosition(origin);
    
    var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[id]]);
    document.getElementById("contextmenudelete").setAttribute("name",id);
    document.getElementById("contextmenumoveup").setAttribute("name",id);
    
    document.getElementById("contextmenuduplicate").setAttribute("name",id);
    document.getElementById("renamefilebutton").setAttribute("name",id);
    
    document.getElementById("renameinput").value = data[0]["Name"];
    document.getElementById("renamedescription").innerHTML = data[0]["Description"];  

}


$("#contextmenudelete").click(function(){
	deletefiles($(this).attr('name'));
});

$("#contextmenurename").click(function(){
	openModal('renamefolder');
});

$("#contextmenumoveup").click(function(){
	moveup($(this).attr('name'));
});

$("#contextmenuduplicate").click(function(){
	duplicate($(this).attr('name'));
});

$("#renamefilebutton").click(function(){
	renamefile($(this).attr('name'));
});


function cmenu2(e,id){
    e.preventDefault();
    const origin = {
        left: e.pageX,
        top: e.pageY
        };
    setPosition2(origin);
}

function renamefile(id){
    var newname = document.getElementById("renameinput").value;
    var newdesc = document.getElementById("renamedescription").value;
    ajaxconnect(['UPDATE folder SET Name = ? WHERE id = ? AND User = ?;',[newname,id]]);
    ajaxconnect(['UPDATE folder SET Description = ? WHERE id = ? AND User = ?;',[newdesc,id]]);
    var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[id]]);
    closeModal("renamefolder");
    link(data[0]["Parent"]);
}

function deletefiles(id){
    var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[id]]);
    if (confirm('Are you sure you want to delete this '+data[0]["Type"]+"?")){
        ajaxconnectdelete(id);
        link(data[0]["Parent"]);
    }
}

function duplicate(id){
    var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[id]]);
    ajaxconnectduplicate(id);
    link(data[0]["Parent"]);
}

function updatelocation(parentid){
    var location = []
    while (parentid != "None"){
        var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[parentid]]);
        location.unshift('<a href="javascript:link('+parentid+')">'+data[0]["Name"]+'</a>');
        parentid = data[0]["Parent"];
    }
    var innerhtml = "<a href='javascript:link(\"None\")'>Home</a>/" + location.join("/");
    document.getElementById("location").innerHTML = innerhtml;
}

function updateup(parentid){
    if (parentid != "None"){
        var data = ajaxconnect(['SELECT * FROM folder where id = ? AND User = ?;',[parentid]]);
        parentid = data[0]["Parent"];
        document.getElementById("up").setAttribute("name",parentid);
    }
}

function updatefilemodal(parentid){
    document.getElementById("newfileform").setAttribute("name",parentid);
}

function newfile(parentid){
    var name = document.getElementById("filename").value;
    var type = document.getElementById("filetype").value;
    var description = document.getElementById("description").value;
    ajaxconnect(["INSERT INTO `folder` (`id`, `Name`, `Parent`, `Type`, `Description`, `User`) VALUES (NULL, ?, ?, ?, ?, ?);",[name,parentid,type,description]]);
    closeModal('addfolder');
    link(parentid);
}

// Initial data load
updatehtml("None");

const contextmenu = document.querySelector(".contextmenu");
let menuVisible = false;

const contextmenu2 = document.querySelector(".contextmenu2");
let menuVisible2 = false;

const toggleMenu = function(command){
  contextmenu.style.display = command === "show" ? "block" : "none";
  menuVisible = !menuVisible;
};

const toggleMenu2 = function(command){
  contextmenu2.style.display = command === "show" ? "block" : "none";
  menuVisible2 = !menuVisible2;
};

const setPosition = function(top){
  contextmenu.style.left = top["left"]+'px';
  contextmenu.style.top = top["top"]+'px';
  toggleMenu("show");
};

const setPosition2 = function(top){
  contextmenu2.style.left = top["left"]+'px';
  contextmenu2.style.top = top["top"]+'px';
  toggleMenu2("show");
};

window.addEventListener("click", function(e){
  if(menuVisible)toggleMenu("hide");
  toggleMenu2("hide");
});

var incoming_hash = window.location.hash.substr(1);
if (incoming_hash == "pipeflow"){
	openModal("addfolder");
	document.getElementById("filetype").selectedIndex = "0";
} else if (incoming_hash == "mannings"){
	openModal("addfolder");
	document.getElementById("filetype").selectedIndex = "1";
} else if (incoming_hash == "darcyweisbach"){
	openModal("addfolder");
	document.getElementById("filetype").selectedIndex = "2";
} else if (incoming_hash == "weir"){
	openModal("addfolder");
	document.getElementById("filetype").selectedIndex = "3";
} else if (incoming_hash == "orifice"){
	openModal("addfolder");
	document.getElementById("filetype").selectedIndex = "4";
}

function link(parentid){
	try{
		toggleMenu2("hide");
	    updatehtml(parentid);
	    updatelocation(parentid);
	    updateup(parentid);
	    updatefilemodal(parentid);
	    document.getElementById("checkbox").setAttribute("name",parentid);
	} catch(err) {}
}


$("#contextmenu2newfile").click(function(){
  openModal('addfolder');
});

$("#plus").click(function(){
  openModal('addfolder');
});

$("#checkbox").change(function(){
	link($(this).attr('name'));
});

$("#up").click(function(){
	link($(this).attr('name'));
});

$("#newfileform").click(function(){
	newfile($(this).attr('name'));
});

$("#close_w").click(function(){
	closeModal('welcome');
});

$("#close_a").click(function(){
	closeModal('addfolder');
});

$("#close_r").click(function(){
	closeModal('renamefolder');
});

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (event.target.matches('#welcome')) {
	  document.getElementById("welcome").style.display = "none";
  } 
	
  if (event.target.matches('#addfolder')) {
	  document.getElementById("addfolder").style.display = "none";
  } 
	
  if (event.target.matches('#renamefolder')) {
	  document.getElementById("renamefolder").style.display = "none";
  } 
	
}