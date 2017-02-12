<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "hym19921120";
    $dbname = "outdoor application";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $user = $_GET['vn'];//log in user
    $owner = $_GET['un'];
    $activityID=$_GET['id'];
    //echo $activityID;
    $query=$conn->query("select diaryID, count(*) as num from LIKE_DIARY where diaryID='$activityID' group by diaryID");
    $id = $activityID;
    $likes = 0;
    while($row = $query->fetch_assoc()){
        $id = $row['diaryID'];
        $likes = $row['num'];
    }
    
    $res=$conn->query("select diaryID, count(*) as num from DISLIKE_DIARY where diaryID='$activityID' group by diaryID");
    $id2 = $activityID;
    $dislikes = 0;
    while($r=$res->fetch_assoc()){
        $id2 = $r['diaryID'];
        $dislikes = $r['num'];
    }
    //......
    $query=$conn->query("select * from LIKE_DIARY where uname='$user' and diaryID='$activityID'");
    $uname="";
    while($row1 = $query->fetch_assoc()){
        $uname = $row1['uname'];
    }
    
    $res=$conn->query("select * from DISLIKE_DIARY where uname='$user' and diaryID='$activityID'");
    $uname1="";
    while($r1=$res->fetch_assoc()){
        $uname1 = $r1['uname'];
    }
    //......
    if(isset($_POST['like'])){
        header("Location:cons_diary.php?id=$activityID&vn=$user&un=$owner");
        $sql = "insert into LIKE_DIARY(diaryID,uname) values('$activityID','$user')";
        $insert1=$conn->query($sql);
    }
    if(isset($_POST['unlike'])){
        header("Location:cons_diary.php?id=$activityID&vn=$user&un=$owner");
        $delete1=$conn->query("delete from LIKE_DIARY where diaryID='$activityID' and uname='$uname'");
    }
    
    if(isset($_POST['dislike'])){
        header("Location:view_diary.php?id=$activityID&un=$user");
        $sql = "insert into DISLIKE_DIARY(diaryID,uname) values('$activityID','$user')";
        $insert1=$conn->query($sql);
    }
    if(isset($_POST['disl'])){//cancal dislike
        header("Location:view_diary.php?id=$activityID&un=$user");
        $delete1=$conn->query("delete from DISLIKE_DIARY where diaryID='$activityID' and uname='$uname1'");
    }
    //......
    if(isset($activityID)){
        if($id==$activityID){
            echo "<div style='position:absolute; top:150px;right:200px;'><h4>LIKES:$likes<br/></h4></div>";
            if($uname===""){
                echo "<form action='' method='post'><input type='submit' name='like' value='LIKE' style='position:absolute; top:160px;right:280px;'></form>";
            }else{
                echo "<form action='' method='post'><input type='submit' name='unlike' value='LIKE' style='color: red;position:absolute; top:160px;right:280px;'></form>";
            }
        }else{
            //header("Location:page.php");
        }
    }else{
        die("Error: Not Found");
    }
    
    if(isset($activityID)){
        if($id2==$activityID){
            echo "<div style='position:absolute; top:185px;right:175px;'><h4>DISLIKES:$dislikes<br/></h4></div>";
            if($uname1===""){
                echo "<form action='' method='post'><input type='submit' name='dislike' value='DISLIKE' style='position:absolute; top:190px;right:280px;'></form>";
            }else{
                echo "<form action='' method='post'><input type='submit' name='disl' value='DISLIKE' style='color: blue;position:absolute; top:190px;right:280px;'></form>";
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
    //$uname=$_GET['un'];
    $vname=$_GET['vn'];//log in user
    echo "<li><a href='person.php?un=$vname'>Home</a></li>";
    echo "<li><a href='profile_edit.php?un=$vname'>Edit Profile</a></li>";
    echo "<li class='active'><a href='view_feed.php?un=$vname'>View Feed</a></li>";
    echo "<li><a href='person.php'>Log Out</a></li>";
    ?>


</ul>
</div><!--/.nav-collapse -->
</div>
</nav>

<div style='text-align:center;'>

<?php
    $uname=$_GET['vn'];//log in user
    $owner = $_GET['un'];
    $id =$_GET['id'];
    
    echo "<h1>$owner's diary</h1>";
    $servername = "127.0.0.1";
    $username = "root";
    $password = "hym19921120";
    $dbname = "outdoor application";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT constraints FROM DIARY WHERE diaryID = $id";
    $result = $conn->query($sql);
    if ($titleresult!==false) {
        while($row = $result->fetch_assoc()) {
            $c=$row['constraints'];//get the constraint
        }
    }
    $true=0;
    if($c===friend){
        $sql = "select A_name as friend from FRIENDSHIP where B_name = '$owner' union select B_name as friend from FRIENDSHIP where A_name = '$owner'";
        $query=$conn->query($sql);
        if ($query !== false) {
            while($row = $query->fetch_assoc()) {
                if($uname===$row['friend']){$true=1;}
            }
        }
    }elseif($c===FOF){
        $sql = "select A_name as FOF from FRIENDSHIP where (B_name in (select A_name from FRIENDSHIP where B_name = '$owner') or B_name in(select B_name from FRIENDSHIP where A_name = '$owner')) and A_name<>'$owner' union select B_name as FOF from FRIENDSHIP where (A_name in (select A_name from FRIENDSHIP where B_name = '$owner') or A_name in(select B_name from FRIENDSHIP where A_name = '$owner')) and B_name<>'$owner'";
        $query=$conn->query($sql);
        if ($query !== false) {
            while($row = $query->fetch_assoc()) {
                if($uname===$row['FOF']){$true=1;}
            }
        }
    }else{
        $true=1;
    }

    if($true===1){
    $sqltitle = "SELECT title FROM DIARY WHERE diaryID = $id";
    $titleresult = $conn->query($sqltitle);
    if ($titleresult!==false) {
        // output data of each row
        while($rowtitle = $titleresult->fetch_assoc()) {
            echo 'Title:'. $rowtitle['title'].'<br>';
        }
    } else {
        //echo "0 results";
    }
    echo "<br>";
    $sql = "SELECT photo FROM DIARY WHERE diaryID = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'"/>';
            echo "<br>";
        }
    } else {
        //echo "0 results";
    }
    
    $sql = "SELECT audio FROM DIARY WHERE diaryID = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(!is_null($row['audio'])){
            echo '<audio controls>';
            echo    '<source src="data:audio/mp3;base64,'.base64_encode($row['audio']).'" />';
            echo '</audio>';
            echo "<br>";
            }
        }
        
    } else {
        //echo "0 results";
    }
    
    $sql = "SELECT video FROM DIARY WHERE diaryID = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if(!is_null($row['video'])){
            echo '<video width="320" height="240" controls>';
            echo    '<source src="data:video/mp4;base64,'.base64_encode($row['video']).'" />';
            echo '</video>';
            echo "<br>";
            }
        }
        
    } else {
        //echo "0 results";
    }
    
    $sqltext = "SELECT text FROM DIARY WHERE diaryID = $id";
    $textresult = $conn->query($sqltext);
    if ($textresult->num_rows > 0) {
        // output data of each row
        while($rowtext = $textresult->fetch_assoc()) {
            echo $rowtext['text'].'<br>';
        }
    } else {
        //echo "0 results";
    }

    echo "<br>";
    
        $sqllocation = "SELECT locationID,lname FROM LOCATION natural join DIARY WHERE diaryID = $id";
        $locationresult = $conn->query($sqllocation);
        if ($locationresult->num_rows > 0) {
            // output data of each row
            while($rowlocation = $locationresult->fetch_assoc()) {
                echo "Location: ";
                $location = $rowlocation['lname'];
                $l = $rowlocation['locationID'];
                echo "<a href='show_location.php?lname=$location&un=$uname&id=$l'>$location</a><br>";
            }
        }else {
        //echo "0 results";
    }
    }else{
        echo "Sorry, you have no privileges to view this diary!";
    }
    ?>
    <div class="new-comment-form">
    <form class="form-inline" method = "post">
    <div class="form-group">
    
   <textarea cols="40" rows="7" class="form-control" placeholder="Enter Comment" name = "comment"></textarea>
    </div>
    <button type="submit" class="btn btn-default" name = "submit">Submit</button>
    </form>
    </div>
<?php
    if (isset($_POST['submit'])) {
        $comment = $_POST['comment'];
        $sqliscomment = "insert into COMMENT values (null,'$id','$comment','$uname','$owner',null)";
        $conn->query($sqliscomment);
    }
    $sqlcomment = "SELECT commentID,content,uname,reply_to,time FROM COMMENT WHERE diaryID = $id order by time desc";
    $commentresult = $conn->query($sqlcomment);
    if ($commentresult->num_rows > 0) {
      // output data of each row
      while($rowcomment = $commentresult->fetch_assoc()) {
         echo $rowcomment['uname']." reply to ".$rowcomment['reply_to'].":  ".$rowcomment['content'].'<br>'.$rowcomment['time'];
          $replyto = $rowcomment['reply_to'];
          $uname = $rowcomment['uname'];
          $commentid = $rowcomment['commentID'];
          
          ?>
            <?php echo "<a href='write_comment.php?val1=$uname&val2=$replyto&val3=$commentid&val4=$id'>";?>
            <?php echo "reply<br><br>";?>
            </a>


<?php
    
    
    
    
      }
    }
    
    
    else {
           //echo "0 results";
           }

?>

</div>
</div>

</div>
</body>
</html>