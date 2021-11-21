function ajaxusernameset(){
    return sessionStorage.getItem('username');
}

// Add smooth scrolling and update dropdown when logged in
$(document).ready(function(){
  if (ajaxusernameset() != 'undefined' && ajaxusernameset() != null && document.getElementById('myDropdown') != null){
        document.getElementById('myDropdown').innerHTML = '<a href="fileexplorer.php">File Explorer</a><a href="profile.php">Profile</a><a href="javascript:logout()">Logout</a><a href="softwareverification.html">Software Verification</a><a href="policies.php">Policies</a>'
  }  

  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;
      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        //window.location.hash = hash;
      });
    } // End if
  });
});


// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropdown-button')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.style.display = "block") {
        openDropdown.style.display = "none";
      }
    }
  }
	
  if (!event.target.matches('.dropdown-button')) {
    var dropdowns = document.getElementsByClassName("dropdown-content2");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.style.display = "block") {
        openDropdown.style.display = "none";
      }
    }
  } 
    
  if (event.target.matches('#calculationerror')) {
      document.getElementById("calculationerror").style.display = "none";
  } 
	
  if (event.target.matches('#underconstruction')) {
      document.getElementById("underconstruction").style.display = "none";
  } 
	
  if (event.target.matches('#welcome')) {
      document.getElementById("welcome").style.display = "none";
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

function menu() {
    document.getElementById("myDropdown").style.display = "block";
}

function menu2() {
    document.getElementById("myDropdown2").style.display = "block";
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

function logout(){
    sessionStorage.clear();
    window.location.href = 'php/logout.php';
}