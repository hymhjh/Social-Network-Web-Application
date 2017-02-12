<?php
    session_start();
    include "inc.php";
    
    $user = $_GET['un'];
    $activityID=$_GET['aid'];
    
    $query=mysql_query("select activityID, count(*) as num from LIKE_ACTIVITY where activityID='$activityID' group by activityID");
    $row=mysql_fetch_assoc($query);//likes
    if($row===false){
        $id = $activityID;
        $likes = 0;
    }else{
        $id = $row['activityID'];
        $likes = $row['num'];
    }
    
    $res=mysql_query("select activityID, count(*) as num from DISLIKE_ACTIVITY where activityID='$activityID' group by activityID");
    $r=mysql_fetch_assoc($res);//dislikes
    if($r===false){
        $id2 = $activityID;
        $dislikes = 0;
    }else{
        $id2 = $r['activityID'];
        $dislikes = $r['num'];
    }
    //......
    $query=mysql_query("select * from LIKE_ACTIVITY where uname='$user' and activityID='$activityID'");
    $row1=mysql_fetch_assoc($query);
    $uname = $row1['uname'];
    
    $res=mysql_query("select * from DISLIKE_ACTIVITY where uname='$user' and activityID='$activityID'");
    $r1=mysql_fetch_assoc($res);
    $uname1 = $r1['uname'];
    //......
    if(isset($_POST['like'])){
        header("Location:activity.php?aid=$activityID&un=$user");
        $sql = "insert into LIKE_ACTIVITY(activityID,uname) values('$activityID','$user')";
        $insert1=mysql_query($sql);
    }
    if(isset($_POST['unlike'])){
        header("Location:activity.php?aid=$activityID&un=$user");
        $delete1=mysql_query("delete from LIKE_ACTIVITY where activityID='$activityID' and uname='$uname'");
    }
    
    if(isset($_POST['dislike'])){
        header("Location:activity.php?aid=$activityID&un=$user");
        $sql = "insert into DISLIKE_ACTIVITY(activityID,uname) values('$activityID','$user')";
        $insert1=mysql_query($sql);
    }
    if(isset($_POST['disl'])){//cancal dislike
        header("Location:activity.php?aid=$activityID&un=$user");
        $delete1=mysql_query("delete from DISLIKE_ACTIVITY where activityID='$activityID' and uname='$uname1'");
    }
    //......
    if(isset($activityID)){
        if($id==$activityID){
            echo "<div style='position:absolute; top:480px;right:300px;'><h4>LIKES:$likes<br/></h4></div>";
            if($row1===false){
                echo "<form action='' method='post'><input type='submit' name='like' value='LIKE' style='position:absolute; top:490px;right:380px;'></form>";
            }else{
                echo "<form action='' method='post'><input type='submit' name='unlike' value='LIKE' style='color: red;position:absolute; top:490px;right:380px;'></form>";
            }
        }else{
            header("Location:page.php");
        }
    }else{
        die("Error: Not Found");
    }
    
    if(isset($activityID)){
        if($id2==$activityID){
            echo "<div style='position:absolute; top:510px;right:275px;'><h4>DISLIKES:$dislikes<br/></h4></div>";
            if($r1===false){
                echo "<form action='' method='post'><input type='submit' name='dislike' value='DISLIKE' style='position:absolute; top:520px;right:380px;'></form>";
            }else{
                echo "<form action='' method='post'><input type='submit' name='disl' value='DISLIKE' style='color: blue;position:absolute; top:520px;right:380px;'></form>";
            }
        }else{
            //header("Location:page.php");
            echo $id2;
        }
    }else{
        die("Error: Not Found");
    }
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Show activity</title>
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
    echo "<li><a href='feed-view.php?un=$uname'>View Feed</a></li>";
    echo "<li><a href='searchactivity.php?un=$uname'>Search Activity</a></li>";
    echo "<li><a href='requestfriend.php?un=$uname'>Search User</a></li>";
    echo "<li><a href='searchdiary.php?un=$uname'>Search Diary</a></li>";
    echo "<li><a href='allfriends.php?un=$uname'>Friends List</a></li>";
    echo "<li><a href='write_diary2.php?un=$uname'>Post Diary</a></li>";
    echo "<li><a href='logout.php?un=$uname'>Log Out</a></li>";
    ?>
</ul>
</div><!--/.nav-collapse -->
</div>
</nav>

<div class="container">
<div class="row">


<div class="panel-body">
<form>
</form>


<br></br>
<div style="text-align:center;">




<?php
    
    $aid=$_GET['aid'];
    $servername = "localhost";
    $username = "root";
    $password = "hym19921120";
    $conn=mysql_connect($servername, $username, $password);
    if(!$conn){
        die("Connection failed: " . mysql_connect_error());
    }
    $db = mysql_select_db('outdoor application', $conn);
    if (!$db) {
        die('Cannot use database outdoor application . '. mysql_error());
    }
    $sql="select * from ACTIVITY A,ACTIVITY_LOCATION L,LOCATION N where A.activityID = $aid and A.activityID=L.activityID and L.locationID=N.locationID";
    $res=mysql_query($sql,$conn);
    if ($res !== false) {
        while($r = mysql_fetch_array($res, MYSQL_NUM)) {
            echo "<h5 style='font-size:18pt;color:blue; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;text-align:center;'><p>&nbsp;$r[1]</p></h5>";
            echo"<div style='text-align:center'>Location:<a href='show_location.php?lname=$r[10]&id=$r[8]&un=$uname'>$r[10]</a>&nbsp;&nbsp;&nbsp;&nbsp;Organizer:$r[5]</div>";
            echo "<h5 style='text-align:center'>Activity Time: $r[3]</h5>";
            echo "<h5 style='position:absolute; top:340px;right:250px;border:4px solid green;font-size:14pt;color:#4876FF; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;HEIGHT:127px;WIDTH: 800px;text-align:center;'><br><p>CONTENT:</p><p>$r[2]</p></h5>";
        }
    }
    ?>
</body>
</html>
