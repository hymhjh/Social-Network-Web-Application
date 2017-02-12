<!DOCTYPE HTML>
<html>
<head>
<title>CREATE ACTIVITY</title>
<link rel="stylesheet" href="css/style44.css" />
<style>
.error {color: red;}
</style>
</head>
<body style="background-color:#F5F5F5;">
    <?php
    $uname = $_GET['un'];
        echo "<div id='navigation'><ul><li><a href='person.php?un=$uname'>Home</a></li>";
        echo "<li><a href='profile_edit.php?un=$uname'>Edit Profile</a></li>";
        echo "<li><a href='searchactivity.php?un=$uname'>Search Activity</a></li>";
        echo "<li><a href='requestfriend.php?un=$uname'>Search User</a></li>";
        echo "<li><a href='allfriends.php?un=$uname'>Friends List</a></li>";
        echo "<li><a href='feed-view.php?un=$uname'>View Feed</a></li>";
        echo "<li><a href='write_diary2.php?un=$uname'>Post Diary</a></li>";
        echo "<li><a href='searchdiary.php?un=$uname'>Search Diary</a></li>";
        echo "<li><a href='logout.php?un=$uname'>LOG OUT</a></li></ul></div><div class='content'>";
    $typeErr = $anameErr = $timeErr = "";
    $type = $content = $aname = $time = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["aname"])) {
            $anameErr = "Activity Name is required";
        } else {
            $aname = test_input($_POST["aname"]);
        }

        if (empty($_POST["type"])) {
            $typeErr = "Type is required";
        } else {
            $type = test_input($_POST["type"]);
        }
        
        if (empty($_POST["time"])) {
            $timeErr = "Time is required";
        } else {
            $time = test_input($_POST["time"]);
        }
       
        if (empty($_POST["content"])) {
            $content = "";
        } else {
            $content = test_input($_POST["content"]);
        }
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
        
        $location = $_GET['var'];
        $lati = $_GET['var2'];
        $longi = $_GET['var3'];
        echo '<br>'."The location is: ".$location;
        echo "<div style='position:absolute; top:80px;left:20px;'><form method='POST' action='location.php?un=$uname'><input type='submit' name='location' value='LOCATION'/></form></div>";
        
    if($_POST['submit']){
        $servername = "localhost";
        $username = "root";
        $Password = "hym19921120";
        $conn=mysql_connect($servername, $username, $Password);
        if(!$conn){
            die("Connection failed: " . mysql_connect_error());
        }
        mysql_select_db('outdoor application',$conn);
        
        $sql = "insert ignore into `LOCATION` values (null, '$location', '$longi', '$lati', '0', 0)";
        
        $result = mysql_query($sql);
        if (!$result) { // Error handling
            echo "Can not insert location :(";
        }
        
        $locationid = mysql_insert_id();
        //echo " locationid: ".$locationid;
        
        $sql="insert into ACTIVITY values(null,'$aname','$content','$time','$type','$uname',0)";
        $res = mysql_query($sql);
        if($res !== false){
            echo "<br></br>";
            echo "Create activity successfully!";
        }else{
            echo "<br></br>";
            echo "Sorry, there is something wrong, please try it again.";
        }
        $activityid = mysql_insert_id();
        //echo " activityid: ".$activityid;
        $sql="insert into ACTIVITY_LOCATION values('$activityid', '$locationid')";
        mysql_query($sql);
    }
    ?>
<div align="center"><h2 style="font-size:18pt;color:#3b5999; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;WIDTH: 500px;text-align:center;"><p>Share Your Activity!</p></h2>
<div align="center"><h4>Activity Content</h4>
<p><span class="error">* required field.</span></p>
<form method="POST" action="">
Activity Name: <input type="text" name="aname" value="<?php echo $aname;?>">
<span class="error">* <?php echo $anameErr;?></span>
<br><br>
Type: <input type="text" name="type" value="<?php echo $type;?>">
<span class="error">* <?php echo $typeErr;?></span>
<br><br>
Activity Time: <input type="text" name="time" value="<?php echo $time;?>">
<span class="error">* <?php echo $timeErr;?></span>
<br><br>
Content: <textarea name="content" rows="7" cols="50"><?php echo $content;?></textarea>
<br><br>
<input type="submit" name="submit" value="CREATE">
</form>
</div>
</body>
</html>