<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit profile</title>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">
<!--FontAwesome CSS-->
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/style 2.css" rel="stylesheet">
</head>

<body>
<header>
<div class="container">
<img src="img/6.png" class="logo">
<form class="form-inline">
</form>
</div>
</header>

<nav class="navbar navbar-default">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div id="navbar" class="collapse navbar-collapse">
<ul class="nav navbar-nav">

<?php
    $uname=$_GET['un'];
    echo "<li><a href='person.php?un=$uname'>Home</a></li>";
    echo "<li class='active'><a href='profile_edit.php?un=$uname'>Edit Profile</a></li>";
    echo "<li><a href='view_feed.php?un=$uname'>View Feed</a></li>";
    echo "<li><a href='person.php'>Log Out</a></li>";
    ?>
</ul>
</div><!--/.nav-collapse -->
</div>
</nav>

<div style='text-align:center;'>

<?php
   
    $user = $uname;
    $servername = "127.0.0.1";
    $username = "root";
    $password = "hym19921120";
    $dbname = "outdoor application";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sqlsl = "SELECT name,email FROM USER WHERE uname = '$uname'";
    $resultsl = $conn->query($sqlsl);
    if ($resultsl->num_rows > 0) {
        // output data of each row
        while($rowsl = $resultsl->fetch_assoc()) {
            $ofn = $rowsl['name'];
            $oem = $rowsl['email'];
            
            
        }
    }
    
    $sqlsl2 = "SELECT content FROM PROFILE WHERE uname = '$uname'";
    $resultsl2 = $conn->query($sqlsl2);
    
    if ($resultsl2->num_rows > 0) {
        // output data of each row
        while($rowsl2 = $resultsl2->fetch_assoc()) {
            $opf = $rowsl2['content'];
            
        }
    }
    
    if (isset($_POST['submit'])) {
        $privilege = $_POST['Privileges'];
        $profile = $_POST['content'];
        $fn = $_POST['fullname'];
        $em = $_POST['user_email'];
        $pw = $_POST['user_pass'];
        
        
        if ((($_FILES["photofile"]["type"] == "image/jpeg")
             || ($_FILES["photofile"]["type"] == "image/pjpeg"))
            )
        {
            if ($_FILES["photofile"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["photofile"]["error"] . "<br />";
            }
            else
            {
               // echo "Upload: " . $_FILES["photofile"]["name"] . "<br />";
              //  echo "Type: " . $_FILES["photofile"]["type"] . "<br />";
               // echo "Size: " . ($_FILES["photofile"]["size"] / 1024) . " Kb<br />";
              //  echo "Temp file: " . $_FILES["photofile"]["tmp_name"] . "<br />";
                
                if (file_exists("uploads/" . $_FILES["photofile"]["name"]))
                {
                    echo $_FILES["photofile"]["name"] . " already exists. ";
                }
                else
                {
                    move_uploaded_file($_FILES["photofile"]["tmp_name"],
                                       "uploads/" . $_FILES["photofile"]["name"]);
                    //echo "Stored in: " . "uploads/" . $_FILES["photofile"]["name"];
                }
                
 
                $image = addslashes(file_get_contents($_FILES["photofile"]["tmp_name"])); //SQL Injection defence!
                
            }
            
            
        }
        else echo "Photo is invalid!";
        
        
        $sql = "update PROFILE set content='$profile', time = now(), constraints = '$privilege' where uname = '$user'";
        $sql2 = "update USER set name = '$fn', password = '$pw', email = '$em', photo = '{$image}' where uname = '$user'";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        if (($result)&&($result2)) { // Error handling
            echo "Update successfully.";
            
        }
        else{
            echo "Submission failed";
        }
        
    }
   
    
    
    ?>
<div style='text-align:center'><h1>Edit Profile</h1></div>
<div class="content" style='text-align:center'>

<form  method="post" enctype="multipart/form-data">
<i class="fa fa-camera-retro"></i><label for="photofile">Photo:</label>
<div id="btn_upload_data" >
<input type="file" name="photofile" id="photofile" />
</div>
<p>
<label class="labels" for="name">Full Name:</label>
<input name="fullname" type="text" value="<?php echo $ofn; ?>" />
</p>
<p>
<label class="labels" for="email">Email Address:</label>
<input name="user_email" type="text" value="<?php echo $oem; ?>" />
</p>
<p>
<label class="labels" for="password">Password:</label>
<input name="user_pass" type="password" value="<?php echo ""; ?>" />
</p>
<p>Introduce yourself:</p>
<p>
<textarea cols="40" rows="7"  name="content"><?php echo $opf; ?></textarea>
</p>

<p><br/ >View Privileges:
<br />
<label>

<input type="radio" name="Privileges" value="friend" />
friend</label>
<br />
<label>
<input type="radio" name="Privileges" value="FOF" />
FOF</label>
<br />
<label>
<input type="radio" name="Privileges" value="everyone" />
everyone</label>
<p>
<input type="submit" value="Submit" name="submit"/>
</p>
</p>
</form>

</div>
</body>
</html>