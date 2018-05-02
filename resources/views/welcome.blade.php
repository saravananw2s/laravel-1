<!DOCTYPE html>
<html>
<head>
    <title>GO NON VEG</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <style type="text/css">p {
  text-align: center;
  font-size: 60px;
  margin-top:0px;
}</style>
</head>
<body>
    <div>
          <nav role='navigation' style="background: green">
     <ul>
        <li><a href="/">Home</a></li>
        <li><a href="about">About Us</a></li>
        <li><a href="offer">Offers</a></li>
        <li><a href="ship">Shipment Policy</a></li>
      </ul>
    </nav>  
    </div>
<div>
                <div class="logo" ><img src="go.png" style="width: 15%;
    margin-left: 41%;
    margin-top: -20px"></div>
</div>
                <p style="
    margin-top: -29px;
    font-family:  serif;
    font-size: 34px;
    text-transform:  uppercase;
    color:  green;
">Welcome To Go Non Veg </p>
<p id="demo" style="font-size: 155px;    color: darkorange;
    font-family: serif"></p>


   <div style="
    bottom:  0;
    position:  absolute;
    color: white;
    font-size: 20px;
    background:  green;
    width: 100%;
    padding: 10px;
    padding-left: 40%;
">Designed and Maintain by Lemurianz</div>
</body>

<script>
// Set the date we're counting down to
var countDownDate = new Date("May 13, 2018 00:00:01").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);
</script>
</html>