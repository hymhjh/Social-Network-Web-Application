<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<link rel="stylesheet" href="css/style4.css" />
</head>
<body>

<?php
    $vname=$_GET['un'];
    $uname=$_GET['vn'];
    echo "<div id='navigation'><ul><li><a href='person.php?un=$vname'>Home</a></li>";
    echo "<li><a href='searchactivity.php?un=$vname'>Search Activity</a></li>";
    echo "<li><a href='searchdiary.php?un=$vname'>Search Diary</a></li>";
    echo "<li><a href='logout.php?un=$vname'>LOG OUT</a></li></ul></div><div class='content'>";
    $user = $uname;
    if (isset($_POST['submit'])) {
        $greet = $_POST['greet'];
        $content = $_POST['content'];
        $servername = "127.0.0.1";
        $username = "root";
        $password = "hym19921120";
        $dbname = "outdoor application";
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "insert into GREETING values(null,'$uname','$vname','$greet','$content',now())";
        $result = $conn->query($sql);
        if ($result) {
            echo "Greeting to your friend successfully.";
            
        }
        else{
            echo "Submission failed";
        }
        
    }
    
    ?>
<div style='text-align:center'><h1>Create Greeting</h1></div>
<div class="content" style='text-align:center'>
<form method="post">
<p>
<label class="labels" for="name">GREETING:</label>
<input name="greet" type="text" value="<?php echo ""; ?>" />
</p>
<p>Give some tips to your friend:</p>
<p>
<textarea cols="40" rows="7" name="content" >
Tell friends something interesting, your favorite location, activity or...
</textarea>
</p>
<p>
<input type="submit" value="Submit" name="submit"/>
</p>
</form>

</div>
</body>
</html>