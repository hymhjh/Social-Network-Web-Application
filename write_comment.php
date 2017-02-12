<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>View Feed</title>
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
    //$uname = $_GET['val1'];
    $uname='angella77';
    
    
    echo "<li><a href='person.php?un=$uname'>Home</a></li>";
    echo "<li><a href='profile_edit.php?un=$uname'>Edit Profile</a></li>";
    echo "<li class='active'><a href='view_feed.php?un=$uname'>View Feed</a></li>";
    echo "<li><a href='person.php'>Log Out</a></li>";

?>
</ul>
</div><!--/.nav-collapse -->
</div>
</nav>
<div style='text-align:center;'>


<?php

    //$replyto = $_GET['val2'];
    $replyto = 'angella77';
    //$commentid = $_GET['val3'];
    $commentid = '60';
    $diaryid ='23';
    //$diaryid = $_GET['val4'];
    $owner = 'john';
    //$owner = $_GET['val5'];
    echo "<h1>$owner's diary</h1>";
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
    
    
   
    $sqltitle = "SELECT title FROM DIARY WHERE diaryID = $diaryid";
    $titleresult = $conn->query($sqltitle);
    if ($titleresult->num_rows > 0) {
        // output data of each row
        while($rowtitle = $titleresult->fetch_assoc()) {
            echo 'Title:'. $rowtitle['title'].'<br>';
        }
    }
    echo "<br>";
    $sql = "SELECT photo FROM DIARY WHERE diaryID = '$diaryid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"/>';
            echo "<br>";
        }
    } else {
        //echo "0 results";
    }
    
    
    
    $sql = "SELECT audio FROM DIARY WHERE diaryID = $diaryid";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(!is_null($row['audio'])){
                echo '<audio controls>';
                echo    '<source src="data:audio/mp3;base64,'.base64_encode($row['audio']).'" />';
                echo '</audio>';
                echo "<br>";
            }
        }
        
    } else {
        //echo "0 results";
    }
    
    $sql = "SELECT video FROM DIARY WHERE diaryID = $diaryid";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(!is_null($row['video'])){
                echo '<video width="320" height="240" controls>';
                echo    '<source src="data:video/mp4;base64,'.base64_encode($row['video']).'" />';
                echo '</video>';
                echo "<br>";
            }
        }
        
    } else {
        //echo "0 results";
    }
    
    
    $sqltext = "SELECT text FROM DIARY WHERE diaryID = $diaryid";
    $textresult = $conn->query($sqltext);
    if ($textresult->num_rows > 0) {
        // output data of each row
        while($rowtext = $textresult->fetch_assoc()) {
            echo $rowtext['text'].'<br>';
        }
    }
    
    echo "<br>";
    
    $sqlcomment = "SELECT content,uname,reply_to,time FROM COMMENT WHERE commentID = $commentid";
    $commentresult = $conn->query($sqlcomment);
    if ($commentresult->num_rows > 0) {
        // output data of each row
        while($rowcomment = $commentresult->fetch_assoc()) {
            echo $rowcomment['uname']." reply to ".$rowcomment['reply_to'].": ".'<br>'.$rowcomment['content'].'<br>'.$rowcomment['time'].'<br>';
            echo "<br>";
            
        }
    }
    echo "You reply to ". $uname.":";
?>

<form method="post">
<p>

<textarea cols="40" rows="7" name="writecomment">
</textarea>
</p>
<p>

<input type="submit" value="Submit" name="submit"/>
</p>
</form>


<?php
 
 if (isset($_POST['submit'])) {
 
 $comment = $_POST['writecomment'];
 $insertsql = "insert into `COMMENT` values (null, '$diaryid', '$comment', '$uname', '$replyto', now())";
 
 $insertresult = $conn->query($insertsql);
  if ($insertresult) { // Error handling
    echo "Submit successfully.";
   echo ("<P><a href='view_diary.php?un=$uname&vn=$owner&id=$diaryid'>Back to diary</a></P>");
  }
  else{
      echo "Submission failed";
  }
     
 }
 
 
 
?>



</div>
</body>
</html>