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
	
  if (event.target.matches('#minorlossmodal')) {
	  document.getElementById("minorlossmodal").style.display = "none";
  } 
	
  if (event.target.matches('#roughnessmodal')) {
	  document.getElementById("roughnessmodal").style.display = "none";
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
	clearoutput();
	var x = $("#iwantto :selected").val();
	document.getElementById("div_vd").style.display = "none";
	document.getElementById("div_h").style.display = "none";
	document.getElementById("div_L").style.display = "none";
	document.getElementById("div_D").style.display = "none";
	document.getElementById("div_ks").style.display = "none";
	document.getElementById("div_K").style.display = "none";
	
	if (x != "div_null"){
		document.getElementById(x).style.display = "block";
		if ($("#channeltype :selected").val() == "type_null"){
			document.getElementById("channeltype").selectedIndex = "1";
			document.getElementById("type_cir").style.display = "block";
		}
	}
	channeltypefun()
	diameter_rectangular_discharge()
}

function channeltypefun() {
	clearoutput();
	if ($("#iwantto :selected").val() == "div_D"){
		document.getElementById("type_rec").style.display = "none";
		document.getElementById("type_cir").style.display = "none";	
	} else {
		var x = $("#channeltype :selected").val();
		document.getElementById("type_rec").style.display = "none";
		document.getElementById("type_cir").style.display = "none";	
		if (x != "type_null"){
			document.getElementById(x).style.display = "block";
		}
	}
	diameter_rectangular_discharge()
}

$("#iwantto").change(iwanttofind);
$("#channeltype").change(channeltypefun);
$("#iwantto").change(clearoutput);
$("#channeltype").change(clearoutput);


// Fill results

function fillresults(data){
	if (data["id"] == "div_h"){
		document.getElementById("h_h").value = data["h_h"];
		document.getElementById("h_f").value = data["h_f"];
		document.getElementById("h_Re").value = data["h_Re"];
		document.getElementById("h_vd_out").value = data["h_vd_out"];
	} else if (data["id"] == "div_vd"){
		document.getElementById("vd_Q").value = data["vd_Q"];
		document.getElementById("vd_V").value = data["vd_V"];
		document.getElementById("vd_f").value = data["vd_f"];
		document.getElementById("vd_Re").value = data["vd_Re"];
	} else if (data["id"] == "div_L"){
		document.getElementById("L_L").value = data["L_L"];
		document.getElementById("L_f").value = data["L_f"];
		document.getElementById("L_Re").value = data["L_Re"];
		document.getElementById("L_vd_out").value = data["L_vd_out"];
	} else if (data["id"] == "div_D"){
		document.getElementById("D_D").value = data["D_D"];
		document.getElementById("D_f").value = data["D_f"];
		document.getElementById("D_Re").value = data["D_Re"];
		document.getElementById("D_vd_out").value = data["D_vd_out"];
	} else if (data["id"] == "div_K"){
		document.getElementById("K_K").value = data["K_K"];
		document.getElementById("K_f").value = data["K_f"];
		document.getElementById("K_Re").value = data["K_Re"];
		document.getElementById("K_vd_out").value = data["K_vd_out"];
	} else if (data["id"] == "div_ks"){
		document.getElementById("ks_ks").value = data["ks_ks"];
		document.getElementById("ks_f").value = data["ks_f"];
		document.getElementById("ks_Re").value = data["ks_Re"];
		document.getElementById("ks_vd_out").value = data["ks_vd_out"];
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
        url: 'php/darcyweisbach_calculate.php',
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
        url: 'php/darcyweisbach_calculate.php',
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
		
		// Discharge/ velocity
			
		var x = sessionvars["iwantto"].split("_")[1]+"_vd_select";
		var y = x+"_"+sessionvars[x];
		document.getElementById(x).selectedIndex = document.getElementById(y).index;
		vd_change(sessionvars[x]);
		
		// Add all text values
		$("#main input[type=text]").each(function() {
			if (sessionvars[this.name] != undefined){
				this.value = Number(sessionvars[this.name]);
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


// Minor Loss

$(".ml").click(function(){
 	var id = $(this).attr('name');
 	document.getElementById("fillminorloss").setAttribute("name",id);
	document.getElementById("minorlossmodal").style.display = "block";
});

$("#fillminorloss").click(function(){
	var id = $(this).attr('name');
 	clearoutput();
	closeModal("minorlossmodal");
	document.getElementById(id+"_K").value = document.getElementById("K_modal").value;
});

MinorLoss();

function MinorLoss(){
    var name = '[id="minorlossselect"]';
    $(name).html('');
    var data = filelists['minorloss'];
    for (i = 0; i < data.length; i++) {
        $(name).append('<option value="'+data[i]["Detail"]+'">'+data[i]["Detail"]+'</option>');
    }   
}

$("#minorlossselect").change(function(){
 	var value = $(this).val();
 	var data = filelists['minorloss'];
    var K = 0;
    for (a = 0; a < data.length; a++) {
        if (data[a]['Detail'] == value){
            K = data[a]['K'];
        }
    }
    document.getElementById("K_modal").value = K;  
});


$("#close_ml").click(function(){
  closeModal('minorlossmodal');
});


// Roughness 

$(".rm").click(function(){
 	var id = $(this).attr('name');
 	document.getElementById("fillroughness").setAttribute("name",id);
 	document.getElementById("roughnessmodal").style.display = "block";
});

$("#fillroughness").click(function(){
	var id = $(this).attr('name');
 	clearoutput();
	closeModal("roughnessmodal");
	document.getElementById(id+"_ks").value = document.getElementById("ks_modal").value;
});

Roughness();

function Roughness(){
    var name = '[id="roughnessselect"]';
    $(name).html('');
   var data = filelists['roughness'];
    for (i = 0; i < data.length; i++) {
        $(name).append('<option value="'+data[i]["Detail"]+'">'+data[i]["Detail"]+'</option>');
    } 
}

$("#roughnessselect").change(function(){
 	var value = $(this).val();
 	var data = filelists['roughness'];
    var ks = 0;
    for (a = 0; a < data.length; a++) {
        if (data[a]['Detail'] == value){
            ks = data[a]['Normal'];
        }
    }
	document.getElementById("ks_modal").value = ks;
});


$("#close_rm").click(function(){
  closeModal('roughnessmodal');
});


// Velocity Discharge Dropdown

function diameter_rectangular_discharge(){
	if ($("#iwantto :selected").val() == "div_D" && $("#channeltype :selected").val() == "type_rec"){
		document.getElementById("D_vd_select").selectedIndex = "0";
		document.getElementById("D_vd_select").options[1].disabled = true;
		vd_change('D');
	} else {
		document.getElementById("D_vd_select").options[1].disabled = false;
	}
}

function vd_change(type){
	clearoutput();
	var name = "#" + type + "_vd_select :selected" 
	var x = $(name).val();
	if (x == "V"){
		document.getElementById(type+"_units").innerHTML = "m/s";
		document.getElementById(type+"_label").innerHTML = "Flow Discharge";
		document.getElementById(type+"_units2").innerHTML = "m&sup3;/s";
	} else if (x == "Q"){
		document.getElementById(type+"_units").innerHTML = "m&sup3;/s";
		document.getElementById(type+"_label").innerHTML = "Flow Velocity";
		document.getElementById(type+"_units2").innerHTML = "m/s";
	}
}

$(".man_sel2").change(function(){
 	var id = $(this).attr('name');
 	var type = id.split("_")[0];
 	vd_change(type);
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