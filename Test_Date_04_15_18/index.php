<!DOCTYPE html>
<html>
<head>
<title>The Wash Home Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
}

/* Style the header */
.header {
    padding: 80px;
    text-align: center;
    background: rgb(20, 0, 50);
    color: white;
}

/* Increase the font size of the h1 element */
.header h1 {
    font-size: 40px;
}

/* Style the top navigation bar */
.navbar {
    overflow: hidden;
    background-color: rgb(20, 230, 50);
}

/* Style the navigation bar links */
.navbar a {
    float: left;
    display: block;
    color: white;
    text-align: center;
    padding: 14px 14px;
    text-decoration: none;
	box-sizing: border-box;
}

/* Right-aligned link */
.navbar a.right {
    float: right;
}

/* Change color on hover */
.navbar a:hover {
    background-color: #ddd;
    color: black;
}

/* Column container */
.row {  
    display: flex;
    flex-wrap: wrap;
}

/* Create two unequal columns that sits next to each other */
/* Sidebar/left column */
.side {
    flex: 30%;
    background-color: #f1f1f1;
    padding: 20px;
	box-sizing: border-box;
}

/* Main column */
.main {   
    flex: 70%;
    background-color: white;
    padding: 20px;
	box-sizing: border-box;
}

/* Fake image, just for this example */
.fakeimg {
    background-color: #aaa;
    width: 100%;
    padding: 20px;
	box-sizing: border-box;
}

iframe {
    max-width: 100%; 
}

/* Footer */
.footer {
    padding: 20px;
    text-align: center;
    background: #ddd;
}

/* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 700px) {
    .row {   
        flex-direction: column;
    }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
    .navbar a {
        float: none;
        width:100%;
    }
}

.fa {
  padding: 20px;
  font-size: 30px;
  width: 30px;
  text-align: center;
  text-decoration: none;
  margin: 5px 2px;
  border-radius: 100%;
}

.fa:hover {
    opacity: 0.6;
}

.fa-facebook {
  background: #3B5998;
  color: white;
}

.fa-twitter {
  background: #55ACEE;
  color: white;
}

.fa-google {
  background: #dd4b39;
  color: white;
}

.fa-linkedin {
  background: #007bb5;
  color: white;
}

.fa-youtube {
  background: #bb0000;
  color: white;
}

.fa-instagram {
  background: #125688;
  color: white;
}

</style>
</head>
<body>

<div class="header">
  <h1>The Wash</h1>
  <p>A website created by The Wash</p>
</div>

<div class="navbar">
  <a href="location.php">Find Our Laundry Location</a>
  <a href="#">Link</a>
  <a href="#">Link</a>
  <a href="#" class="right">Link</a>
</div>

<div class="row">
  <div class="side">
      <h2>About Us</h2>
      <h5>Photo of us:</h5>
      <div class="fakeimg" style="height:200px;">Image</div>
      <p>Some random text </p>
      <h3>More Text</h3>
      <p>Don't know what to say</p>
      <div class="fakeimg" style="height:60px;">Image</div><br>
      <div class="fakeimg" style="height:60px;">Image</div><br>
      <div class="fakeimg" style="height:60px;">Image</div>
  </div>
  <div class="main">
      <h2>Random TITLE for text</h2>
      <h5>Title description</h5>
	  
<!-- Below code is used for the youtube iframe -->	  
<div style="text-align: center;">
	<button onclick="myFunction(1)">About Us</button>

	<button onclick="myFunction(2)">How to use our website</button>

	<button onclick="myFunction(3)">Commercial</button>
	<br></br>
</div>
<iframe id="test" style="display: block; margin: auto;" width="530" height="300"  src="https://www.youtube.com/embed/QwievZ1Tx-8" allowfullscreen ></iframe>
<script>
function myFunction(x) {
if(x == 1){
	document.getElementById("test").src = "https://www.youtube.com/embed/jPEYpryMp2s";
	}
else if(x == 2){
    document.getElementById("test").src = "https://www.youtube.com/embed/QwievZ1Tx-8";
    }
else if(x == 3){
    document.getElementById("test").src = "https://www.youtube.com/embed/jPEYpryMp2s";
    }
}
</script> <!-- Above code is used for the youtube iframe -->	

      <p>Some text..</p>
      <p>Gibberish for now. No clue what to write sdaghvfxcvgzhdfhssgh fdsghbvc srtdyjhbgzvCZdvbgnfdhmxzd hjnbvcbnf xxv gnfyjtukrjngb xgfhbnyujtyghxcvbn xnhcgynhgxb </p>
      <br>
      <h2>TITLE HEADING</h2>
      <h5>Title description, Maybe a date</h5>
	  <div style="text-align: center;">		
		<a href="location.php" target="__blank" style="text-decoration:none">
		<button>Find Our Laundry Location</button>
		</a>
		<br></br>
		
	  </div>
	  
	  <iframe style="display: block; margin: auto;"
	  width="100%" height="750" src="location.php">
</iframe>
      <p>Some text..</p>
      <p>Gibberish for now. No clue what to write sdaghvfxcvgzhdfhssgh fdsghbvc srtdyjhbgzvCZdvbgnfdhmxzd hjnbvcbnf xxv gnfyjtukrjngb xgfhbnyujtyghxcvbn xnhcgynhgxb </p>
  </div>
</div>

<div class="footer">
  <h2>Follow Us To See What We Are Doing</h2>
  <a href="#" class="fa fa-facebook"></a>
  <a href="#" class="fa fa-twitter"></a>
  <a href="#" class="fa fa-google"></a>
  <a href="#" class="fa fa-linkedin"></a>
  <a href="#" class="fa fa-youtube"></a>
  <a href="#" class="fa fa-instagram"></a>
</div>

</body>  
</html>
