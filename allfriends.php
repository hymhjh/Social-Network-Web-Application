<html>
<head>
<title>friend list</title>
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
    $uname=$_GET['un'];
    $sql="select A_name as friend from FRIENDSHIP where B_name='$uname' union select B_name as friend from FRIENDSHIP where A_name = '$uname'";
    $query=mysql_query($sql);//friendship
    echo "<h5 style='font-size:18pt;color:#3b5999; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;text-align:center;'><p>YOUR FRIENDS</p></h5>";
    if ($query !== false) {
        echo"<br>";
        while($row = mysql_fetch_array($query, MYSQL_NUM)) {
            echo "<div style='text-align:center;'><td><a href='visit.php?vn=$row[0]&un=$uname'>$row[0]</a></td></div>";
            echo"<br>";
        }
    }
    ?>
</body>
</html>
