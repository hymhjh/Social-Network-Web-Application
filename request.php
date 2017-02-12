<html>
<head>
<title>Send Message</title>
<link rel="stylesheet" href="css/style44.css" />
</head>
<body style="background-color:#FCFCFC;">
<?php
    $uname=$_GET['on'];
    $fri=$_GET['nn'];//friend user name
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
    echo "<h2 style='font-size:20pt;color:black; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;WIDTH: 1250px;text-align:center;'><p>You have send a message to $fri!</p></h2>";
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
    $sql="insert into FRIEND_REQUEST values('$uname','$fri',now(),0)";
    $query=mysql_query($sql,$conn);
    ?>
</body>
</html>
