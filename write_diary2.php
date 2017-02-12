<!DOCTYPE html>
<html>
<head>
<title>Write Diary</title>
<link rel="stylesheet" href="css/style44.css" />
</head>
<body>
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
    
    $location = $_GET['var'];
    $lati = $_GET['var2'];
    $longi = $_GET['var3'];
    echo '<br>'."The location is: ".$location;
    echo "<div style='position:absolute; top:80px;left:20px;'><form method='POST' action='location.php?un=$uname'><input type='submit' name='location' value='LOCATION'/></form></div>";
    //echo $lati;
    //echo $longi;
    
    if(isset($_POST['submit'])){
        
        $privilege = $_POST['Privileges'];
        //echo $privilege;
        
        if($_FILES['audiofile']['type']=='audio/mpeg' || $_FILES['audiofile']['type']=='audio/mpeg3' || $_FILES['audiofile']['type']=='audio/x-mpeg3' || $_FILES['audiofile']['type']=='audio/mp3' || $_FILES['audiofile']['type']=='audio/x-wav' || $_FILES['audiofile']['type']=='audio/wav')
        {
            if ($_FILES["audiofile"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["audiofile"]["error"] . "<br />";
            }
            else
            {
                echo "Upload: " . $_FILES["audiofile"]["name"] . "<br />";
                echo "Type: " . $_FILES["audiofile"]["type"] . "<br />";
                echo "Size: " . ($_FILES["audiofile"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["audiofile"]["tmp_name"] . "<br />";
                
                if (file_exists("uploads/" . $_FILES["audiofile"]["name"]))
                {
                    echo $_FILES["audiofile"]["name"] . " already exists. ";
                }
                else
                {
                    move_uploaded_file($_FILES["audiofile"]["tmp_name"],
                                       "uploads/" . $_FILES["audiofile"]["name"]);
                    echo "Stored in: " . "uploads/" . $_FILES["audiofile"]["name"];
                }
                
                
                
                
                $audio = $conn->real_escape_string(file_get_contents($_FILES ['audiofile']['tmp_name']));
            }
            
            
        }
        else echo "";
        
        echo $_FILES["photofile"]["type"];
        echo $_FILES["photofile"]["size"];
        if ((($_FILES["photofile"]["type"] == "image/gif")
             || ($_FILES["photofile"]["type"] == "image/jpeg")
             || ($_FILES["photofile"]["type"] == "image/pjpeg"))
            && ($_FILES["photofile"]["size"] < 20000))
        {
            if ($_FILES["photofile"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["photofile"]["error"] . "<br />";
            }
            else
            {
                echo "Upload: " . $_FILES["photofile"]["name"] . "<br />";
                echo "Type: " . $_FILES["photofile"]["type"] . "<br />";
                echo "Size: " . ($_FILES["photofile"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["photofile"]["tmp_name"] . "<br />";
                
                if (file_exists("uploads/" . $_FILES["photofile"]["name"]))
                {
                    echo $_FILES["photofile"]["name"] . " already exists. ";
                }
                else
                {
                    move_uploaded_file($_FILES["photofile"]["tmp_name"],
                                       "uploads/" . $_FILES["photofile"]["name"]);
                    echo "Stored in: " . "uploads/" . $_FILES["photofile"]["name"];
                }
                
                
                
                
                $image = addslashes(file_get_contents($_FILES["photofile"]["tmp_name"])); //SQL Injection defence!
               
            }
            
            
        }
        else echo "";
        
        if (($_FILES["videofile"]["type"] == "video/mp4")
            || ($_FILES["videofile"]["type"] == "video/mpg")
            || ($_FILES["videofile"]["type"] == "video/mpeg")
            || ($_FILES["videofile"]["type"] == "video/mov")
            || ($_FILES["videofile"]["type"] == "video/avi")
            || ($_FILES["videofile"]["type"] == "video/flv")
            || ($_FILES["videofile"]["type"] == "video/wmv"))
        {
            echo "hi";
            
            
            if ($_FILES["videofile"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["videofile"]["error"] . "<br />";
            }
            else
            {
                echo "Upload: " . $_FILES["videofile"]["name"] . "<br />";
                echo "Type: " . $_FILES["videofile"]["type"] . "<br />";
                echo "Size: " . ($_FILES["videofile"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["videofile"]["tmp_name"] . "<br />";
                if (file_exists("uploads/" . $_FILES["videofile"]["name"]))
                {
                    echo $_FILES["videofile"]["name"] . " already exists. ";
                }
                else
                {
                    move_uploaded_file($_FILES["videofile"]["tmp_name"],
                                       "uploads/" . $_FILES["videofile"]["name"]);
                    echo "Stored in: " . "uploads/" . $_FILES["videofile"]["name"];
                }
                
                
                
                $video = $conn->real_escape_string(file_get_contents($_FILES ['videofile']['tmp_name']));
              
                
                
                
                
            }
            
        }
        else echo "";
        
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "insert ignore into `LOCATION` values (null, '$location', '$longi', '$lati', '0', 0)";
        
        $result = $conn->query($sql);
        if (!$result) { // Error handling
            echo "Can not insert location :(";
        }
       
        
       
        $locationid = $conn->insert_id;
        echo " locationid: ".$locationid;
        if($locationid =='0'){
        
            $sql2 = "select locationID from `LOCATION` where lname = '$location'";
            $result2 = $conn->query($sql2);
            if (!$result2) { // Error handling
                echo "Can not select locationID :(";
            }
            
            while ($row = $result2->fetch_assoc()) {
                 $locationid = $row['locationID'];
            }

            
        }
        
        $sql3 = "insert into `DIARY` values (null, '$title', now(), '$content', '{$video}', '{$image}',  '{$audio}', '$privilege', '$locationid', '$uname',0)";
        $result3 = $conn->query($sql3);
        
        if (!$result3) { // Error handling
            echo "Can not insert diary :(";
        }
        
       
        
        
        
        
        
        
    
        
    }
    
    ?>

<div style='text-align:center'><h1>write a diary</h1></div>
<div class="content" style='text-align:center'>
<form  method="post" enctype="multipart/form-data">
<label for="photofile">Photo:</label>
<input type="file" name="photofile" id="photofile" />
<br />

<label for="audiofile">Audio:</label>
<input type="file" name="audiofile" id="audiofile" />
<br />


<label for="videofile">Video:</label>
<input type="file" name="videofile" id="videofile" />
<br />

<p>
<label class="labels" for="name">Title:</label>
<input name="title" type="text" value="<?php echo ""; ?>" />
</p>

<p>
<textarea cols="60" rows="20" name="content"></textarea>
</p>

<p>
<input type="submit" name = "submit" value="Submit" />
</p>

<p>View Privileges:
<label>
<br />
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

</p>

</form>
</div>
</body>
</html>