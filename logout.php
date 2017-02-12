<!DOCTYPE HTML>
<html>
<head>
<title>Outdoor Sport Personal Homepage</title>
<link rel="stylesheet" href="css/style44.css" />
<meta http-equiv="refresh" content="2;url='page.php'" >
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
    echo "<br></br>";
    include "inc.php";
    $sql="update USER set last_log_out_time=now() where uname='$uname'";
    mysql_query($sql);
    echo "<div style='text-align:center'><h3>You have successfully log out!</h3></div>";
    ?>
</body>
</html>