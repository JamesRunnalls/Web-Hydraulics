window.onload = function(){ 
    $('#loader-text').html("Rendering equations...");
}

MathJax.Hub.Config({
    extensions: ["tex2jax.js"],
jax: ["input/TeX", "output/HTML-CSS"],
tex2jax: {
  inlineMath: [ ["\\(","\\)"] ],
  displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
  processEscapes: true
},
"HTML-CSS": { availableFonts: ["STIX"],
              preferredFont: 'STIX',
              webFont: 'STIX-Web',
              imageFont: null
             }
  });

MathJax.Hub.Queue(function () {
  $('body').addClass('loaded');
});

// Get session storage data 

var report_session = [];
$.ajax({
	type: 'post',
	dataType: 'json',
	url: 'php/report_session.php',
	async: false,
	success: function (data) {
	  report_session = data;
	},
	error: function(xhr, status, error) {
		console.log(xhr.responseText);
		console.log(error);
	}
});

var n =  new Date();
var y = n.getFullYear();
var m = n.getMonth() + 1;
var d = n.getDate();
document.getElementById("date").innerHTML = d + "/" + m + "/" + y;
document.getElementById("jobno").innerHTML = report_session["jn"];
document.getElementById("title").innerHTML = report_session["jt"];
document.getElementById("author").innerHTML = report_session["a"];
document.getElementById("calcdesc").innerHTML = report_session["cd"];
document.getElementById("rev").innerHTML = report_session["r"];
document.getElementById("2date").innerHTML = d + "/" + m + "/" + y;
document.getElementById("2jobno").innerHTML = report_session["jn"];
document.getElementById("2title").innerHTML = report_session["jt"];
document.getElementById("2author").innerHTML = report_session["a"];
document.getElementById("2calcdesc").innerHTML = report_session["cd"];
var id = report_session["sessionStorageID2"];
document.getElementById("img").innerHTML = '<img src="img/users/'+id+'.png" id="imglogo">';
document.getElementById("img2").src = 'img/users/'+id+'.png';
document.getElementById("id").value = id;
document.getElementById("reportflowrate").value = report_session["flowrate"];
document.getElementById("reportQ").innerHTML = report_session["flowrate"];

$(document).ready(function(){
    var json = [];
    var gs = [];
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/calculate.php',
        async: false,
        data: $('form').serialize(),
        success: function (data) {
          json = data;
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
        }
        });
        
    // Add rows to table
    for (k = 1; k < json["len"]; k++) {
        addRow('reportsections');
    }
    
    var ml = multipleinputslevel2("mltype",json["inputs"]);
    // Add rows to table
    for (k = 0; k < ml.length; k++) {
        for (x = 0; x < ml[k].length; x++){
            if (k == 0 && x == 0){}else{
                addRowml('minorloss',k,x);
            } 
        }
    }
    
    
    
    // Add all text values
    $('#reportsections div').each(function() {
        if (json["inputs"][this.attributes["name"].value] != undefined){
            this.innerHTML = json["inputs"][this.attributes["name"].value];
        }
    });
    
    $('#reportinlet div').each(function() {
        if (json["inputs"][this.attributes["name"].value] != undefined){
            this.innerHTML = json["inputs"][this.attributes["name"].value];
        }
    });
    
    $('#flowdetails div').each(function() {
        if (json["inputs"][this.attributes["name"].value] != undefined){
            this.innerHTML = json["inputs"][this.attributes["name"].value];
        }
    });
    
    $('#minorloss div').each(function() {
        if (json["inputs"][this.attributes["name"].value] != undefined){
            this.innerHTML = json["inputs"][this.attributes["name"].value];
        }
    });
	
	// Add downstream sections
	
	if(json["inputs"]["dstype"] == "section"){
		var html = "Downstream section: <br><br>"+"<table><tr><th>Width (m)</th><th>Side Slope</th><th>US Elevation (mAOD)</th><th>Slope (m/m)</th><th>Mannings n</th></tr><tr><td>"+json["inputs"]["dswidth"]+"</td><td>"+json["inputs"]["dssideslope"]+"</td><td>"+json["inputs"]["uselev"]+"</td><td>"+json["inputs"]["slope"]+"</td><td>"+json["inputs"]["manningsn"]+"</td></tr></table>";
		document.getElementById("downstream").innerHTML = html;
	} else if(json["inputs"]["dstype"] == "freedischarge"){
		var html = "Free discharge.";
		document.getElementById("downstream").innerHTML = html;
	} else if(json["inputs"]["dstype"] == "fixedheight"){
		var html = "Fixed height: "+json["inputs"]["dswl"]+"mAOD.";
		document.getElementById("downstream").innerHTML = html;
	}
	
    
    // Maximum Open Channel Flow
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('MOCF');
    }
    
    $('#MOCF div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(3);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Normal Depth
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('ND');
    }
    
    $('#ND div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(3);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Critical Depth
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('CD');
    }
    
    $('#CD div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(3);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Flow Type
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('FT');
    }
    
    $('#FT div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (fp[1] == "type"){
            if (json["class"][no]["\u0000Generic\u0000data"]["normaldepth"] >= json["class"][no]["\u0000Generic\u0000data"]["h"]){
                this.innerHTML = "Full";
            } else if (json["class"][no]["\u0000Generic\u0000data"]["normaldepth"] > json["class"][no]["\u0000Generic\u0000data"]["yc"]){
                this.innerHTML = "Subcritical";
            } else {
                this.innerHTML = "Supercritical";
            }           
        }
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(3);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Minor Loss
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('ML');
    }
    
    $('#ML div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(2);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Mannings n
    
    document.getElementById("MN&n_user&0").innerHTML = parseFloat(json["inputs"]["n&0"]).toFixed(5);
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('MN');
        document.getElementById("MN&n_user&"+k).innerHTML = parseFloat(json["inputs"]["n&"+k]).toFixed(5);
    }
    
    $('#MN div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(5);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Friction Gradient
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('FG');
    }
    
    $('#FG div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(5);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    // Surface Profile
    
    for (k = 1; k < (json["class"].length - 2); k++) {
        addRow2('SP');
    }
    
    $('#SP div').each(function() {
        var fp = this.attributes["name"].value.split('&');
        var no = parseInt(fp[2]) + 1;
        if (json["class"][no]["\u0000Generic\u0000data"][fp[1]] != undefined){
            var newhtml = json["class"][no]["\u0000Generic\u0000data"][fp[1]];
            if(isNumber(newhtml)){
                this.innerHTML = parseFloat(newhtml).toFixed(5);
            } else {
                this.innerHTML = newhtml;
            }
        }
    });
    
    
    // Headwater
    
    // Inlet Control
    
    document.getElementById("IC&InletType").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["Type"];
    document.getElementById("IC&InletDetail").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["Detail"];
    document.getElementById("IC&K").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["K"];
    document.getElementById("IC&M").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["M"];
    document.getElementById("IC&Y").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["Y"];
    document.getElementById("IC&c").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["CS"];
    document.getElementById("IC&form").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["Form"];
    document.getElementById("IC&type").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["ft"];
    document.getElementById("IC&par").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["par"]).toFixed(2);
    document.getElementById("IC&yc").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["yc"]).toFixed(3);
    document.getElementById("IC&hw").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["HW"]).toFixed(3);
    
    // Outlet control
    document.getElementById("OC&InletType").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["Type"];
    document.getElementById("OC&InletDetail").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["Detail"];
    document.getElementById("OC&Ke").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["subcoef"]["Ke"];
    document.getElementById("OC&y").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["subcoef"]["y"]).toFixed(3);
    document.getElementById("OC&Hl").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["subcoef"]["HL"]).toFixed(3);
    document.getElementById("OC&HW").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["subcoef"]["HW"]).toFixed(3);
    
    // Headwater summary
    
    document.getElementById("HW&IHW").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["HW"]).toFixed(3);
    document.getElementById("HW&IHWA").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["supcoef"]["HWA"]).toFixed(3);
    document.getElementById("HW&OHW").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["subcoef"]["HW"]).toFixed(3);
    document.getElementById("HW&OHWA").innerHTML = parseFloat(json["inlet"]["\u0000Generic\u0000data"]["subcoef"]["HWA"]).toFixed(3);
    document.getElementById("HW&CT").innerHTML = json["inlet"]["\u0000Generic\u0000data"]["hwt"];
    
    
    // Rapidly Raried Flow
    
    for (k = 1; k < (json["class"].length - 1); k++) {
        if (json["class"][k]["\u0000Generic\u0000data"]["flowcurve"].includes("HJ")){
            adddivs(k);
            createrapidlyvariedflowgraph(k);
            createrapidlyvariedflowtable(k);
			saveRVFdata(k);
        }  
    }
    
    function adddivs(no){
        document.getElementById("RVF").innerHTML = document.getElementById("RVF").innerHTML+'<div id="HJtable'+no+'"></div><br><br><div id="HJgraph'+no+'" style="width: 95%; height: 400px;padding-left:2%;"></div><div id="legend" style="text-align:center;"><div style="display:inline-block;color:#0095D1;">Hydraulic Grade Line: <div id="RVF_HGL" style="display: inline">0.000</div> m </div> &nbsp &nbsp &nbsp<div style="display:inline-block;">Downstream Profile Depth (m): <div id="RVF_DS" style="display: inline">0.000</div> m </div> &nbsp &nbsp &nbsp<div style="display:inline-block;color:grey">Upstream Profile Depth (m): <div id="RVF_US" style="display: inline;">0.000</div> m </div> &nbsp &nbsp &nbsp<div style="display:inline-block;color:#87646A;">Sequent Depth: <div id="RVF_SQ" style="display: inline">0.000</div> m </div><br><div style="text-align:left";><br><button type="button" class="downloadRVF" name="'+no+'" style="line-height:20px;vertical-align:top;">&nbsp<img src="img/download.png" style="height:20px;vertical-align:bottom;">&nbsp &nbsp Download Data</button></div>';	
    }
	
	function saveRVFdata(no){
		var data = json["class"][no]["\u0000Generic\u0000data"];
		var csvarray = [['Distance Along Pipe (m)','Hydraulic Grade Line (m)','Upstream Profile Depth (m)','Downstream Profile Depth (m)','Sequent Depth (m)']];
		var dt = data["HJ_US"][0];
		var US = data["HJ_US"][1];
		var DS = data["HJ_DS"][1];
		var SQ = data["sequent"][1];
		var HGL = data["HJ_end"][1];
		for (i = 1; i < dt.length -1; i++) {
			csvarray.push([dt[i],HGL[i],US[i],DS[i],SQ[i]]);
		}
		sessionStorage.setItem('RVF'+no, JSON.stringify(csvarray));
	}
    
    function createrapidlyvariedflowtable(k){
        var id = k - 1;
        var Jt = json["class"][k]["\u0000Generic\u0000data"]["Jt"];
        var Lj = parseFloat(json["class"][k]["\u0000Generic\u0000data"]["Lj"]).toFixed(2);
		var Fe = json["class"][k]["\u0000Generic\u0000data"]["HJ_flow"];
		var Fr = parseFloat(json["class"][k]["\u0000Generic\u0000data"]["HJ_Fr"]).toFixed(2);
        
        var table = '<table id="JL" class="stripetable"><tr><th>Pipe Section</th><th>Hydraulic Jump Type</th><th>Hydraulic Jump Length (m)</th><th>Flow Environment</th><th>Froude Number at Jump</th></tr><tr><td>'+id+'</td><td>'+Jt+'</td><td>'+Lj+'</td><td>'+Fe+'</td><td>'+Fr+'</td></tr></table><br>';
        
        document.getElementById('HJtable'+k).innerHTML = table;
    }
    
    function createrapidlyvariedflowgraph(no){
        // Create data

        var data = json["class"][no]["\u0000Generic\u0000data"];

        var HJdata = []
		var dt = data["HJ_US"][0];
		var US = data["HJ_US"][1];
		var DS = data["HJ_DS"][1];
		var SQ = data["sequent"][1];
		var HGL = data["HJ_end"][1];
		var T = parseFloat(data["h"]);
		for (i = 1; i < dt.length -1; i++) {
			HJdata.push([dt[i],HGL[i],US[i],DS[i],SQ[i],T]);
		}

        // Create Graph
        HJgraph = new Dygraph(
            document.getElementById("HJgraph"+no),
            [],
            {   colors: ["#0095D1","black","grey","#87646A","black"],
                labels: [ "x","HGL", "US", "DS", "SQ", "T"],
                connectSeparatedPoints: true,
                legend: 'always',
                legendFormatter: legendFormatter3,
                series: {
                    'T': {
                        strokeWidth: 2
                    },
                    'HGL': {
                        strokeWidth: 3
                    },
                    'US': {
                        strokePattern: [10, 5, 10, 5]
                    },
                    'DS': {
                        strokePattern: [10, 5, 10, 5]
                    },
                    'SQ': {
                        strokePattern: [10, 5, 10, 5]
                    }
                    
                },
                axes: {
                    y: {
                        drawGrid: false
                    },
                    x: {
                        drawGrid: false
                    }
                },
                ylabel: 'Height (m)',
                xlabel: 'Distance Along Pipe (m)',
                
            }
        ) 
    
     HJgraph.updateOptions({ 
        'file': HJdata
    });
        
    }
    
    function sortNumber(a,b) {
        return parseFloat(a) - parseFloat(b);
    }
	
	// Gradually Varied Flow Table
	for (k = 1; k < (json["class"].length - 1); k++) {
        if (json["class"][k]["\u0000Generic\u0000data"]["flowcurve"].includes("HJ") || json["class"][k]["\u0000Generic\u0000data"]["flowcurve"] == "F"){}else{
			adddivsGVFT(k);
            createGVFT(k);
			saveGVFdata(k);
		}
	}
		
	function adddivsGVFT(k){
		no = k - 1;
        document.getElementById("GVFT").innerHTML = document.getElementById("GVFT").innerHTML+'<b>Pipe Section: '+no+'</b><br><br><div id="GVFT'+k+'"></div><br><button type="button" class="downloadGVF" name="'+k+'" style="line-height:20px;vertical-align:top;">&nbsp<img src="img/download.png" style="height:20px;vertical-align:bottom;">&nbsp &nbsp Download Full Table</button><br><br><br>';
    }
	
	function saveGVFdata(k){
		var data = json["class"][k]["\u0000Generic\u0000data"]["DSM"];
		var csvarray = [['Elevation (mAOD)','Depth (m)','Cross Sectional Area (m2)','Velocity (m/s)','Hydraulic Radius (m)','Specific Energy (m)','Friction Slope (m/m)','Delta x (m)','Distance Along Section (m)']];
		for (i = 0; i < (data[0].length); i++) {
			csvarray.push([parseFloat(data[7][i]),parseFloat(data[0][i]),parseFloat(data[1][i]),parseFloat(data[2][i]),parseFloat(data[3][i]),parseFloat(data[4][i]),parseFloat(data[5][i]),parseFloat(data[6][i]),parseFloat(data[8][i])]);
		}
		sessionStorage.setItem('GVF'+k, JSON.stringify(csvarray));
	}
		
	function createGVFT(k){
		var data = json["class"][k]["\u0000Generic\u0000data"]["DSM"];
		var table = "<table class='stripetable'><tr><th>Elevation (mAOD)</th><th>Depth (m)</th><th>Cross Sectional Area (m2)</th><th>Velocity (m/s)</th><th>Hydraulic Radius (m)</th><th>Specific Energy (m)</th><th>Friction Slope (m/m)</th><th>&Delta;x (m)</th><th>Distance Along Section (m)</th></tr>";
		var middle = 1;
		for (i = 0; i < (data[0].length); i++) {
			if (i < 5 || i > data[0].length-6){
				var row = "<tr><td>"+parseFloat(data[7][i]).toFixed(4)+"</td><td>"+parseFloat(data[0][i]).toFixed(4)+"</td><td>"+parseFloat(data[1][i]).toFixed(4)+"</td><td>"+parseFloat(data[2][i]).toFixed(4)+"</td><td>"+parseFloat(data[3][i]).toFixed(4)+"</td><td>"+parseFloat(data[4][i]).toFixed(4)+"</td><td>"+parseFloat(data[5][i]).toFixed(4)+"</td><td>"+parseFloat(data[6][i]).toFixed(8)+"</td><td>"+parseFloat(data[8][i]).toFixed(8)+"</td></tr>";
				table = table + row;
			} else if (middle == 1) {
				var row = "<tr><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td></tr>";
				table = table + row;
				middle = 0;
			}
		}
		
		table = table + "</table>";
		document.getElementById('GVFT'+k).innerHTML = table;
	}
        
    
    // Pipe Profile
        
    var pipe = [];
    for (i = 0; i < json["pipe"]['dt'].length; i++) {
        pipe.push([json["pipe"]['dt'][i],[json["pipe"]['k'][i],json["pipe"]['k'][i],json["pipe"]['k'][i]],[json["pipe"]['b'][i],json["pipe"]['b'][i],json["pipe"]['b'][i]],[json["pipe"]['ws'][i],json["pipe"]['t'][i],json["pipe"]['t'][i]],[json["pipe"]['b'][i],json["pipe"]['ws'][i],json["pipe"]['ws'][i]],[json["pipe"]['nd'][i],json["pipe"]['nd'][i],json["pipe"]['nd'][i]],[json["pipe"]['yc'][i],json["pipe"]['yc'][i],json["pipe"]['yc'][i]]]);
    }
    
    var frvel = [];
    for (i = 0; i < json["pipe"]['dt'].length; i++) {
        frvel.push([json["pipe"]['dt'][i],json["pipe"]['v'][i],json["pipe"]['fr'][i]]);
    }
    
    gs.push(
        new Dygraph(
            document.getElementById("graphdiv1"),
            [],
            {   customBars: true,
                errorBars: true,
                colors: ["#0095D1","black","black","#0095D1","black","grey"],            
                labels: [ "x", "Hydraulic Grade Line", "Bottom of Section", "Top of Section", "Water Surface Profile", "Normal Depth", "Critical Depth"],
                series: {
                    'Normal Depth': {
                        strokePattern: [10, 5, 5, 5]
                    },
                    'Critical Depth':{
                        strokePattern: [10, 5, 10, 5],
                    }
                },
                legend: 'always',
                legendFormatter: legendFormatter,
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
    
    // Head discharge
    
    var dataHD = loadfile()
    var headdis = [];
    for (i = 0; i < dataHD['hd'][0].length; i++) {
        headdis.push([dataHD['hd'][1][i],dataHD['hd'][0][i][0],dataHD['hd'][0][i][1],dataHD['hd'][0][i][2]]);
    }
    
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
    
    gs[0].updateOptions({ 
        'file': pipe
    });
    gs[1].updateOptions({ 
        'file': frvel
    });
    
    hd.updateOptions({ 
        'file': headdis
    });
});

// Add event listeners

$("#printreport").click(function(){
 	window.print();
});

$("#downloadpipeprofile").click(function(){
 	downloadpipeprofile();
});

$("#downloadheaddischarge").click(function(){
 	downloadheaddischarge();
});

$(document).click(function(e) {
	if (e.target.className == "downloadGVF"){
		downloadGVFT(e.target.name);
	} else if (e.target.className == "downloadRVF"){
		downloadRVFG(e.target.name);
	}
});

// Format legends

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
        } else if (data['series'].length == 6){
            document.getElementById("hydraulicgradeline").innerHTML = parseFloat(data['series'][0]['y']).toFixed(4);
            document.getElementById("normaldepth").innerHTML = parseFloat(data['series'][4]['y']).toFixed(4);
            document.getElementById("criticaldepth").innerHTML = parseFloat(data['series'][5]['y']).toFixed(4);
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

function legendFormatter3(data) {
    if (data.x == null) {
        document.getElementById("RVF_HGL").innerHTML = '0.0000';
        document.getElementById("RVF_DS").innerHTML = '0.0000';
        document.getElementById("RVF_US").innerHTML = '0.0000';
        document.getElementById("RVF_SQ").innerHTML = '0.0000';
    } else {
        document.getElementById("RVF_HGL").innerHTML = parseFloat(data['series'][0]['y']).toFixed(4);
        document.getElementById("RVF_DS").innerHTML = parseFloat(data['series'][2]['y']).toFixed(4);
        document.getElementById("RVF_US").innerHTML = parseFloat(data['series'][1]['y']).toFixed(4);
        document.getElementById("RVF_SQ").innerHTML = parseFloat(data['series'][3]['y']).toFixed(4);
    }
    return "";
}

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
    var json = loadfile();
	var Q = document.getElementById("reportflowrate").value;
	var csvarray = [['Distance Along Pipe (m)','Hydraulic Grade Line (mAOD)','Bottom of Pipe (mAOD)','Top of Pipe (mAOD)','Water Surface Profile (mAOD)','Velocity (m/s)','Froude No']];
	for (i = 0; i < json[Q]['dt'].length; i++) {
		csvarray.push([json[Q]['dt'][i],json[Q]['k'][i],json[Q]['b'][i],json[Q]['t'][i],json[Q]['ws'][i],json[Q]['v'][i],json[Q]['fr'][i]]);
	}
	exportToCsv('pipeprofile_Q='+Q+'.csv', csvarray);
}

function downloadheaddischarge(){
    var json = loadfile();
	var csvarray = [['Discharge (m3/s)','Inlet Control Head (m)','Outlet Control Head (m)','Head (m)',]];
	for (i = 0; i < json['hd'][0].length; i++) {
		csvarray.push([json['hd'][1][i],json['hd'][0][i][0],json['hd'][0][i][1],json['hd'][0][i][2]]);
	}
	exportToCsv('headdischarge.csv', csvarray);
}

function downloadGVFT(no){
	var csvarray = JSON.parse(sessionStorage.getItem('GVF'+no));
	exportToCsv('graduallyvariedflow.csv', csvarray);
}

function downloadRVFG(no){
	var csvarray = JSON.parse(sessionStorage.getItem('RVF'+no));
	exportToCsv('hydraulicjump.csv', csvarray);
}


function addRow(id){ 
    var x=document.getElementById(id).tBodies[0];  //get the table
    var l = document.getElementById(id).rows.length - 1;
    var node=x.rows[l].cloneNode(true); //clone the previous node or row
    // Find the row number
    var name = node.cells[0].childNodes[0].attributes["name"].value;
    name = name.split('&');
    var newnumber = parseInt(name[1]) + 1
    for(var i=0, l = node.cells.length; i < l; i++){
        var name = node.cells[i].childNodes[0].attributes["name"].value;
        name = name.split('&');
        var newname = name[0] + "&" + newnumber.toString();
        node.cells[i].childNodes[0].setAttribute('name',newname);
        node.cells[i].childNodes[0].setAttribute('id',newname);
    }
    node.cells[0].childNodes[0].innerHTML = newnumber;
    x.appendChild(node);   //add the node or row to the table
}

function addRow2(id){ 
    var x=document.getElementById(id).tBodies[0];  //get the table
    var l = document.getElementById(id).rows.length - 1;
    var node=x.rows[l].cloneNode(true); //clone the previous node or row
    // Find the row number
    var name = node.cells[0].childNodes[0].attributes["name"].value;
    name = name.split('&');
    var newnumber = parseInt(name[2]) + 1
    for(var i=0, l = node.cells.length; i < l; i++){
        var name = node.cells[i].childNodes[0].attributes["name"].value;
        name = name.split('&');
        var newname = name[0] + "&" + name[1] + "&" + newnumber.toString();
        node.cells[i].childNodes[0].setAttribute('name',newname);
        node.cells[i].childNodes[0].setAttribute('id',newname);
    }
    node.cells[0].childNodes[0].innerHTML = newnumber;
    x.appendChild(node);   //add the node or row to the table
}

function addRowml(id,no1,no2){ 
    var x=document.getElementById(id).tBodies[0];  //get the table
    var l = document.getElementById(id).rows.length - 1;
    var node=x.rows[l].cloneNode(true); //clone the previous node or row
    // Find the row number
    var name = node.cells[1].childNodes[0].attributes["name"].value;
    name = name.split('&');
    for(var i=0, l = node.cells.length; i < l; i++){
        var name = node.cells[i].childNodes[0].attributes["name"].value;
        name = name.split('&');
        var newname = name[0] + "&" + no1.toString() + "&" + no2.toString();
        node.cells[i].childNodes[0].setAttribute('name',newname);
        node.cells[i].childNodes[0].setAttribute('id',newname);
    }
    node.cells[0].childNodes[0].innerHTML = no1;
    x.appendChild(node);   //add the node or row to the table
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

function isNumber(str) {
  // could also coerce to string: str = ""+str
  return !isNaN(str) && !isNaN(parseFloat(str))
}

function loadfile(){
    try {
        var name = document.getElementById('id').value;
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
                alert("Please run a successful simulation before creating your report.")
                window.history.back();
        }
        });
        return json;
        })();
        return json; 
    } catch (err) {
        console.log(err);
        return "None";
    } 
}