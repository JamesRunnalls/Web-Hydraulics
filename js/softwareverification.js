$(document).ready(function(){ 
	// Thesis check 
	thesischeck();  
});
				  
				  
function ajaxcalculate(runcase){
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'php/calculate.php',
        async: false,
        data: runcase,
        success: function (data) {
          caserun = data;
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(error);
        }
        });
	return caserun;
}

function thesischeck(){
	
	// Define results
	
	var CaseA = [[30,60,90,120,150,180,210,240,270,300],[2.07,3.07,3.96,4.81,5.67,6.67,7.88,9.27,10.85,12.62],["N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A"]];

	var CaseB = [[10,20,30,40,50,60,70,80,90,100],[1.16,1.68,2.09,2.45,2.78,3.09,3.39,3.69,3.98,4.26],[1.3,1.86,2.31,2.69,3.04,3.38,3.67,3.96,4.25,4.52]];

	var CaseC = [[15,30,45,60,75,90,105,120,135,150],[1.44,2.08,2.61,3.09,3.54,3.97,4.4,4.83,5.25,5.69],["N/A","N/A","N/A","N/A",3.88,4.3,4.69,5.08,5.46,5.84]];

	var CaseD = [[20,40,60,80,100,120,140,160,180,200],[1.67,2.44,3.09,3.68,4.25,4.82,5.39,6,6.68,7.47],[4.03,4.13,4.3,4.54,4.84,5.2,5.63,6.11,6.63,7.18]];
	
	// Run calculations
	
	var CA = ajaxcalculate($('form[name=CaseA]').serialize())["hd"];
	var CB = ajaxcalculate($('form[name=CaseB]').serialize())["hd"];
	var CC = ajaxcalculate($('form[name=CaseC]').serialize())["hd"];
	var CD = ajaxcalculate($('form[name=CaseD]').serialize())["hd"];
	
	// Check outputs
	
	var A_check_inlet = checkarray(CaseA[1],CA[1]);
	var B_check_inlet = checkarray(CaseB[1],CB[1]);
	var C_check_inlet = checkarray(CaseC[1],CC[1]);
	var D_check_inlet = checkarray(CaseD[1],CD[1]);
	var A_check_outlet = checkarray(CaseA[2],CA[2]);
	var B_check_outlet = checkarray(CaseB[2],CB[2]);
	var C_check_outlet = checkarray(CaseC[2],CC[2]);
	var D_check_outlet = checkarray(CaseD[2],CD[2]);
	
	var A_check = 'Inlet Control Verified = <div style="color:green;display:inline-block;">'+A_check_inlet+'</div> &emsp; Outlet Control Verified = <div style="color:green;display:inline-block;">'+A_check_outlet+'</div><br><br><br><br>';
	var B_check = 'Inlet Control Verified = <div style="color:green;display:inline-block;">'+B_check_inlet+'</div> &emsp; Outlet Control Verified = <div style="color:green;display:inline-block;">'+B_check_outlet+'</div><br><br><br><br>';
	var C_check = 'Inlet Control Verified = <div style="color:green;display:inline-block;">'+C_check_inlet+'</div> &emsp; Outlet Control Verified = <div style="color:green;display:inline-block;">'+C_check_outlet+'</div><br><br><br><br>';
	var D_check = 'Inlet Control Verified = <div style="color:green;display:inline-block;">'+D_check_inlet+'</div> &emsp; Outlet Control Verified = <div style="color:green;display:inline-block;">'+D_check_outlet+'</div><br><br><br><br>';
	
	// Create table

	var tablestart = '<table class="stripetable" style="min-width:700px;"><tr><th rowspan="2">Q</th><th colspan="2">Thesis Headwater (ft)</th><th colspan="2">Web Hydraulics Headwater (ft)</th></tr><tr><th>Inlet Control</th><th>Outlet Control</th><th>Inlet Control</th><th>Outlet Control</th></tr>';
	var tableend = '</table>';
	
	var table_A = tablestart + tablecontent(CaseA,CA) + tableend + "<br>" + A_check;
	var table_B = tablestart + tablecontent(CaseB,CB) + tableend + "<br>" + B_check;
	var table_C = tablestart + tablecontent(CaseC,CC) + tableend + "<br>" + C_check;
	var table_D = tablestart + tablecontent(CaseD,CD) + tableend + "<br>" + D_check;
		
		
	document.getElementById("CaseA").innerHTML = table_A;
	document.getElementById("CaseB").innerHTML = table_B;
	document.getElementById("CaseC").innerHTML = table_C;
	document.getElementById("CaseD").innerHTML = table_D;
	
}
	
function tablecontent(array1,array2){
	var data = "";
	for (k = 0; k < array1[0].length; k++) {
	data = data + '<tr><td>'+array1[0][k]+'</td><td>'+array1[1][k]+'</td><td>'+array1[2][k]+'</td><td>'+parseFloat(array2[1][k]).toFixed(4)+'</td><td>'+parseFloat(array2[2][k]).toFixed(4)+'</td></tr>';
	}
	return data;
}

function checkarray(array1,array2){
	if (array1.length == array2.length){
		var result = "True"
		for (k = 0; k < array1.length; k++) {
			var perc = Math.abs(array1[k]-array2[k])/array1[k];
			if (perc > 0.01) {
				result = "False";
			}
		}
		return result;
	} else {
		return false;
	}
}