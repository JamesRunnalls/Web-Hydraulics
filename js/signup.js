var stripe = Stripe('pk_test_7IDGdaHA4ETn1T838raLfHln00hR823f2C');
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
  base: {
    // Add your base input styles here. For example:
    fontSize: '13.3333px',
    color: "#000000",
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {hidePostalCode: true, style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the customer that there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}

$("#toggle-on").click(function(){
		document.getElementById("contactform").style.display = "none";
    document.getElementById("payment-form").style.display = "block";
});

$("#toggle-off").click(function(){
    document.getElementById("payment-form").style.display = "none";
    document.getElementById("contactform").style.display = "block";
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
  errordict["1"] = "Please complete all the fields before submitting the form.";
  errordict["2"] = "Passwords do not match please try again.";
  errordict["3"] = "Sorry your card was declined please try an alternate payment method or get in touch.";
  errordict["4"] = "Sorry user name already exists. Please try another name.";
  var data = parseURLParams(window.location.href);
  var id = data["err"][0];
  document.getElementById("signupmessage").innerHTML = errordict[id];
} catch (err){}