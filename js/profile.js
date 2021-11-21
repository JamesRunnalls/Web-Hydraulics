$.ajax({
	type: 'post',
	dataType: 'json',
	url: 'php/useremail.php',
	success: function (data) {
		document.getElementById("username_fill").innerHTML = "<b>"+data["user"]+"</b>";
    document.getElementById("email_fill").innerHTML = "<b>"+data["email"]+"</b>";
	},
	error: function(xhr, status, error) {
		console.log(xhr.responseText);
		console.log(error);
	}
});

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


try {
	var errordict = {};
	errordict["1"] = "Your username was updated.";
	errordict["2"] = "Sorry user name already exists please try another name.";
	errordict["3"] = "Your email address was updated.";
	errordict["4"] = "Your password was updated.";
	errordict["5"] = "Passwords do not match, please try again.";
	var data = parseURLParams(window.location.href);
	var id = data["err"][0];
	if (id == 1 || id == 2){
		document.getElementById("usernamemessage").innerHTML = errordict[id];
	} else if (id == 3){
		document.getElementById("emailmessage").innerHTML = errordict[id];	
	} else if (id == 4 || id == 5){
		document.getElementById("passwordmessage").innerHTML = errordict[id];
	}
} catch (err){}

