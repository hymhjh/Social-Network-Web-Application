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
    $uname=$_GET['nn'];
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
    //$uname=$_GET['nn'];
    $vname=$_GET['on'];//log in user
    
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
    echo "<br></br>";
    echo "<div style='text-align:center'><form method='POST' action='request.php?nn=$uname&on=$vname'><input type='submit' name='request' value='ADD FRIEND' style='color: #3b5999'/></form></div>";
    
    $sql = "SELECT photo FROM USER WHERE uname = '$uname'";
    $query = mysql_query($sql);
    if ($query !== false) {
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo '';
            echo '<div style="position:absolute; top:240px;left:50px;"><img src="data:image/jpeg;base64,'.base64_encode( $row[0] ).'" width="300" height="300"/></div>';
        }
    }
    echo "<br>";
    
    $sql="select * from PROFILE where uname='$uname'";
    $query=mysql_query($sql);//profile
    if ($query !== false) {
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo "<div style='text-align:center'><h2 style='font-size:16pt; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;text-align:center;'><p>PROFILE</p><p>$row[1]</p></h2></div>";
            echo "<div style='text-align:center;'>$row[2]</div>";
        }
    }
    
    $sql="select * from GREETING where uname='$uname' order by time desc limit 2";
    $query=mysql_query($sql);//greeting
    echo "<h3 style='text-align:center;color:#3b5999;'><p>GREETING!</p></h3>";

    if ($query !== false) {
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo "<div style='text-align:center'><p>$row[3]! &nbsp;$row[4]&nbsp;&nbsp;&nbsp;&nbsp;$row[2]<br></p></h2>$row[5]</div>";
            echo"<br>";
        }
    }
    
    $sql="select * from DIARY where uname='$uname' order by time desc limit 6";
    $query=mysql_query($sql);//diary
    echo "<h3 style='text-align:center;color:red;'><p><a href='alldiary.php?un=$vname'>DIARY</a></p></h3>";
    if ($query !== false) {
        echo"<br>";
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo "<div style='text-align:center;'><td><a href='cons_diary.php?id=$row[0]&un=$uname&vn=$vname'>$row[1]</a>&nbsp;&nbsp;&nbsp;&nbsp;$row[2]</td></div>";
            echo"<br>";
        }
    }
    
    $sql="select L.activityID,aname,A.time from LIKE_ACTIVITY L, ACTIVITY A where L.uname='$uname' and L.activityID=A.activityID order by time desc limit 3";
    $query=mysql_query($sql);//like-activity
    echo"<br>";
    echo "<h3 style='text-align:center;'><p>$uname 's FAVORITE ACTIVITY</p></h3>";
    if ($query !== false) {
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo "<div style='text-align:center;'><td><a href='activity.php?aid=$row[0]&un=$vname'>$row[1]</a> &nbsp;&nbsp;&nbsp;&nbsp;$row[2]</td></div>";
            echo"<br>";
        }
    }
    
    $sql="select A_name as friend,constraint_B as c from FRIENDSHIP where B_name='$uname' union select B_name as friend,constraint_A as c from FRIENDSHIP where A_name = '$uname' limit 6";
    $query=mysql_query($sql);//friendship
    $t=320;
    echo "<h5 style='position:absolute;top:250px;left:960px;font-size:18pt;color:#3b5999; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;text-align:center;'><p>$uname 's FRIENDS</p></h5>";
    if ($query !== false) {
        echo"<br>";
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            $true=0;
            if($row[1]===friend){
                $s = "select A_name as friend from FRIENDSHIP where B_name = '$uname' union select B_name as friend from FRIENDSHIP where A_name = '$uname'";
                $q=mysql_query($s);
                if ($q !== false) {
                    while($r = mysql_fetch_array($q, MYSQL_NUM)) {
                        if($vname===$r['friend']){$true=1;}
                    }
                }
            }elseif($row[1]===FOF){
                $s = "select A_name as FOF from FRIENDSHIP where (B_name in (select A_name from FRIENDSHIP where B_name = '$uname') or B_name in(select B_name from FRIENDSHIP where A_name = '$uname')) and A_name<>'$uname' union select B_name as FOF from FRIENDSHIP where (A_name in (select A_name from FRIENDSHIP where B_name = '$uname') or A_name in(select B_name from FRIENDSHIP where A_name = '$uname')) and B_name<>'$uname'";
                $q=mysql_query($s);
                if ($q !== false) {
                    while($r = mysql_fetch_array($q, MYSQL_NUM)) {
                        if($vname===$r['friend']){$true=1;}
                    }
                }
            }else{
                $true=1;
            }
            if($true===1){ //when the user can view her/his friend list
                echo "<div style='position:absolute;top:{$t}px;left:1040px;text-align:center;'><td><a href='ref.php?un=$row[0]&on=vname'>$row[0]</a></td></div>";
                echo"<br>";
                $t=$t+30;
            }
        }
    }
    
    ?>

</body>
</html>
