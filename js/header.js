// Edit menu if logged in
function loggedinname(){
	try {
		document.getElementById("login1").innerHTML = '<a href="php/logout.php">log out</a>';
	} catch (err){}
	try {
		document.getElementById("login2").innerHTML = '<a href="php/logout.php">log out</a>';
	} catch (err){}
	try {
		document.getElementById("signup1").innerHTML = '<a href="fileexplorer.php">file explorer</a>';
	} catch (err){}
	try {
		document.getElementById("signup2").innerHTML = '<a href="fileexplorer.php">file explorer</a>';
	} catch (err){}
}

$.ajax({
type: 'post',
dataType: 'text',
url: 'php/loggedin.php',
success: function (data) {
	if (data == "True"){
		loggedinname();
	}
},
error: function(xhr, status, error) {
	console.log(xhr.responseText);
	console.log(error);
}
});
  


// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('header').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
	var x = document.getElementById("hamburger_menu").style.display;
    if (didScroll && x != "block"){
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('header').removeClass('nav-down').addClass('nav-up');
		$('header').removeClass('top');
    } else {
        // Scroll Up
		$('header').removeClass('nav-up').addClass('nav-down');
    }
    
    lastScrollTop = st;
}

$(window).scroll(function() {
   if($(window).scrollTop() == 0) {
      $('header').addClass("top"); 
   }
});


// On click keep menu open

$("#hamburger_container").click(function(){
	hamburger();
});

$(".ham_burger").click(function(){
	hamburger();
});

function hamburger() {
  var y = document.getElementById("hamburger_container");
  y.classList.toggle("change");	
  var x = document.getElementById("hamburger_menu");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}


