$(function() {

	// Get the form.
	var form2 = $('#contactform');

	// Set up an event listener for the contact form.
	$(form2).submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();
		console.log("alive");
		// Serialize the form data.
		var formData = $(form2).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: "php/contactform.php",
			data: formData
		})
		.done(function() {
			document.getElementById("success").style.display = "block";
			document.getElementById("failure").style.display = "none";

			// Clear the form.
			$('#name').val('');
			$('#email').val('');
			$('#message').val('');
		})
		.fail(function(data) {
			document.getElementById("failure").style.display = "block";
			document.getElementById("success").style.display = "none";
		});

	});

});