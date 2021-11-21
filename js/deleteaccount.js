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
	errordict["1"] = "Username not recognised please try again.";
	errordict["2"] = "Incorrect password please try again.";
	errordict["3"] = "Apologies username doesn\'t match that of logged in user. Please login to the account you want to delete.";
	var data = parseURLParams(window.location.href);
	var id = data["err"][0];
	document.getElementById("message").innerHTML = errordict[id];
} catch (err){}