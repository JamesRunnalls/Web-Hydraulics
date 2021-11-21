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

// Verify if user is logged in 

function loggedin(){
	var log = "";
	$.ajax({
		type: 'post',
		dataType: 'text',
		async: false,
		url: 'php/loggedin.php',
		success: function (data) {
			log = data;
		},
		error: function(xhr, status, error) {
			console.log(xhr.responseText);
			console.log(error);
		}
	});
	return log;
}

// Example Caluclation

window.addEventListener("load", function(){
	window.wpcc.init({"colors":{"popup":{"background":"#f6f6f6","text":"#000000","border":"#555555"},"button":{"background":"#ffffff","text":"#000000","border":"#000000"}},"padding":"small","content":{"href":"#","message":"Want to try an example?","link":"<b>Click here.</b>","dismiss":"No thanks"},"position":"bottom-right"})
	$(".wpcc-privacy").removeAttr("href");
	$(".wpcc-privacy").click(function(){
		fillexample()
	});
});

function fillexample(){

	while (document.getElementById("sections").rows.length > 3) {DeleteSection();}	

	addRow('sections');
	addRow('sections');

	document.getElementById("Type&0").value = "Circular"
	blockinput(document.getElementById("Type&0"));
	document.getElementById("Diameter&0").value = 0.3;
	document.getElementById("Length&0").value = 30;
	document.getElementById("US&0").value = 9.6;
	document.getElementById("DS&0").value = 9.5;
	document.getElementById("dstransition&0").value = "None";
	document.getElementById("Ks&0").value = 0.00065;
	document.getElementById("n&0").value = 0.012;
	document.getElementById("K&0").value = 0;

	document.getElementById("Diameter&1").value = 0.3;
	document.getElementById("Length&1").value = 5;
	document.getElementById("US&1").value = 9.5;
	document.getElementById("DS&1").value = 8;
	document.getElementById("Ks&1").value = 0.00065;
	document.getElementById("n&1").value = 0.012;
	document.getElementById("K&1").value = 1;

	document.getElementById("Diameter&2").value = 0.3;
	document.getElementById("Length&2").value = 30;
	document.getElementById("US&2").value = 8;
	document.getElementById("DS&2").value = 7.9;
	document.getElementById("Ks&2").value = 0.00065;
	document.getElementById("n&2").value = 0.012;
	document.getElementById("K&2").value = 1;

	document.getElementById("freedischarge").checked = true;
	document.getElementById("u").value = 0.000015;
	document.getElementById("Qmin").value = 0.005;
	document.getElementById("Qmax").value = 0.015;
	document.getElementById("Qstep").value = 10;

	submitform();

	location.href = "#pipeprofile_anchor";
}

$("#examplecalc1").click(function(){fillexample()});
$("#examplecalc2").click(function(){fillexample()});

// Modal management
	
window.onclick = function(event) {
  if (event.target.matches('#calculationerror')) {
	  document.getElementById("calculationerror").style.display = "none";
  } 
  if (event.target.matches('#premiumfeature')) {
	  document.getElementById("premiumfeature").style.display = "none";
  }  
  if (event.target.matches('#calculationtimeexceeded')) {
	  document.getElementById("calculationtimeexceeded").style.display = "none";
  } 
  for(var i=0, l = 500; i < l; i++){
		try {
			if (document.getElementById("roughnessModal&"+i).style.display == "block"){
				var modal = document.getElementById("roughnessModal&"+i);
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
		} catch (e){}
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

function premiumfeatures(){
    openModal("premiumfeature");
}

$(".close").click(function(){
  closeModal(this.getAttribute("name"));
});

// Input data interactivity

$("#addrow").click(function(){
  addRow('sections');
});

function DeleteSection() {
    var x = document.getElementById("sections").rows.length;
    if (x > 3){
        var len = document.getElementById("sections").rows.length - 3;
        document.getElementById("sections").deleteRow(-1);
        document.getElementById("roughnessModal&"+len).remove();
    } 
}

$("#deleterow").click(function(){
  DeleteSection();
  validation();
});

function showhide() {
    if (document.getElementById('freedischarge').checked) {
        document.getElementById('fixheight').style.display = 'none';
        document.getElementById('sect').style.display = 'none';

        document.getElementById('dswidth').required = false;
        document.getElementById('dssideslope').required = false;
        document.getElementById('uselev').required = false;
        document.getElementById('slope').required = false;
        document.getElementById('manningsn').required = false;

        document.getElementById('dswl').required = false;
        
        document.getElementById('dswidth').removeAttribute("pattern");
        document.getElementById('dssideslope').removeAttribute("pattern");
        document.getElementById('uselev').removeAttribute("pattern");
        document.getElementById('slope').removeAttribute("pattern");
        document.getElementById('manningsn').removeAttribute("pattern");

        document.getElementById('dswl').removeAttribute("pattern");

    } else if (document.getElementById('fixedheight').checked){
        document.getElementById('sect').style.display = 'none';
        document.getElementById('fixheight').style.display = 'block';
        
        document.getElementById('dswidth').required = false;
        document.getElementById('dssideslope').required = false;
        document.getElementById('uselev').required = false;
        document.getElementById('slope').required = false;
        document.getElementById('manningsn').required = false;

        document.getElementById('dswl').required = true;
        
        document.getElementById('dswidth').removeAttribute("pattern");
        document.getElementById('dssideslope').removeAttribute("pattern");
        document.getElementById('uselev').removeAttribute("pattern");
        document.getElementById('slope').removeAttribute("pattern");
        document.getElementById('manningsn').removeAttribute("pattern");

        document.getElementById('dswl').pattern = "^(\\d*\\.)?\\d+$";
        
    } else {
        document.getElementById('fixheight').style.display = 'none';
        document.getElementById('sect').style.display = 'block';
        
        document.getElementById('dswidth').required = true;
        document.getElementById('dssideslope').required = true;
        document.getElementById('uselev').required = true;
        document.getElementById('slope').required = true;
        document.getElementById('manningsn').required = true;

        document.getElementById('dswl').required = false;
        
        document.getElementById('dswidth').pattern = "^(\\d*\\.)?\\d+$";
        document.getElementById('dssideslope').pattern = "^(\\d*\\.)?\\d+$";
        document.getElementById('uselev').pattern = "^(\\d*\\.)?\\d+$";
        document.getElementById('slope').pattern = "^(\\d*\\.)?\\d+$";
        document.getElementById('manningsn').pattern = "^(\\d*\\.)?\\d+$";

        document.getElementById('dswl').removeAttribute("pattern");
    }
}

$("#freedischarge").click(function(){
  showhide();
});

$("#fixedheight").click(function(){
  showhide();
});

$("#section").click(function(){
  showhide();
});

$(".Type").change(function(){
  blockinput(this);
});

$(".rwclass").click(function(){
  openmodal(this.getAttribute("name"));
});

// Downloads

function exportToCsv(filename, rows) {
    var processRow = function (row) {
        var finalVal = '';
        for (var j = 0; j < row.length; j++) {
            var innerValue = row[j] === null ? '' : row[j].toString();
            if (row[j] instanceof Date) {
                innerValue = row[j].toLocaleString();
            };
            var result = innerValue.replace(/"/g, '""');
            if (result.search(/("|,|\n)/g) >= 0)
                result = '"' + result + '"';
            if (j > 0)
                finalVal += ',';
            finalVal += result;
        }
        return finalVal + '\n';
    };

    var csvFile = '';
    for (var i = 0; i < rows.length; i++) {
        csvFile += processRow(rows[i]);
    }

    var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}

function downloadpipeprofile(){
    if (loggedin() == "True"){
		var json = loadfile();
        var keys = Object.keys(json);
        var flowrange = [];
        for (i = 0; i < keys.length; i++) {
            if (isNaN(parseFloat(keys[i]))){} else {
                flowrange.push(parseFloat(keys[i])); 
            }
        }
        var Q = closest($('#slider').slider("option", "value"),flowrange);
        var csvarray = [['Distance Along Pipe (m)','Hydraulic Grade Line (mAOD)','Bottom of Pipe (mAOD)','Top of Pipe (mAOD)','Water Surface Profile (mAOD)','Velocity (m/s)','Froude No']];
        for (i = 0; i < json[Q]['dt'].length; i++) {
            csvarray.push([json[Q]['dt'][i],json[Q]['k'][i],json[Q]['b'][i],json[Q]['t'][i],json[Q]['ws'][i],json[Q]['v'][i],json[Q]['fr'][i]]);
        }
        exportToCsv('pipeprofile_Q='+Q+'.csv', csvarray);
    } else {
        premiumfeatures();
    }
}

function downloadheaddischarge(){ 
    if (loggedin() == "True"){
		var json = loadfile();
        var csvarray = [['Discharge (m3/s)','Inlet Control Head (m)','Outlet Control Head (m)','Head (m)',]];
        for (i = 0; i < json['hd'][0].length; i++) {
            csvarray.push([json['hd'][1][i],json['hd'][0][i][0],json['hd'][0][i][1],json['hd'][0][i][2]]);
        }
        exportToCsv('headdischarge.csv', csvarray);
    } else {
        premiumfeatures();
    }
}

function downloadsummarytable(){
    if (loggedin() == "True"){
		var json = loadfile();
        var keys = Object.keys(json);
        var flowrange = [];
        for (i = 0; i < keys.length; i++) {
            if (isNaN(parseFloat(keys[i]))){} else {
                flowrange.push(parseFloat(keys[i])); 
            }
        }
        var Q = closest($('#slider2').slider("option", "value"),flowrange);
        var csvarray = [['Section','Type','Length (m)','Rise (m)','Slope','Normal Depth (m)','Critical Depth (m)','Flow Profile']];
        for (i = 1; i <= Object.keys(json['st'][Q]).length; i++) {
            csvarray.push([i,json['st'][Q][i]["Type"],json['st'][Q][i]["Length"],json['st'][Q][i]["h"],json['st'][Q][i]["Slope"],json['st'][Q][i]["normaldepth"],json['st'][Q][i]["criticaldepth"],json['st'][Q][i]["flowcurve"]]);
        }
        exportToCsv('summarytable_Q='+Q+'.csv', csvarray);
    } else {
        premiumfeatures();
    }
}

$("#downloadpipeprofile").click(function(){
  downloadpipeprofile();
});

$("#downloadheaddischarge").click(function(){
  downloadheaddischarge();
});

$("#downloadsummarytable").click(function(){
  downloadsummarytable();
});

// Error Reporting

function senderrorreport(){
    if (confirm("Please confirm you wish to submit an error report.")){
        $.ajax({
            type: 'post',
            dataType: 'json',
            async: false,
            url: 'php/reporterror.php',
            data: $('form').serialize(),
            success: function (data) {
                document.getElementById("calculationerror").style.display = "none";
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                document.getElementById("calculationerror").style.display = "none";
            }
            });
        alert("Thanks for submitting an error report. We will look into it and will respond by email after assessing the error and fixing any issues.")
    } else {
        document.getElementById("calculationerror").style.display = "none";
    }
}

$("#senderrorreport").click(function(){
  senderrorreport();
});

$("#senderrorreport2").click(function(){
  senderrorreport();
});

// Create Report

function createreport(){
    if (loggedin() == "True"){
        document.getElementById("report").submit();
    } else {
        premiumfeatures();
    }
}

$("#createreport").click(function(){
  createreport();
});

$("#createreport").click(function(){
  createreport();
});

$("#clogos").on('error', function(){
   $("#clogos").attr( "src", "img/logo.png" );
});
 



function jsontosession(json){
    sessionStorage.setItem("output", JSON.stringify(json));
}

function deleterow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    var no = r.name.split("&")[1];
    if (i != 1){
        document.getElementById("minorloss&"+no).deleteRow(i);
    }   
}

// Minor loss summation function
$(document.body).click( function() {
    $('*[id*=minorloss]:visible').each(function() {
        var nameid = this.id;
		var original = document.getElementById("totalk&" + nameid.split("&")[1]).value;
        var totalk = 0.0;
        var x=document.getElementById(nameid).tBodies[0];
        var l = document.getElementById(nameid).rows.length;
        for(var i=1, l = document.getElementById(nameid).rows.length; i < l; i++){
            totalk = totalk + (parseFloat(document.getElementById(nameid).rows[i].cells[1].childNodes[0].value) * parseFloat(document.getElementById(nameid).rows[i].cells[2].childNodes[0].value));
        }
		if (original != String(round(totalk,5))){
			document.getElementById("totalk&" + nameid.split("&")[1]).value = round(totalk,5);
			clear(nameid.split("&")[1]);
		}  
});

});

function round(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function blockinput(id){
    var name = id.name;
    name = name.split('&');
    var no = name[1];
    var value = id.value;
    if (value == "Circular"){
        document.getElementById("Width&"+no).readOnly = true;
        document.getElementById("Height&"+no).readOnly = true;
        document.getElementById("Diameter&"+no).readOnly = false;
        document.getElementById("Width&"+no).value = "";
        document.getElementById("Height&"+no).value = "";
    } else if (value == "Rectangular"){
        document.getElementById("Width&"+no).readOnly = false;
        document.getElementById("Height&"+no).readOnly = false;
        document.getElementById("Diameter&"+no).readOnly = true;
        document.getElementById("Diameter&"+no).value = "";
    }
}
    
function addRow(id){ 
    var x=document.getElementById(id).tBodies[0];  //get the table
    var l = document.getElementById(id).rows.length - 1;
    var node=x.rows[l].cloneNode(true); //clone the previous node or row
    // Find the row number
    var name = node.cells[0].childNodes[0].name;
    name = name.split('&');
    var newnumber = parseInt(name[1]) + 1
    for(var i=0, l = node.cells.length; i < l; i++){
        var name = node.cells[i].childNodes[0].name;
        name = name.split('&');
        var newname = name[0] + "&" + newnumber.toString();
        node.cells[i].childNodes[0].setAttribute('name',newname);
        node.cells[i].childNodes[0].setAttribute('id',newname);
    }
    x.appendChild(node);   //add the node or row to the table
    if (document.getElementById("Type&"+newnumber).value == "Circular"){
        document.getElementById("Width&"+newnumber).readOnly = true;
        document.getElementById("Height&"+newnumber).readOnly = true;
        document.getElementById("Diameter&"+newnumber).readOnly = false;
    } else {
        document.getElementById("Width&"+newnumber).readOnly = false;
        document.getElementById("Height&"+newnumber).readOnly = false;
        document.getElementById("Diameter&"+newnumber).readOnly = true;
    }
	validation_listener(newnumber);
	validation();
    createmodal(newnumber);
	$(".Type").off();
	$(".Type").change(function(){
	  blockinput(this);
	});
	$(".rwclass").off();
	$(".rwclass").click(function(){
	  openmodal(this.getAttribute("name"));
	});
}

function addRowmodal(id) {
     var x=document.getElementById(id).tBodies[0];  //get the table
      var l = document.getElementById(id).rows.length - 1;
      var node=x.rows[l].cloneNode(true); //clone the previous node or row
      // Find the row number
     if (node.cells[0].childNodes.length == 1){
             var name = node.cells[0].childNodes[0].name;
         } else {
             var name = node.cells[0].childNodes[1].name;
         }
     name = name.split('&');
     var newnumber = parseInt(name[2]) + 1
     for(var i=0, l = node.cells.length; i < l; i++){
         if (node.cells[i].childNodes.length == 1){
             var name = node.cells[i].childNodes[0].name;
             name = name.split('&');
             var newname = name[0] + "&" +name[1] + "&"+ newnumber.toString();
             node.cells[i].childNodes[0].setAttribute('name',newname);
             node.cells[i].childNodes[0].setAttribute('id',newname);
         } else {
             var name = node.cells[i].childNodes[1].name;
             name = name.split('&');
             var newname = name[0] + "&" +name[1] + "&"+ newnumber.toString();
             node.cells[i].childNodes[1].setAttribute('name',newname);
             node.cells[i].childNodes[1].setAttribute('id',newname);
         }
     }
      x.appendChild(node);   //add the node or row to the table
	  $(".mlclass").off();
	$(".mlclass").change(function(){
	  mlupdate(this);
	});
	$(".drclass").off();
	$(".drclass").click(function(){
	  deleterow(this);
	});
}

function addexactRowmodal(no,z) {
    var id ="minorloss&"+no;
    var x=document.getElementById(id).tBodies[0];  //get the table
    var l = document.getElementById(id).rows.length - 1;
    var node=x.rows[l].cloneNode(true); //clone the previous node or row
    // Find the row number
    if (node.cells[0].childNodes.length == 1){
        var name = node.cells[0].childNodes[0].name;
    } else {
        var name = node.cells[0].childNodes[1].name;
    }
    name = name.split('&');
    var newnumber = z;
    for(var i=0, l = node.cells.length; i < l; i++){
        if (node.cells[i].childNodes.length == 1){
            var name = node.cells[i].childNodes[0].name;
            name = name.split('&');
            var newname = name[0] + "&" +name[1] + "&"+ newnumber.toString();
            node.cells[i].childNodes[0].setAttribute('name',newname);
            node.cells[i].childNodes[0].setAttribute('id',newname);
        } else {
            var name = node.cells[i].childNodes[1].name;
            name = name.split('&');
            var newname = name[0] + "&" +name[1] + "&"+ newnumber.toString();
            node.cells[i].childNodes[1].setAttribute('name',newname);
            node.cells[i].childNodes[1].setAttribute('id',newname);
        }
    }
    x.appendChild(node);   //add the node or row to the table
	$(".mlclass").off();
	$(".mlclass").change(function(){
	  mlupdate(this);
	});
	$(".drclass").off();
	$(".drclass").click(function(){
	  deleterow(this);
	});
}

function exit(number){
    if (isNumeric(document.getElementById("totalk&"+number).innerHTML)){
        document.getElementsByName("K&"+number)[0].value = document.getElementById("totalk&"+number).innerHTML;
    } else {
        document.getElementsByName("K&"+number)[0].value = 0;
    }
    document.getElementsByName("n&"+number)[0].value = document.getElementsByName("mnvalue&"+number)[0].value;
    document.getElementsByName("Ks&"+number)[0].value = document.getElementsByName("ksvalue&"+number)[0].value;
    closeModal("roughnessModal&"+number);
    roughnessvallogic(number);
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
 
function multipleinputs(name,array){
    var x = [];
    for (var i = 0; i < 500; i++) {
        var fullname = name + "&" + i;
        if (array[fullname]) {
            // the variable is defined
            x.push(array[fullname]);
        }
    }
    return x;
}

function multipleinputslevel2(name,array){
    var out = [];
    for(var i = 0; i < 500; i++) {
        var t = [];
        for(var x = 0; x < 500; x++) {
            var fullname = name + "&" + i + "&" + x;
            if (array[fullname]) {
                // the variable is defined
                t.push(array[fullname]);
            }   
        }
        if (t.length > 0){
            out.push(t);
        }
    }
    return out;
}

function saveformvalues(){
    var form = $('form').serialize();
    var form = form.split('&');
    var varout = {};
    for(var i=0, l = form.length; i < l; i++){
        var elem = form[i].split('=');
        var key = elem[0].replace(/%26/g,"&").replace(/\+/g," ");
        var name = elem[1].replace(/%26/g,"&").replace(/\+/g," ");
        varout[key] = name;
    }

    // Save the length of the main form to session
    varout["Length"] = multipleinputs("Type",varout).length;

    // Need to add the selected values as an array.
    varout["TYP"] = multipleinputs("Type",varout);
    varout["DST"] = multipleinputs("dstransition",varout);
    varout["MAN"] = multipleinputs("manningslist",varout);
    varout["RGH"] = multipleinputs("colebrooklist",varout);
    varout["MLT"] = multipleinputslevel2("mltype",varout);

    sessionStorage.setItem("forminputs",JSON.stringify(varout));
    
}
    
$(document).ready(function() {
  $("#main").submit(function(e) {
    e.preventDefault();
    submitform();
  });
});

function submitform(){
	 document.getElementById("loader-text").innerHTML = "Calculating..";
    $('body').removeClass('loaded');
      cleargraphs();
      cleartable();
      try{
          $( "#slider" ).slider({slide: ""});
          $( "#slider2" ).slider({slide: ""});
           var handle = $( "#custom-handle" );
           var handle2 = $( "#custom-handle2" );
          handle.text = "";
          handle2.text = "";
      } catch(err){}
    if (loggedin() == "True"){
        $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/calculate.php',
        data: $('form').serialize(),
        success: function (data) {
          $('body').addClass('loaded');
            plotgraphs();
            resetgraphs();
          window.location.hash = "#pipeprofile_anchor";
        },
        error: function(xhr, status, error) {
            deletejson();
            console.log(xhr.responseText);
            console.log(error);
            $('body').addClass('loaded');
            openmodalcalculationerror();
        }
        });
    } else {
        // Save form values
        saveformvalues();
        $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/calculate.php',
        data: $('form').serialize(),
        success: function (data) {
            $('body').addClass('loaded');
            sessionStorage.setItem("output",JSON.stringify(data));
            plotgraphs();
            resetgraphs();
            window.location.hash = "#pipeprofile_anchor";
        },
        error: function(xhr, status, error) {
            try{
                sessionStorage.removeItem("output");
            } catch(err) {}
            console.log(xhr.responseText);
            console.log(error);
            $('body').addClass('loaded');
            
            if(xhr.responseText.includes("Maximum execution time")){
                openmodalcaltime(); 
            } else {
                openmodalcalculationerror();
            }   
        }
        });
    }
}

function deletejson(){
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/deletejson.php',
        data: $('form').serialize(),
        success: function (data) {
        }
        });
}





// VALIDATE FORM INPUT

$(document).ready(function() {
	validation();
	validation_listener(0);
	numbervalidation("u");
    numbervalidation("Qmin");
    numbervalidation("Qmax");
    flowstepvalidation();
    flowratevalidation();
});


function validation(){
	var count = $('#sections tr').length;
	for(var i=0, l = $('#sections tr').length-2; i < l; i++){
		elevationvalidation(i)
	}
}

function validation_listener(no){
	numbervalidation("Diameter&"+no);
    numbervalidation("Height&"+no);
    numbervalidation("Width&"+no);
    numbervalidation("Length&"+no);
    numbervalidation("US&"+no);
    numbervalidation("DS&"+no);
    numbervalidation("Ks&"+no);
    numbervalidation("n&"+no);
    elevationvalidation_lis(no);
    //roughnessvalidation(no)
}
               
function numbervalidation(name){
    var param = document.getElementById(name);
    param.addEventListener("input", function (event) {
        if (isNumber(param.value) && param.value > 0){
            param.setCustomValidity("");
        }
        else {
            param.setCustomValidity("Needs to be a positive number");
        }
    });
}

function elevationvalidation_US(no){
	var US = document.getElementById("US&"+no);
    var DS = document.getElementById("DS&"+no);
    if (parseFloat(no) > 0){
        var DSu = document.getElementById("DS&"+(no-1));
    } else {
        var DSu = document.getElementById("US&"+no);
    }
	if (parseFloat(no) > 0){
		var DSu = document.getElementById("DS&"+(no-1));
	} else {
		var DSu = document.getElementById("US&"+no);
	}
	if (parseFloat(DS.value) < parseFloat(US.value) && parseFloat(US.value) == parseFloat(DSu.value)){
		US.setCustomValidity("");
		DS.setCustomValidity("");
		DSu.setCustomValidity("");
	} else if (parseFloat(DS.value) >= parseFloat(US.value) && parseFloat(US.value) == parseFloat(DSu.value)){
		if (parseFloat(no) > 0){
			DSu.setCustomValidity("");
		}
		US.setCustomValidity("US IL needs to be above DS IL");
		DS.setCustomValidity("DS IL needs to be below US IL"); 
	} else {
		DS.setCustomValidity("");
		US.setCustomValidity("US IL of DS pipe needs to match DS IL of US pipe");
		DSu.setCustomValidity("US IL of DS pipe needs to match DS IL of US pipe");
	}
}

function elevationvalidation_DS(no){
	var US = document.getElementById("US&"+no);
    var DS = document.getElementById("DS&"+no);
    if (parseFloat(no) > 0){
        var DSu = document.getElementById("DS&"+(no-1));
    } else {
        var DSu = document.getElementById("US&"+no);
    }
	if (parseFloat(no) > 0){
		var DSu = document.getElementById("DS&"+(no-1));
	} else {
		var DSu = document.getElementById("US&"+no);
	}
	if (parseFloat(DS.value) < parseFloat(US.value) && parseFloat(US.value) == parseFloat(DSu.value)){
		US.setCustomValidity("");
		DS.setCustomValidity("");
		DSu.setCustomValidity("");
	} else if (parseFloat(DS.value) >= parseFloat(US.value) && parseFloat(US.value) == parseFloat(DSu.value)){
		if (parseFloat(no) > 0){
			DSu.setCustomValidity("");
		}
		US.setCustomValidity("US IL needs to be above DS IL");
		DS.setCustomValidity("DS IL needs to be below US IL"); 
	} else {
		DS.setCustomValidity("");
		US.setCustomValidity("US IL of DS pipe needs to match DS IL of US pipe");
		if (parseFloat(no) > 0){
			 DSu.setCustomValidity("US IL of DS pipe needs to match DS IL of US pipe");
		}

	}
}

function elevationvalidation_DSu(no){
	var US = document.getElementById("US&"+no);
    var DS = document.getElementById("DS&"+no);
    if (parseFloat(no) > 0){
        var DSu = document.getElementById("DS&"+(no-1));
    } else {
        var DSu = document.getElementById("US&"+no);
    }
	if (parseFloat(DS.value) < parseFloat(US.value) && parseFloat(US.value) == parseFloat(DSu.value)){
		US.setCustomValidity("");
		DS.setCustomValidity("");
		DSu.setCustomValidity("");
	} else if (parseFloat(DS.value) >= parseFloat(US.value) && parseFloat(US.value) == parseFloat(DSu.value)){
		if (parseFloat(no) > 0){
			DSu.setCustomValidity("");
		}
		US.setCustomValidity("US IL needs to be above DS IL");
		DS.setCustomValidity("DS IL needs to be below US IL"); 
	} else {
		DS.setCustomValidity("");
		US.setCustomValidity("US IL of DS pipe needs to match DS IL of US pipe");
		if (parseFloat(no) > 0){
			 DSu.setCustomValidity("US IL of DS pipe needs to match DS IL of US pipe");
		}
	}
}

function elevationvalidation_lis(no){
    var US = document.getElementById("US&"+no);
    var DS = document.getElementById("DS&"+no);
    
    if (parseFloat(no) > 0){
        var DSu = document.getElementById("DS&"+(no-1));
    } else {
        var DSu = document.getElementById("US&"+no);
    }
    
    US.addEventListener("input", function (event) {
        elevationvalidation_US(no);
    });
    
    DS.addEventListener("input", function (event) {
        elevationvalidation_DS(no);
    });
    
    DSu.addEventListener("input", function (event,DSu) {
        elevationvalidation_DSu(no);
    });
}

function elevationvalidation(no){
	elevationvalidation_US(no);
	elevationvalidation_DS(no);
	elevationvalidation_DSu(no);
}

function roughnessvalidation(no){
    var Ksdiv = document.getElementById("Ks&"+no);
    var ndiv = document.getElementById("n&"+no);
    var Kdiv = document.getElementById("K&"+no);
    var typediv = document.getElementById("Type&"+no);
    var diameterdiv = document.getElementById("Diameter&"+no);
    var heightdiv = document.getElementById("Height&"+no);
    var widthdiv = document.getElementById("Width&"+no);
    var lengthdiv = document.getElementById("Length&"+no);
    var USdiv = document.getElementById("US&"+no);
    var DSdiv = document.getElementById("DS&"+no);
    
    Ksdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    ndiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    Kdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    typediv.addEventListener("input", function (event) {roughnessvallogic(no)});
    diameterdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    heightdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    widthdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    lengthdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    USdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
    DSdiv.addEventListener("input", function (event) {roughnessvallogic(no)});
                        
}

function roughnessvallogic(no){
    var Ksdiv = document.getElementById("Ks&"+no);
    var ndiv = document.getElementById("n&"+no);
    var Kdiv = document.getElementById("K&"+no);

    // Get values:    
    var type = document.getElementById('Type&'+no).value;
    var us = parseFloat(document.getElementById('US&'+no).value);
    var ds = parseFloat(document.getElementById('DS&'+no).value);
    var L = parseFloat(document.getElementById('Length&'+no).value);
    var n = parseFloat(ndiv.value);
    var Ks = parseFloat(Ksdiv.value);
    if (isNaN(Kdiv.value)){
        K = 0;
    } else {
        K = parseFloat(Kdiv.value);
    }

    var u = parseFloat(document.getElementById('u').value);
    var S = (us - ds)/L;
    var de = (us - ds);
    if (type == "Circular"){
        var D = parseFloat(document.getElementById('Diameter&'+no).value);
        var A = Math.PI*(Math.pow((D/2),2));
        var P = Math.PI*D;        
    } else {
        var w = parseFloat(document.getElementById('Width&'+no).value);
        var h = parseFloat(document.getElementById('Height&'+no).value);
        var A = w * h;
        var P = 2*(w+h);   
        var D = (2*h*w)/(h+w);
    } 
    var mf = fullpipemanning(A,P,S,n);
    var cf = fullpipecolebrook(D,A,Ks,u,de,K,L);
    if (Math.abs(cf-mf) > 0.001){
        Ksdiv.setCustomValidity("Roughness values not well matched please use the roughness wizard.");
        ndiv.setCustomValidity("Roughness values not well matched please use the roughness wizard.");
        Kdiv.setCustomValidity("Roughness values not well matched please use the roughness wizard.");
    } else {
        Ksdiv.setCustomValidity("");
        ndiv.setCustomValidity("");
        Kdiv.setCustomValidity("");
    }
}
        
function flowratevalidation(){
    var min = document.getElementById("Qmin");
    var max = document.getElementById("Qmax");
    
    min.addEventListener("input", function (event) {
        var max = document.getElementById("Qmax");
        if (parseFloat(max.value) < parseFloat(min.value)){
            min.setCustomValidity("Minimum Flow need to be less than Maximum Flow");
            max.setCustomValidity("Maximum Flow need to be greater than Minimum Flow");
        } else {
            min.setCustomValidity("");
            max.setCustomValidity("");
        }
    });
    
    max.addEventListener("input", function (event) {
        var min = document.getElementById("Qmin");
        if (parseFloat(max.value) < parseFloat(min.value)){
            min.setCustomValidity("Minimum Flow need to be less than Maximum Flow");
            max.setCustomValidity("Maximum Flow need to be greater than Minimum Flow");
        } else {
            min.setCustomValidity("");
            max.setCustomValidity("");
        }
    });
}

function flowstepvalidation(){
    var param = document.getElementById("Qstep");
    param.addEventListener("input", function (event) {
        if (Number.isInteger(parseFloat(param.value)) && param.value > 0){
            param.setCustomValidity("");
        }
        else {
            param.setCustomValidity("Needs to be a positive integer");
        }
    });
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}



// ROUGHNESS CALCULATIONS

function iteratormannings(z,A,P,S){
    var y = 2*z;
    var a = 0;
    var x = 0.01;
	var maxitter = 1000;
	var itter = 0;
    for(var i=1, l = 50; i < l; i++){
        var x = x/2;
        while (y > z && itter < maxitter){
            a = a + x;
            y = fullpipemanning(A,P,S,a);
            if (y == undefined){
                y = 2*z;
            }
			itter = itter + 1;
        }
        y = 2*z;
        a = a - x;
    }
    return a;
}

function fullpipemanning(A,P,S,n) {  
    return (1/n)*A*(Math.pow((A/P),(2/3)))*(Math.pow(S,0.5));  
}

function iteratorcolebrook(z,D,A,u,de,K,L){
    var y = 2*z;
    var a = 0;
    var x = 0.001;
	var maxitter = 1000;
	var itter = 0;
    for(var i=1, l = 50; i < l; i++){
        var x = x/2;
        while (y > z && itter < maxitter){
            a = a + x;
            y = fullpipecolebrook(D,A,a,u,de,K,L);
            if (y == undefined){
                y = 2*z;
            }
			itter = itter + 1;
        }
        y = 2*z;
        a = a - x;
		itter = itter + 1;
    }
    return a;
}

function fullpipecolebrook(D,A,Ks,u,de,K,L){
    return fixedpoint2(0.01,D,A,Ks,u,de,K,L);
}

function fixedpoint2(x0,D,A,Ks,u,de,K,L){
    var rtol=1e-7;
    var maxiter=5; 
    var e = 1;
    var it = 0;
    while (e > rtol && it < maxiter){
        var x = dw(x0,D,A,Ks,u,de,K,L);
        e = Math.abs(x - x0)/Math.abs(x);
        x0 = x;
        it = it + 1;
    }
    return x;
}

function dw(Q,D,A,Ks,u,de,K,L){
    var sj = swameejain(D,A,Ks,u,Q);
    var f = fixedpoint(sj,Q,Ks,D,A,u);
    return A * (Math.pow(((2*9.81*de)/((f*(L/D))+K)),0.5));
}

function fixedpoint(x0,Q,Ks,D,A,u){
    var rtol=1e-7;
    var maxiter=50; 
    var e = 1;
    var it = 0;
    while (e > rtol && it < maxiter){
        var x = colebrookwhite(x0,Q,Ks,D,A,u);
        e = Math.abs(x - x0)/Math.abs(x);
        x0 = x;
        it = it + 1;
    }
    return x;
}

function colebrookwhite(f,Q,Ks,D,A,u){
    var Re = reynoldsnumber((Q/A),D,u);
    return 1/Math.pow((-2*Math.log10((2.51/(Re*(Math.pow(f,0.5)))) + (Ks/(3.7*D)))),2); 
}
    
function swameejain(D,A,Ks,u,Q){
    var Re = reynoldsnumber((Q/A),D,u);
    return 0.25 / Math.pow(Math.log10(((Ks/1000)/(3.7*D))+(5.74/(Math.pow(Re,0.9)))),2);
}

function reynoldsnumber(V,D,u){
    return (V*D)/u;
}

function isntnumber(x){
	if (isNaN(x) || isNaN(parseInt(x))){
		return true; 
	}
}

function comparecoefficients(id){
	document.getElementById("comparetext&"+id).innerHTML = "Running...";
	var button = "";
    // Get values:    
    var type = document.getElementById('Type&'+id).value;
    var us = document.getElementById('US&'+id).value;
    var ds = document.getElementById('DS&'+id).value;
    var L = document.getElementById('Length&'+id).value;
    var Ks = document.getElementById('ksvalue&'+id).value;
    var n = document.getElementById('mnvalue&'+id).value;
    var K = document.getElementById('totalk&'+id).innerHTML;
	
	if (isntnumber(us) || isntnumber(ds) || isntnumber(L)){
		var text = "<br>Please ensure you have entered the all the pipe properties in the main table before running this tool.";
	} else if (type == "Circular" && isntnumber(document.getElementById('Diameter&'+id).value)){
		var text = "<br>Please ensure you have entered the pipe diameter in the main table before running this tool.";		   
	} else if (type == "Rectangular" && (isntnumber(document.getElementById('Width&'+id).value) || isntnumber(document.getElementById('Height&'+id).value))){
		var text = "<br>Please ensure you have entered the pipe dimentions in the main table before running this tool.";	
	} else if (isntnumber(Ks) || isntnumber(n)) {
		var text = "<br>Please ensure you have entered roughness values before running this tool.";		
	} else if (n > 0.5 || n < 0.005){
		var text = "<br>Values of mannings n outside of the range 0.005 < n < 0.5 are not reasonable. Please adjust your value of mannings n.";	
	} else if (Ks > 0.5 || Ks < 0.0000001){
		var text = "<br>Values of roughness coefficient ks outside of the range 0.0000001 < ks < 0.5 are not reasonable. Please adjust your value of roughness coefficient ks.";	
	} else {
		try{
			if (isntnumber(K)){
				K = 0;
			} else {
				K = parseFloat(K);
			}
			var u = parseFloat(document.getElementById('u').value);
			var S = (us - ds)/L;
			var de = (us - ds);
			if (type == "Circular"){
				var D = parseFloat(document.getElementById('Diameter&'+id).value);
				var A = Math.PI*(Math.pow((D/2),2));
				var P = Math.PI*D;        
			} else {
				var w = parseFloat(document.getElementById('Width&'+id).value);
				var h = parseFloat(document.getElementById('Height&'+id).value);
				var A = w * h;
				var P = 2*(w+h);   
				var D = (2*h*w)/(h+w);
			} 
			var mf = fullpipemanning(A,P,S,n);
			var cf = fullpipecolebrook(D,A,Ks,u,de,K,L);
			if (Math.abs(cf-mf) > 0.001){
				if (cf < mf){
					var x = iteratormannings(cf,A,P,S);
					
					// Check result
					var mf_test = fullpipemanning(A,P,S,x);
					var cf_test = fullpipecolebrook(D,A,Ks,u,de,K,L);
					
					if (Math.abs(cf_test-mf_test) > 0.001){
						var text = "<br>Appologies the calculator failed to find an appropriate mannings n to allow for your Ks value, please adjust your values and try again.";
					} else {
						var text = '<br>Suggest increasing mannings n to: '+x+' for roughness factor: '+Ks+' to ensure smooth transition from unpressurised to pressurised pipe flow.<br><br>';
						button = 1;
					}
					
				} else if (mf < cf) {
					//var x = 1;
					var x = iteratorcolebrook(mf,D,A,u,de,K,L);
					
					// Check result
					var mf_test = fullpipemanning(A,P,S,n);
					var cf_test = fullpipecolebrook(D,A,x,u,de,K,L);
					
					if (Math.abs(cf_test-mf_test) > 0.001){
						var text = "<br>Appologies the calculator failed to find an appropriate roughness coefficient ks to allow for your n value, please adjust your values and try again.";
					} else {
						var text = '<br>Suggest increasing roughness factor ks to: '+x+' for mannings n: '+n+' to ensure smooth transition from unpressurised to pressurised pipe flow.<br><br>';
						button = 2;
					}
				}
			} else {
				var text = "<br>Mannings n and roughness factor are well matched at pipe full.";
			}   
		} catch (err){
			console.log(err);
			var text = "<br>Appologies the calculator failed please adjust your values and try again.";
		}
		
	}
    document.getElementById("comparetext&"+id).innerHTML = text;
	if (button == "1"){
		document.getElementById("button&"+id).style.display = "block";
		document.getElementById("button&"+id).addEventListener("click", function(){
		  updatevalues(id,x,Ks);
		});
	} else if (button == "2"){
		document.getElementById("button&"+id).style.display = "block";
		document.getElementById("button&"+id).addEventListener("click", function(){
		  updatevalues(id,n,x);
		});
	} else {
		document.getElementById("button&"+id).style.display = "none";
	}
}

function updatevalues(id,mf,cf){
	document.getElementById("mnvalue&"+id).value = mf;
	document.getElementById("ksvalue&"+id).value = cf;
	comparecoefficients(id);
}

function clear(id){
    document.getElementById("comparetext&"+id).innerHTML = "";
	document.getElementById("button&"+id).style.display = "none";
}

// POPULATE SELECT FORMS

// Download forms
var filelists;        
$.ajax({ 
    type: "Post",
    url: "php/downloadlists.php",                     
    dataType: 'json',
    async: false,      
    success: function(data)          //on recieve of reply
    {
        filelists = data;
    },
    error: function(xhr, status, error) {
        console.log(xhr.responseText);
        console.log(error);
    }
});

function InputType(arr){
    $('#InputType').html('');
    var data = filelists['shape'];
    for (i = 0; i < data.length; i++) {
        var selected = "";
            if (data[i]["Shape"] == arr){
                selected = "selected";
            }
        $('#InputType').append('<option '+selected+' value="'+data[i]["Shape"]+'">'+data[i]["Shape"]+'</option>');
    }
}

function InputDetail(arr){
    $('#InputDetail').html('');
    var data = filelists['inlet'];
    for (i = 0; i < data.length; i++) {
        if (data[i]["inlettype"] == $('#InputType').val()){
            var selected = "";
                if (data[i]["inletconfig"] == arr){
                    selected = "selected";
                }
            $('#InputDetail').append('<option '+selected+' value="'+data[i]["inletconfig"]+'">'+data[i]["inletconfig"]+'</option>');
        }
    }
}

function Type(arr){
    for (x = 0; x < arr.length; x++) {
        var name = '[id="Type&'+x+'"]';
        $(name).html('');
        var data = filelists['shape'];
        for (i = 0; i < data.length; i++) {
            var selected = "";
            if (data[i]["Shape"] == arr[x]){
                selected = "selected";
            }
            $(name).append('<option '+selected+' value="'+data[i]["Shape"]+'">'+data[i]["Shape"]+'</option>');
        }
        blockinput(document.getElementById('Type&'+x));
    }
}

function Transition(arr){
    for (x = 0; x < arr.length; x++) {
        var name = '[id="dstransition&'+x+'"]';
        $(name).html('');
        var data = filelists['transition'];
        for (i = 0; i < data.length; i++) {
            var selected = "";
            if (data[i]["Value"] == arr[x]){
                selected = "selected";
            }
            $(name).append('<option '+selected+' value="'+data[i]["Value"]+'">'+data[i]["Detail"]+'</option>');
        }
    }
}

function Mannings(x){
    var name = '[id="manningslist&'+x+'"]';
    $(name).html('');
    var data = filelists['manningsn'];
    for (i = 0; i < data.length; i++) {
        $(name).append('<option value="'+data[i]["Detail"]+'">'+data[i]["Detail"]+'</option>');
    }
}

function Roughness(x){
    var name = '[id="colebrooklist&'+x+'"]';
    $(name).html('');
   var data = filelists['roughness'];
    for (i = 0; i < data.length; i++) {
        $(name).append('<option value="'+data[i]["Detail"]+'">'+data[i]["Detail"]+'</option>');
    } 
}

function MinorLoss(x,y){
    var name = '[id="mltype&'+x+'&'+y+'"]';
    $(name).html('');
    var data = filelists['minorloss'];
    for (i = 0; i < data.length; i++) {
        $(name).append('<option value="'+data[i]["Detail"]+'">'+data[i]["Detail"]+'</option>');
    }   
}

function mlupdate(id){
    var data = filelists['minorloss'];
    var name = id.name;
    var value = id.value;
    var K = 0;
    for (a = 0; a < data.length; a++) {
        if (data[a]['Detail'] == value){
            K = data[a]['K'];
        }
    }
    name = name.split('&');
    var tempname = "mlvalue&"+name[1]+"&"+name[2]
    document.getElementsByName(tempname)[0].value = K;
}

function nupdate(id){
    var data = filelists['manningsn'];
    var value = id.value;
    var nu = 0;
    for (a = 0; a < data.length; a++) {
        if (data[a]['Detail'] == value){
            nu = data[a]['Normal'];
        }
    }
    document.getElementsByName("mnvalue&"+id.name.split('&')[1])[0].value = nu;
    clear(id.name.split('&')[1]);
}

function ksupdate(id){
    var data = filelists['roughness'];
    var value = id.value;
    var ks = 0;
    for (a = 0; a < data.length; a++) {
        if (data[a]['Detail'] == value){
            ks = data[a]['Normal'];
        }
    }
    document.getElementsByName("ksvalue&"+id.name.split('&')[1])[0].value = ks;
    clear(id.name.split('&')[1]);
}

$( "#InputType" ).change(function(){InputDetail()});

// ROUGHNESS MODAL

function openmodal(id){
    var no = id.split('&')[1];
    var xmodal = "roughnessModal&"+no;
    try {
         document.getElementById(xmodal).style.display = "block";
    }
    catch (err) {
    createmodal(no);  
    document.getElementById(xmodal).style.display = "block";    
  
    }
}

function openmodalcalculationerror(){
    try {
         document.getElementById("calculationerror").style.display = "block";
    }
    catch (err) {}
}

function openmodalcaltime(){
    try {
         document.getElementById("calculationtimeexceeded").style.display = "block";
    }
    catch (err) {}
}

function createmodal(no){
    var xmodal = "roughnessModal&"+no;
    try {
         document.getElementById(xmodal).style.display = "block";
         document.getElementById(xmodal).style.display = "none";
    }
    catch (err) {
        var inner = '<div id="roughnessModal&'+no+'" class="modal">' +
        '<div class="modal-content-hidden">' +
        '<span name="roughnessModal&'+no+'" class="close">&times;</span>' +
        '<div class="modal-text">' +
            '<h3 style="font-size:35px;">Roughness Wizard</h3>' +
			'Use the roughness wizard to match your mannings n and roughness factors.<br>' + 
            '<h4 style="font-size:20px;">Minor Losses</h4>'+
            '<table id="minorloss&'+no+'" name="minorloss&'+no+'">' +
                '<tr>' +
                    '<th>Type</th>' +
                    '<th>Value</th>' +
                    '<th>Quanity</th>' +
                '</tr>' +
                '<tr>' +
                    '<td><select id="mltype&'+no+'&0" name="mltype&'+no+'&0" class="mlclass" style="width:200px"></select></td>' +
                    '<td><input id="mlvalue&'+no+'&0" name="mlvalue&'+no+'&0" type="text" size="4"></td>' +
                    '<td><input id="mlquanity&'+no+'&0" name="mlquanity&'+no+'&0" type="text" size="4"></td>' +
                    '<td><button type="button" name="deleterow&'+no+'&0" value="Delete" class="drclass">Delete</button></td>' +
                '</tr>' +
            '</table>' +
            '<button type="button" class="admlclass" name="minorloss&'+no+'" id="minorloss&'+no+'">+ Add Minor Loss</button>' +
            '<br>Total minor loss co-efficient: <input class="clear" name="'+no+'" id="totalk&'+no+'" style="display: inline" type="text" size="4">' +

            '<h4 style="font-size:20px;">Mannings n </h4>' +
            '<table>' +
                '<tr>' +
                    '<th>Material</th>' +
                    '<th>Mannings n</th>' +
                '</tr>' +
                '<tr>' +
                    '<td><select id="manningslist&'+no+'" name="manningslist&'+no+'" class="manningslist" style="width:200px"></select></td>' +
                    '<td><input class="mnvalue" id="mnvalue&'+no+'" style="width:120px" name="mnvalue&'+no+'" type="text" size="4"></td>' +
                '</tr>' +
            '</table>' +

            '<h4 style="font-size:20px;">Roughness Factor Ks</h4>' +
            '<table>' +
                '<tr>' +
                    '<th>Material</th>' +
                    '<th>Roughness Ks (m)</th>' +
                '</tr>' +
                '<tr>' +
                    '<td><select id="colebrooklist&'+no+'" name="colebrooklist&'+no+'" class="colebrooklist" style="width:200px"></select></td>' +
                    '<td><input class="ksvalue" id="ksvalue&'+no+'" style="width:120px" name="ksvalue&'+no+'" type="text" size="4"></td>' +
                '</tr>' +
            '</table>' +
            '<br><br>' +
            '<center><button id="checkbutton&'+no+'" name="checkbutton&'+no+'" type="button" class="comparecoefficients">Check Compatability of Mannings n and Roughness Factor Ks</button>' +
            '<div style="text-align:left;width:450px;" id="comparetext&'+no+'"></div><button type="button" style="display:none" id="button&'+no+'">Update Values</button><br><br>    ' +
            '<button type="button" name="rmexit&'+no+'" class="rmexit">Save and Return to Input</button></center><br><br>'+
            '</div>' +
        '</div>' +
        '</div>';
        var mydiv = document.getElementById('dynamicmodal');
        var newcontent = document.createElement('div');
        newcontent.innerHTML = inner;
        while (newcontent.firstChild) {
            mydiv.appendChild(newcontent.firstChild);
        }
        Mannings(no);
        Roughness(no);
        MinorLoss(no,0);
		
		// Add event listeners.
		
		$(".close").off();
		$(".close").click(function(){
		  closeModal(this.getAttribute("name"));
		});
		$(".mlclass").off();
		$(".mlclass").change(function(){
		  mlupdate(this);
		});
		$(".drclass").off();
		$(".drclass").click(function(){
		  deleterow(this);
		});
		$(".admlclass").off();
		$(".admlclass").click(function(){
		  addRowmodal(this.getAttribute("name"));
		});
		$(".manningslist").off();
		$(".manningslist").change(function(){
		  nupdate(this);
		});
		$(".colebrooklist").off();
		$(".colebrooklist").change(function(){
		  ksupdate(this);
		});
		$(".mnvalue").off();
		$(".mnvalue").change(function(){
			var x = this.getAttribute("name").split("&")[1];
		  	clear(x);
		});
		$(".ksvalue").off();
		$(".ksvalue").change(function(){
			var x = this.getAttribute("name").split("&")[1];
		  	clear(x);
		});
		$(".comparecoefficients").off();
		$(".comparecoefficients").click(function(){
			var x = this.getAttribute("name").split("&")[1];
		  	comparecoefficients(x);
		});
		$(".rmexit").off();
		$(".rmexit").click(function(){
			var x = this.getAttribute("name").split("&")[1];
		  	exit(x);
		});		
    }
}

// LOAD FORM PARAMETERS

// Find out if there is a session variable set
var id = sessionStorage.getItem('id');
if (typeof id == 'undefined'){
    window.onload = InputType();
    window.onload = InputDetail();
    window.onload = Type(["Circular"]);
    window.onload = Transition(["None"]);
    window.onload = createmodal(0);
} else {
    try {
        if (loggedin() == "True"){
            // Update hidden session value
            document.getElementById('sessionStorageID').value = id;
            document.getElementById('sessionStorageID2').value = id;
            document.getElementById('clogos').src = 'img/users/'+id+'.png';
            // Get data from database.
            var sessionvars = sessionvariables(id);
            var reportvars = reportvariables(id);
        } else {
            var sessionvars = JSON.parse(sessionStorage.getItem("forminputs"));
            document.getElementById('clogos').src = 'img/logo.png';
        }
        
        // Create the initial modal and inputs
        var svMLT = sessionvars["MLT"];
        createmodal(0);
        for (i = 1; i < svMLT[0].length; i++) { 
            addexactRowmodal(0,i);
        }
        InputType(sessionvars["InputType"]);
        InputDetail(sessionvars["InputDetail"]);
        // Add rows and create modals
        var L = sessionvars["Length"];
        for (k = 1; k < L; k++) {
            addRow('sections');
            createmodal(k);
            for (z = 1; z < svMLT[k].length; z++) {
                addexactRowmodal(k,z);
            }
        }
        // Add selection fields
        Type(sessionvars["TYP"]);
        Transition(sessionvars["DST"]);
        var man = sessionvars["MAN"];
        var rgh = sessionvars["RGH"];
        for (a = 0; a < man.length; a++) {
            var id = "manningslist&"+a;
            document.getElementById(id).value = man[a];
        }
        for (a = 0; a < rgh.length; a++) {
            var id = "colebrooklist&"+a;
            document.getElementById(id).value = rgh[a];
        }
        for (a = 0; a < svMLT.length; a++) {
            for (p = 0; p < svMLT[a].length; p++) {
                var id = "mltype&"+a+"&"+p;
                document.getElementById(id).value = svMLT[a][p];
            }
        }
        // Add all text values
        $("#main input[type=text]").each(function() {
            if (sessionvars[this.name] != undefined){
                this.value = sessionvars[this.name];
            }
        });
        $("#report input[type=text]").each(function() {
            if (reportvars[this.name] != undefined){
                this.value = reportvars[this.name];
            } 
        });
        
        document.getElementById("cd").value = reportvars["cd"];
        
        // DS section tick
        var dstype = sessionvars["dstype"];
        document.getElementById(dstype).checked = true;
        
        // Open DS section details
        showhide();
    } catch (err) {
		console.log(err);
        window.onload = InputType();
        window.onload = InputDetail();
        window.onload = Type(["Circular"]);
        window.onload = Transition(["None"]);
        window.onload = createmodal(0);
    }
}

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

function reportvariables(id){
    var arr;        
    $.ajax({ 
        type: "Post",
        data: { sessionid: id},
        url: "php/getreportvariables.php",                     
        dataType: 'json',
        async: false,      
        success: function(data)          //on recieve of reply
        {
            arr = data;
            
        } 
    });
    return arr; 
}

// LOAD GRAPHS

// Global variables
var gs = [];
var hd = "";
var maxx = "";
var maxy = "";
var minx = "";
var miny = "";

function loadfile(){
    try {
       if (loggedin() == "True"){
            var name = document.getElementById('sessionStorageID').value;
            name = "json/"+ name.toString() + ".json";
            json = (function() {
            json = null;
            $.ajax({
                'async': false,
                'global': false,
                'url': name,
                'dataType': "json",
                'success': function (data) {
                    json = data;
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(error);
                }
            });
            return json;
            })();
        } else {
            var json = JSON.parse(sessionStorage.getItem('output'));
        }
        return json; 
    } catch (err) {
        console.log(err);
        return "None";
    } 
}

// Load data
function plotgraphs(){
    var json = loadfile();
    if (json != "None" && json != "none"){
        createrangeslider(json);
        createrangeslider2(json);
        addheaddischargedata(json);
        var keys = Object.keys(json);
        var flowrange = [];
        for (i = 0; i < keys.length; i++) {
            if (isNaN(parseFloat(keys[i]))){} else {
                flowrange.push(parseFloat(keys[i])); 
            }
        }
        var Qmax = Math.max.apply(Math, flowrange);
        var Qmin = Math.min.apply(Math, flowrange);
        if (flowrange.length > 1){
            var Qstep = (Qmax - Qmin) / (flowrange.length - 1);
        } else {
            var Qstep = 0;
        }
        var Qvalue = flowrange[Math.ceil(flowrange.length/2)-1];
        addpipeprofiledata(Qvalue,json);
        plottable(Qvalue,json);
    } else {
        console.log("No Data");
    }
}

// Load blank graphs on page load
$(document).ready(function(){ 
    gs.push(
        new Dygraph(
            document.getElementById("graphdiv"),
            [],
            {   customBars: true,
                errorBars: true,
                colors: ["#0095D1","black","black","#0095D1"],            
                labels: [ "x", "Hydraulic Grade Line", "Bottom of Section", "Top of Section", "Water Surface Profile" ],
                legend: 'always',
                legendFormatter: legendFormatter,
                zoomCallback: function(minDate, maxDate, maxValue) {
                    maxx = maxDate;
                    maxy = maxValue[0][1];
                    minx = minDate;
                    miny = maxValue[0][0];
                },
                axes: {
                    y: {
                        drawGrid: false
                    },
                    x: {
                        drawGrid: false
                    }
                },
                ylabel: 'Elevation (mAOD)',
            }
        )
    )

    gs.push(
        new Dygraph(
            document.getElementById("graphdiv2"),
            [],
            {   colors: ["red","green"],            
                labels: [ "x", "Velocity", "Froude No"],
                series: {
                    'Froude No': {
                        axis: 'y2'
                    }
                },
                ylabel: 'Velocity (m/s)',
                y2label: 'Froude No',
                xlabel: 'Distance Along Pipe (m)',
                legend: 'always',
                legendFormatter: legendFormatter,
                axes: {
                    y2: {
                        drawAxis: false
                    },
                    y: {
                        drawGrid: false
                    },
                    x: {
                        drawGrid: false
                    }
                }
            }
        )
    )
    var sync = Dygraph.synchronize(gs, {
        selection: true,
        zoom: true,
        range: false
    }); 
    
    hd = new Dygraph(
            document.getElementById("graphdiv3"),
            [],
            {   colors: ["#0095D1","grey","black"],
                labels: [ "x","Inlet Control","Outlet Control","Head (mAOD)"],
                series: {
                    'Head (mAOD)': {
                        strokeWidth: 2
                    },
                    'Inlet Control':{
                        strokePattern: [10, 2, 5, 2],
                        strokeWidth: 1
                    },
                    'Outlet Control':{
                        strokePattern: [10, 2, 5, 2],
                        strokeWidth: 1
                    }
                },
                legend: 'always',
                legendFormatter: legendFormatter2,
                axes: {
                    y: {
                        drawGrid: false
                    },
                    x: {
                        drawGrid: false
                    }
                },
                ylabel: 'Head (m)',
                xlabel: 'Discharge (m3/s)'
            }
        )
    
    try {
        plotgraphs();
    } catch(err) {
        console.log("No plot data available.")
        console.log(err);
    }
});
    
function legendFormatter(data) {
    if (data.x == null) {
        document.getElementById("hydraulicgradeline").innerHTML = '0.000';
        document.getElementById("depth").innerHTML = '0.000';
        document.getElementById("velocity").innerHTML = '0.000';
        document.getElementById("froudeno").innerHTML = '0.000';
    } else {
        if (data['series'].length == 2){
            document.getElementById("velocity").innerHTML = parseFloat(data['series'][0]['y']).toFixed(4);
            document.getElementById("froudeno").innerHTML = parseFloat(data['series'][1]['y']).toFixed(4);
        } else if (data['series'].length == 4){
            document.getElementById("hydraulicgradeline").innerHTML = parseFloat(data['series'][0]['y']).toFixed(4);
            document.getElementById("depth").innerHTML = (parseFloat(data['series'][3]['y']) - parseFloat(data['series'][1]['y'])).toFixed(4);
        }
    }
    return "";
}

function legendFormatter2(data) {
    if (data.x == null) {
        document.getElementById("head").innerHTML = '0.0000';
        document.getElementById("headic").innerHTML = '0.0000';
        document.getElementById("headoc").innerHTML = '0.0000';
        document.getElementById("discharge").innerHTML = '0.0000';
    } else {
        document.getElementById("head").innerHTML = parseFloat(data['series'][2]['y']).toFixed(4);
        document.getElementById("headic").innerHTML = parseFloat(data['series'][0]['y']).toFixed(4);
        document.getElementById("headoc").innerHTML = parseFloat(data['series'][1]['y']).toFixed(4);
        document.getElementById("discharge").innerHTML = parseFloat(data['x']).toFixed(4);
    }
    return "";
}
    
function createrangeslider(json) {
    var keys = Object.keys(json);
    var flowrange = [];
    for (i = 0; i < keys.length; i++) {
        if (isNaN(parseFloat(keys[i]))){} else {
            flowrange.push(parseFloat(keys[i])); 
        }
    }
    var Qmax = Math.max.apply(Math, flowrange);
    var Qmin = Math.min.apply(Math, flowrange);
    if (flowrange.length > 1){
        var Qstep = (Qmax - Qmin) / (flowrange.length - 1);
    } else {
        var Qstep = 0;
    }
    var Qvalue = flowrange[Math.ceil(flowrange.length/2)-1];
    var handle = $( "#custom-handle" );
    $( "#slider" ).slider({
      create: function() {
        handle.text( $( this ).slider( "value" ) + "m3/s");
        addpipeprofiledata(closest($( this ).slider( "value" ),flowrange),json);
      },
      orientation: "horizontal",
      range: "min",
      min: Qmin,
      max: Qmax,
      value: Qvalue,
      step: Qstep,
      slide: function( event, ui ) {
        handle.text( round(ui.value,4) + "m3/s" );
        addpipeprofiledata(closest(ui.value,flowrange),json);
        plottable(closest(ui.value,flowrange),json);
        $( "#slider2" ).slider('value',ui.value);
        document.getElementById('custom-handle2').innerHTML = round(ui.value,4) + "m3/s";
      }
    });
    handle.text( round(Qvalue,4) + "m3/s" );
    var width = $('#custom-handle').width();
    var marginLeft = (width / 2)+10;
    $('#custom-handle').css('margin-left', -marginLeft);
}

function createrangeslider2(json) {
    var keys = Object.keys(json);
    var flowrange = [];
    for (i = 0; i < keys.length; i++) {
        if (isNaN(parseFloat(keys[i]))){} else {
            flowrange.push(parseFloat(keys[i])); 
        }
    }
    var Qmax = Math.max.apply(Math, flowrange);
    var Qmin = Math.min.apply(Math, flowrange);
    if (flowrange.length > 1){
        var Qstep = (Qmax - Qmin) / (flowrange.length - 1);
    } else {
        var Qstep = 0;
    }
    var Qvalue = flowrange[Math.ceil(flowrange.length/2)-1];
    var handle = $( "#custom-handle2" );
    $( "#slider2" ).slider({
      create: function() {
        handle.text( $( this ).slider( "value" ) + "m3/s");
        plottable(closest($( this ).slider( "value" ),flowrange),json);
      },
      orientation: "horizontal",
      range: "min",
      min: Qmin,
      max: Qmax,
      value: Qvalue,
      step: Qstep,
      slide: function( event, ui ) {
        handle.text( round(ui.value,4) + "m3/s" );
        plottable(closest(ui.value,flowrange),json);
        addpipeprofiledata(closest(ui.value,flowrange),json);
        $( "#slider" ).slider('value',ui.value);
        document.getElementById('custom-handle').innerHTML = round(ui.value,4) + "m3/s";
      }
    });
    var width = $('#custom-handle2').width();
    var marginLeft = (width / 2)+10;
    $('#custom-handle2').css('margin-left', -marginLeft);
}

function closest(num,arr) {
    curr = arr[0];
    for (i = 0; i < arr.length; i++) {
        if (Math.abs(num - parseFloat(arr[i])) < Math.abs(num - curr)){
            curr = parseFloat(arr[i]);
        }
    }
    return curr
}

function cleargraphs(){
    
    var gs0 = [[0,0,0,0,0]];
    var gs1 = [[0,0,0]];
    var hd0 = [[0,0,0,0]];
    
    gs[0].updateOptions({ 
        'file': gs0
    });
    gs[1].updateOptions({ 
        'file': gs1
    });
    hd.updateOptions({ 
        'file': hd0
    });
}

function resetgraphs(){
    gs[0].updateOptions({
        dateWindow: null,
        valueRange: null
  });
    gs[1].updateOptions({
        dateWindow: null,
        valueRange: null
  });
    hd.updateOptions({
        dateWindow: null,
        valueRange: null
  });
}
    
function addpipeprofiledata(Q,json){
    // Create data arrays for plotting
    var dyarray = [];
    for (i = 0; i < json[Q]['dt'].length; i++) {
        dyarray.push([json[Q]['dt'][i],[json[Q]['k'][i],json[Q]['k'][i],json[Q]['k'][i]],[json[Q]['b'][i],json[Q]['b'][i],json[Q]['b'][i]],[json[Q]['ws'][i],json[Q]['t'][i],json[Q]['t'][i]],[json[Q]['b'][i],json[Q]['ws'][i],json[Q]['ws'][i]]]);
    }

    var dyparam = [];
    for (i = 0; i < json[Q]['dt'].length; i++) {
        dyparam.push([json[Q]['dt'][i],json[Q]['v'][i],json[Q]['fr'][i]]);
    }
	
    gs[0].updateOptions({ 
        'file': dyarray,
        valueRange: [miny, maxy],
        dateRange: [minx, maxx]
    });
    gs[1].updateOptions({ 
        'file': dyparam,
    });
}

function addheaddischargedata(json){
    var headdis = [];
    for (i = 0; i < json['hd'][0].length; i++) {
        headdis.push([json['hd'][1][i],json['hd'][0][i][0],json['hd'][0][i][1],json['hd'][0][i][2]]);
    }
    hd.updateOptions({ 
        'file': headdis
    });
}



function plottable(Q,json){
    var table = "<table class='st'><tr><th>Section</th><th>Type</th><th>Length (m)</th><th>Rise (m)</th><th>Slope</th><th>Normal Depth (m)</th><th>Critical Depth (m)</th><th>Flow Profile</th></tr>";
     for (i = 1; i <= Object.keys(json['st'][Q]).length; i++) {
         table = table + "<tr><td>"+i+"</td><td>"+json['st'][Q][i]["Type"]+"</td><td>"+json['st'][Q][i]["Length"]+"</td><td>"+json['st'][Q][i]["h"]+"</td><td>"+json['st'][Q][i]["Slope"]+"</td><td>"+Math.round(json['st'][Q][i]["normaldepth"] * 10000) / 10000+"</td><td>"+Math.round(json['st'][Q][i]["criticaldepth"] * 10000) / 10000+"</td><td>"+json['st'][Q][i]["flowcurve"]+"</td></tr>"
     }
    table = table + "</table>";
    document.getElementById("summarytable").innerHTML = table;
}

function cleartable(){
    var table = "<table class='st'><tr><th>Section</th><th>Type</th><th>Length (m)</th><th>Rise (m)</th><th>Slope</th><th>Normal Depth (m)</th><th>Critical Depth (m)</th></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";
    document.getElementById("summarytable").innerHTML = table;
}

$(document).ready(function() {
	$('body').addClass('loaded');	
});