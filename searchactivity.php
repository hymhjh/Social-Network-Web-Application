<!DOCTYPE HTML>
<html>
<head>
<title>Outdoor Sport Personal Homepage</title>
<link rel="stylesheet" href="css/style44.css" />
</head>
<body style="background-color:#FCFCFC;">
<?php
    $uname=$_GET['un'];
    echo "<div id='navigation'><ul><li><a href='person.php?un=$uname'>Home</a></li>";
    echo "<li><a href='profile_edit.php?un=$uname'>Edit Profile</a></li>";
    echo "<li><a href='searchactivity.php?un=$uname'>Search Activity</a></li>";
    echo "<li><a href='requestfriend.php?un=$uname'>Search User</a></li>";
    echo "<li><a href='allfriends.php?un=$uname'>Friends List</a></li>";
    echo "<li><a href='feed-view.php?un=$uname'>View Feed</a></li>";
    echo "<li><a href='write_diary2.php?un=$uname'>Post Diary</a></li>";
    echo "<li><a href='searchdiary.php?un=$uname'>Search Diary</a></li>";
    echo "<li><a href='logout.php?un=$uname'>LOG OUT</a></li></ul></div><div class='content'>";
    ?>
<br></br>
<div style="text-align:center;">
<form method="post">
Search Activities: <input type="text" name="act" value="" />
<input type="submit" name="search" value="search"/><br/></div>
<?php
    if (isset($_POST['act']) && $_POST['act'] != '') {
        $name = $_POST['act'];
    } else {
        $name = '  ';
    }
    $uname=$_GET['un'];
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
    $sql="select * from ACTIVITY where aname LIKE '%{$name}%'";
    $res=mysql_query($sql,$conn);
    if ($res !== false) {
        while($r = mysql_fetch_array($res, MYSQL_NUM)) {
            echo "<div style='text-align:center;'><td><a href='activity.php?aid=$r[0]&un=$uname'>$r[1]</a></td></div>";
            echo"<br>";
        }
    }
    $query=mysql_query("call popular_activity()",$conn);
    echo "<h5 style='font-size:18pt;color:#3b5999; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;text-align:center;'><p>POPULAR ACTIVITIES LIST</p></h5>";
    if ($query !== false) {
        echo"<br>";
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo "<div style='text-align:center;'><td><a href='activity.php?aid=$row[0]&un=$uname'>$row[1]</a></td></div>";
            echo"<br>";
        }
    }
    ?>
</body>
</html>
