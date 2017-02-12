<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sportsnet</title>
<link href="huadong.css" rel="stylesheet" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style 2.css" rel="stylesheet">
<link href="css/ekko-lightbox.css" rel="stylesheet">
</head>

<body>
<header>
<div class="container">
<img src="img/6.png" class="logo">
<?php
    if (isset($_POST['signin'])) {
        $un=$_POST['uname'];
        $pw=$_POST['pw'];
        
    }
   ?>
<form class='form-inline' method ='POST' action='sign_in.php'>


<div class="form-group">
<label class="sr-only" for="exampleInputEmail3">User name</label>
<input type="email" class="form-control" name= "uname" id="exampleInputEmail3" placeholder="User name">
</div>
<div class="form-group">
<label class="sr-only" for="exampleInputPassword3">Password</label>
<input type="password" class="form-control" name= "pw" id="exampleInputPassword3" placeholder="Password">
</div>
<button type="submit" name="signin" class="btn btn-default">Sign in</button><br>

<div>
<label>

<li><a href="sign_up.php" class="menu_link" style="color:#FFFFFF">New here?</a></li>

</label>
</div>
</form>
</div>
</header>
<div id="container">

<div id="header" style="text-align:center"><h1 style="color:#3b5999">Welcome to outdoor sport community</h1></div>

<div id="sub_header" style="color:#7EC0EE">Enjoy your day!</div>

<div id="main_content_top"></div>

<div id="main_content">

<div class="content">
<h2 style="color:#3b5999">WELCOME</h2>
<p>This website is for all outdoor sport fans, so feel free to use it as you want. There are our activities, welcome to join them.!</p>
<div class="thumb kort concave">
<img src="img/216.jpg" width="360" height="300">
<img src="img/212.jpg" width="360" height="300">
<img src="img/214.jpg" width="360" height="300">
<img src="img/h.jpg" width="360" height="300">
</div>

<script src="kort.js"></script>

<script>
if( navigator.userAgent.match( /firefox/gi ) ) {
    [].slice.call( document.querySelectorAll( '.thumb img' ) ).forEach(function( el ) { el.style.boxShadow = 'none'; });
}
</script>

<h2 style="color:#3b5999">INFORMATION</h2>
<p>Founded in April 2016, Sportsnet Outdoor Social Network is a new website that provides surrounding for people to join outdoor activities together and have the outdoor sports experience.  As the regional voice for tour pals, Sportsnet Outdoor Social Network recognizes that outdoor sports are essential to connect people with nature, conserve open space, provide biological corridors for diverse plants and wildlife, and for the health of human and our natural environment.
Welcome to Sportsnet Outdoor Social Network!</p>
</div>

<div class="menu">
<div class="menu_title" style="color:#3b5999">Main menu</div>
<ul>
<li><a href="#" class="menu_link">About me</a></li>
<li><a href="#" class="menu_link">Contact me</a></li>
<li><a href="search.php" class="menu_link">Search activity</a></li>
<br></br>
<div class="menu_title" style="color:#3b5999;font-size:14px;" >KEEP IN TOUCH</div>
<li>
Regional Headquarters:<br>
1111 00th Street<br>
Brooklyn, NY 11219<br></br></li>
<li>New York Office:<br>
XXX XXX Center<br>
777 88th Street<br></br></li>
<li>Manhattan, NY 10001<br>
1-999-999-9999 (Main)<br>
1-888-888-8888 (Toll-free)<br>
Info@Sportsnet.org (Email)</li>
</ul>



</div>

<div id="clear"></div>

</div>

<div id="main_content_bottom">
</div>

<div id="footer"><strong>Sportsnet Copyright &copy; 2016. All Rights Reserved</strong></div>

</div>

</body>

</html>