// Parse URL

function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") return;

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=", 2);
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) parms[n] = [];
        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}

sessionStorage.clear();

try {
	var data = parseURLParams(window.location.href);
	var id = data["id"];
	sessionStorage.setItem("id",id);
} catch (err){}

function sessionid(){
	return sessionStorage.getItem("id");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (event.target.matches('#calculationerror')) {
	  document.getElementById("calculationerror").style.display = "none";
  } 
	
  if (event.target.matches('#manningsmodal')) {
	  document.getElementById("manningsmodal").style.display = "none";
  } 
	
}

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

// See details

$("#seedetails").click(function(){
    if (document.getElementById("details").style.display == "block") {
		document.getElementById("details").style.display = "none";
	} else {
		document.getElementById("details").style.display = "block";
	}
});


// Select options

function iwanttofind() {
	if ($("#iwantto :selected").val() == "div_y" && $("#channeltype :selected").val() == "type_cus"){
		document.getElementById("div_vd").style.display = "none";
		document.getElementById("div_s").style.display = "none";
		document.getElementById("div_n").style.display = "none";
		document.getElementById("div_y").style.display = "none";
		document.getElementById("type_rec").style.display = "none";
		document.getElementById("type_tra").style.display = "none";
		document.getElementById("type_tri").style.display = "none";
		document.getElementById("type_cir").style.display = "none";
		document.getElementById("type_cus").style.display = "none";
		document.getElementById("div_nd_ca").style.display = "block";
	} else {
		document.getElementById("div_nd_ca").style.display = "none";
		var x = $("#iwantto :selected").val();
		document.getElementById("div_vd").style.display = "none";
		document.getElementById("div_s").style.display = "none";
		document.getElementById("div_n").style.display = "none";
		document.getElementById("div_y").style.display = "none";

		if (x != "div_null"){
			document.getElementById(x).style.display = "block";
			if ($("#channeltype :selected").val() == "type_null"){
				document.getElementById("channeltype").selectedIndex = "1";
				document.getElementById("type_rec").style.display = "block";
			}
		}
		
		if ($("#channeltype :selected").val() == "type_cus" && x != "div_y"){
			document.getElementById("type_cus").style.display = "block";
		}
	}
}

function channeltypefun() {
	if ($("#iwantto :selected").val() == "div_y" && $("#channeltype :selected").val() == "type_cus"){
		document.getElementById("div_vd").style.display = "none";
		document.getElementById("div_s").style.display = "none";
		document.getElementById("div_n").style.display = "none";
		document.getElementById("div_y").style.display = "none";
		document.getElementById("type_rec").style.display = "none";
		document.getElementById("type_tra").style.display = "none";
		document.getElementById("type_tri").style.display = "none";
		document.getElementById("type_cir").style.display = "none";
		document.getElementById("type_cus").style.display = "none";
		document.getElementById("div_nd_ca").style.display = "block";
	} else {
		document.getElementById("div_nd_ca").style.display = "none";
		var x = $("#channeltype :selected").val();
		document.getElementById("type_rec").style.display = "none";
		document.getElementById("type_tra").style.display = "none";
		document.getElementById("type_tri").style.display = "none";
		document.getElementById("type_cir").style.display = "none";
		document.getElementById("type_cus").style.display = "none";

		if (x != "type_null"){
			document.getElementById(x).style.display = "block";
		}
		
		if ($("#iwantto :selected").val() == "div_y" && x != "type_cus"){
			document.getElementById("div_y").style.display = "block";
		}
	}
}

$("#iwantto").change(iwanttofind);
$("#channeltype").change(channeltypefun);
$("#iwantto").change(clearoutput);
$("#channeltype").change(clearoutput);


// Fill results

function fillresults(data){
	if (data["id"] == "div_vd"){
		document.getElementById("vd_V").value = data["vd_V"];
		document.getElementById("vd_Q").value = data["vd_Q"];
	} else if (data["id"] == "div_s"){
		document.getElementById("s_s").value = data["s_s"];
	} else if (data["id"] == "div_n"){
		document.getElementById("n_n").value = data["n_n"];
	} else if (data["id"] == "div_y"){
		document.getElementById("y_y").value = data["y_y"];
		document.getElementById("y_V").value = data["y_V"];
	}
}


// Run calculation

$(document).ready(function() {
  $("#main").submit(function(e) {
    e.preventDefault();
    submitform();
  });
});

function submitform(){
	clearoutput();
    if (sessionid() != 'undefined' && sessionid() != null){
        $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/mannings_calculate.php',
        data: $('#main').serialize(),
        success: function (data) {
        	fillresults(data);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
            openmodalcalculationerror();
        }
        });
    } else {
        $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/mannings_calculate.php',
        data: $('#main').serialize(),
        success: function (data) {
			fillresults(data);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
            openmodalcalculationerror();
          
        }
        });
    }
}


// Load calculation from storage

try {
	if (sessionid() != 'undefined' && sessionid() != null){
		var id = sessionStorage.getItem('id');
		document.getElementById('sessionStorageID').value = id;
		var sessionvars = sessionvariables(id);
		
		document.getElementById("iwantto").selectedIndex = document.getElementById("option_"+sessionvars["iwantto"]).index;
		
		document.getElementById("channeltype").selectedIndex = document.getElementById("option_"+sessionvars["channeltype"]).index;
		
		iwanttofind()
		channeltypefun()
		
		// Add all text values
		$("#main input[type=text]").each(function() {
			if (sessionvars[this.name] != undefined){
				this.value = sessionvars[this.name];
			}
		});
	}
} catch (e) {console.log(e)}

function sessionvariables(id){
    var arr;        
    $.ajax({ 
        type: "Post",
        data: { sessionid: id},
        url: "php/getvariables.php",                     
        dataType: 'json',
        async: false,      
        success: function(data)          //on recieve of reply
        {
            arr = data;
            
        } 
    });
    return arr; 
}


// Sign up banner


if (sessionid() == 'undefined' || sessionid() == null){
	document.getElementById("signuphidden").innerHTML = "Want to save your calculation? Get access to premium features <b><a href='signup.php'>here.</a></b>"
} 


// Populate Select Forms

var filelists;        
$.ajax({ 
    type: "Post",
    url: "php/downloadlists.php",                     
    dataType: 'json',
    async: false,      
    success: function(data) 
    {
        filelists = data;
    } 
});

// Mannings

$(".mn").click(function(){
 	var id = $(this).attr('name');
 	document.getElementById("fillmannings").setAttribute("name",id);
 	document.getElementById("manningsmodal").style.display = "block";
});

$("#fillmannings").click(function(){
	var id = $(this).attr('name');
 	clearoutput();
	closeModal("manningsmodal");
	document.getElementById(id+"_n").value = document.getElementById("n_modal").value;
});

Mannings();

function Mannings(){
    var name = '[id="manningsselect"]';
    $(name).html('');
    var data = filelists['manningsn'];
    for (i = 0; i < data.length; i++) {
        $(name).append('<option value="'+data[i]["Detail"]+'">'+data[i]["Detail"]+'</option>');
    }
}

$("#manningsselect").change(function(){
	var value = $(this).val();
	var data = filelists['manningsn'];
    var nu = 0;
    for (a = 0; a < data.length; a++) {
        if (data[a]['Detail'] == value){
            nu = data[a]['Normal'];
        }
    }
    document.getElementById("n_modal").value = nu; 
});


$("#close_mn").click(function(){
  closeModal('manningsmodal');
});


// Error Modal

function openmodalcalculationerror(){
    try {
         document.getElementById("calculationerror").style.display = "block";
    }
    catch (err) {}
}

$("#close_ce").click(function(){
  closeModal('calculationerror');
});

$("#close_ce2").click(function(){
  closeModal('calculationerror');
});


// Clear Output

function clearoutput(){
	$("input.output:text").val("");
}

$("input").change(clearoutput);