<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<body>
<!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <section class="book" id="book">

    <div class="heading">
        <h5>RESERVATION FORM</h5>
        <h2>El Hotel</h2>
    </div>

    <div class="row">

        <div class="image">
            <img src="images/book-img.jpg" alt="" height="413.25px" width="400.25px">
        </div>

        <form action="">
        <div class="inputBox">
                <h3>Full Name</h3>
                <input type="text" placeholder="Full Name">
            </div>
            <div class="inputBox">
                <h3>Email</h3>
                <input type="email" placeholder="Email">
            </div>
            <div class="inputBox">
                <h3>How many</h3>
                <input type="number" placeholder="Number of guests">
            </div>
            <div class="inputBox">
                <h3>Check-in</h3>
                <input type="Date">
            </div>
            <div class="inputBox">
                <h3>Check-out</h3>
                <input type="Date">
            </div>
            <input type="submit" class="btn" value="Book Now">
        </form>

    </div>

</section>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
