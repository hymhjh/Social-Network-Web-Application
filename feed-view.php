
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
    $uname=$_GET['un'];
    echo "<li><a href='person.php?un=$uname'>Home</a></li>";
    echo "<li><a href='profile_edit.php?un=$uname'>Edit Profile</a></li>";
    echo "<li class='active'><a href='feed-view.php?un=$uname'>View Feed</a></li>";
    echo "<li><a href='person.php'>Log Out</a></li>";
    ?>


</ul>
</div><!--/.nav-collapse -->
</div>
</nav>

<div class="container">
<div class="row">
<div class="col-md-8 wall-and-posts">
<div class="new-wall-post panel panel-default">

<div class="panel-body">
<form>
</form>
</div>
</div>

    
<?php
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
    
    $sql ="select diaryID,uname,title,text,video,photo,audio,time from DIARY
    where (uname in (select A_name from FRIENDSHIP where B_name = '$uname')
           or uname in (select B_name from FRIENDSHIP where A_name = '$uname'))
    order by time desc";
    
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            
            $name = $row['uname'];
            $diaryid = $row['diaryID'];
            $title = $row['title'];
            $time = $row[time];
            
        
            
            
?>




<div class="existing-post-and-comments-panel panel-body panel panel-default">
<div class="row">

<div class="col-sm-2 post-avatar thumbnail text-center">
<?php echo "<a href='visit.php?un=$uname&vn=$name'>";?>
<h5><?php echo "$name";?></h5>
</a>

<?php
    $sqlcl = "SELECT count(*) as s FROM LIKE_DIARY WHERE diaryID = $diaryid";
    $resultcl = $conn->query($sqlcl);
    while($rowcl = $resultcl->fetch_assoc()) {
        $sum = $rowcl['s'];
        echo "<i class='fa fa-thumbs-o-up'> $sum Likes</i>";
    }
    ?>



</div>

<div class="col-sm-10">
<div class="post bubble pointer pointer-border">
<p>

<?php echo "<a href='view_diary.php?un=$uname&vn=$name&id=$diaryid'>";?>
<h5><?php echo 'Title: '.$title.'<br>';?></h5>
</a>

<?php
    
    echo $row['text'].'<br>';
    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"/>'.'<br>';
    if(!is_null($row['audio'])){
        echo '<audio controls>';
        echo    '<source src="data:audio/mp3;base64,'.base64_encode($row['audio']).'" />';
        echo '</audio>'.'<br>';
    }
    if(!is_null($row['video'])){
        echo '<video width="320" height="240" controls>';
        echo    '<source src="data:video/mp4;base64,'.base64_encode($row['video']).'" />';
        echo '</video>'.'<br>';
    }
    ?>
</p>
</div>





<div class="existing-comments">
<?php
  $sqlcomment = "SELECT commentID,content,uname,reply_to,time FROM COMMENT WHERE diaryID = $diaryid order by time desc";
     $commentresult = $conn->query($sqlcomment);
     if ($commentresult->num_rows > 0) {
    // output data of each row
       while($rowcomment = $commentresult->fetch_assoc()) {
           ?>



<div class="clearfix"></div>
<div class="comment">
<a class="comment-avatar pull-left" href="#"></a>
<div class="comment-text">

<?php
           echo '<p>'.$rowcomment['uname']." reply to ".$rowcomment['reply_to'].": ".'<br>'.$rowcomment['content'].'<br>'.$rowcomment['time'].'</p>';
    

?>

</div>
<div class="clearfix"></div>
</div>

<?php
    }
    }
    ?>


</div>

</div>
</div>
</div>


<?php
    
    }
    }
    ?>




</div>

<div class="col-md-4 friends-and-groups">

<div class="friends panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">My Friends</h3>
</div>
<div class="panel-body">

<?php
    //$uname=$_GET['un'];
    $sqlf = "select photo,uname from USER where (uname in (select A_name from FRIENDSHIP where B_name = '$uname') or uname in (select B_name from FRIENDSHIP where A_name = '$uname')) limit 8";
    $resultf = $conn->query($sqlf);
    
    if ($resultf->num_rows > 0) {
       
        echo '<ul>';
        while($rowf = $resultf->fetch_assoc()) {
           // echo "yes";
            $name = $rowf['uname'];
            $photo =$rowf['photo'];
            echo "<li>";
            echo "<a class='thumbnail' href='visit.php?un=$uname&vn=$name' title='$name'>";
            echo '<img src="data:image/jpeg;base64,'.base64_encode($photo).'"/>'.'</a>'.'</li>';
            
    }
        echo "</ul>";
    }
    
    //echo "<a class='btn btn-primary' href='allfriends.php?un=$uname'>View all friends</a><div class = 'clearfix'></div></div></div><div class =‘groups panel panel-default’><div class=‘panel-heading’><h3 class=‘panel-title’>Friends like these activities: </h3></div>";
?>

<a class="btn btn-primary" href="allfriends.php?un=$uname">View all friends</a>
<div class = "clearfix"></div>
</div>
</div>

<div class ="groups panel panel-default">

<div class="panel-heading">
<h3 class="panel-title">Friends like these activities: </h3>
</div>

<?php
    
    $sqlla = "select L.uname,L.activityid, aname,L.time from LIKE_ACTIVITY L, ACTIVITY A where (L.uname in (select A_name from FRIENDSHIP where B_name = '$uname') or L.uname in (select B_name from FRIENDSHIP where A_name = '$uname')) and L.activityID=A.activityID order by L.time desc";
    $resultla = $conn->query($sqlla);
    
    if ($resultla->num_rows > 0) {
        
        while($rowla = $resultla->fetch_assoc()) {
            // echo "yes";
            $unamela = $rowla['uname'];
            $anamela = $rowla['aname'];
            $actvtid = $rowla['activityid'];
            
            echo "<a href='visit.php?un=$uname&vn=$unamela'>$unamela</a>";
            echo " like ";
            echo "<a href='activity.php?un=$uname&aid=$actvtid'>$anamela</a><br>";
        }
        
    }
    ?>

<div class="panel-body">


</div>

</div>

<div class ="groups panel panel-default">

<div class="panel-heading">
<h3 class="panel-title">Friends like these locations: </h3>
</div>

<?php
    
    $sqlll = "select LL.uname,lname,LL.time from LIKE_LOCATION LL, LOCATION L where (LL.uname in (select A_name from FRIENDSHIP where B_name = '$uname') or LL.uname in (select B_name from FRIENDSHIP where A_name = '$uname')) and LL.locationID=L.locationID order by LL.time desc";
    $resultll = $conn->query($sqlll);
    
    if ($resultll->num_rows > 0) {
        
        while($rowll = $resultll->fetch_assoc()) {
            // echo "yes";
            $unamell = $rowll['uname'];
            $lnamell = $rowll['lname'];
            echo "<a href='visit.php?un=$uname&vn=$unamell'>$unamell</a>";
            echo " like ";
            echo "<a href='show_location.php?lname=$lnamell'>$lnamell</a><br>";
        }
        
    }
    ?>

<div class="panel-body">


</div>

</div>



</div>
</div>

<footer>
<div class="container">
<p>Sportsnet Copyright &copy; 2016.  All Rights Reserved</p>
</div>
</footer>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

