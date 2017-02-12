<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "hym19921120";
    $dbname = "outdoor application";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $user = $_GET['un'];
    $activityID=$_GET['id'];//here is locationid
    $lname=$_GET['lname'];
    //echo $activityID;
    $query=$conn->query("select locationID, count(*) as num from LIKE_LOCATION where locationID='$activityID' group by locationID");
    $id = $activityID;
    $likes = 0;
    while($row = $query->fetch_assoc()){
        $id = $row['locationID'];
        $likes = $row['num'];
    }
    
    $res=$conn->query("select locationID, count(*) as num from DISLIKE_LOCATION where locationID='$activityID' group by locationID");
    $id2 = $activityID;
    $dislikes = 0;
    while($r=$res->fetch_assoc()){
        $id2 = $r['locationID'];
        $dislikes = $r['num'];
    }
    //......
    $query=$conn->query("select * from LIKE_LOCATION where uname='$user' and locationID='$activityID'");
    $uname="";
    while($row1 = $query->fetch_assoc()){
        $uname = $row1['uname'];
    }
    
    $res=$conn->query("select * from DISLIKE_LOCATION where uname='$user' and locationID='$activityID'");
    $uname1="";
    while($r1=$res->fetch_assoc()){
        $uname1 = $r1['uname'];
    }
    //......
    if(isset($_POST['like'])){
        header("Location:show_location.php?id=$activityID&un=$user&lname=$lname");
        $sql = "insert into LIKE_LOCATION(locationID,uname) values('$activityID','$user')";
        $insert1=$conn->query($sql);
    }
    if(isset($_POST['unlike'])){
        header("Location:show_location.php?id=$activityID&un=$user&lname=$lname");
        $delete1=$conn->query("delete from LIKE_LOCATION where locationID='$activityID' and uname='$uname'");
    }
    
    if(isset($_POST['dislike'])){
        header("Location:show_location.php?id=$activityID&un=$user&lname=$lname");
        $sql = "insert into DISLIKE_LOCATION(locationID,uname) values('$activityID','$user')";
        $insert1=$conn->query($sql);
    }
    if(isset($_POST['disl'])){//cancal dislike
        header("Location:show_location.php?id=$activityID&un=$user&lname=$lname");
        $delete1=$conn->query("delete from DISLIKE_LOCATION where locationID='$activityID' and uname='$uname1'");
    }
    //......
    if(isset($activityID)){
        if($id==$activityID){
            echo "<div style='position:absolute; top:773px;right:590px;'><h4>LIKES:$likes<br/></h4></div>";
            if($uname===""){
                echo "<form action='' method='post'><input type='submit' name='like' value='LIKE' style='position:absolute; top:780px;right:680px;'></form>";
            }else{
                echo "<form action='' method='post'><input type='submit' name='unlike' value='LIKE' style='color: red;position:absolute; top:780px;right:680px;'></form>";
            }
        }else{
            //header("Location:page.php");
        }
    }else{
        die("Error: Not Found");
    }
    
    if(isset($activityID)){
        if($id2==$activityID){
            echo "<div style='position:absolute; top:803px;right:575px;'><h4>DISLIKES:$dislikes<br/></h4></div>";
            if($uname1===""){
                echo "<form action='' method='post'><input type='submit' name='dislike' value='DISLIKE' style='position:absolute; top:810px;right:680px;'></form>";
            }else{
                echo "<form action='' method='post'><input type='submit' name='disl' value='DISLIKE' style='color: blue;position:absolute; top:810px;right:680px;'></form>";
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

<title>View Location</title>
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
    echo "<li class='active'><a href='view_feed.php?un=$uname'>View Feed</a></li>";
    echo "<li><a href='person.php'>Log Out</a></li>";
    ?>

</div>
</div>

<style>
body{
    font-family:arial;
    font-size:1.3em;
}

input[type=text]{
padding:0.5em;
width:20em;
}

input[type=submit]{
padding:0.4em;
}

#gmap_canvas{
width:100%;
height:30em;
}

#map-label,
#address-examples{
margin:1em 0;
}
</style>

</head>
<body>

<?php
    $lname = $_GET['lname'];
        
        // get latitude, longitude and formatted address
        $data_arr = geocode($lname);
        
        // if able to geocode the address
        if($data_arr){
            
            $latitude = $data_arr[0];
            $longitude = $data_arr[1];
            $formatted_address = $data_arr[2];
            
            ?>

<!-- google map will be shown here -->
<div id="gmap_canvas">Loading map...</div>
<div id='map-label'>Map shows approximate location.</div>

<!-- JavaScript to show google map -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
<script type="text/javascript">
function init_map() {
    var myOptions = {
    zoom: 14,
    center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
    mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
    marker = new google.maps.Marker({
                                    map: map,
                                    position: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>)
                                    });
    infowindow = new google.maps.InfoWindow({
                                            content: "<?php echo $formatted_address; ?>"
                                            });
    google.maps.event.addListener(marker, "click", function () {
                                  infowindow.open(map, marker);
                                  });
    infowindow.open(map, marker);
}
google.maps.event.addDomListener(window, 'load', init_map);
</script>

<?php
    
    // if unable to geocode the address
    
    }else{
        echo "No map found.";
    }
    
    ?>

<div id='address-examples'>
<div>Address examples:</div>
<div>1. G/F Makati Cinema Square, Pasong Tamo, Makati City</div>
<div>2. 80 E.Rodriguez Jr. Ave. Libis Quezon City</div>
</div>



<?php
    $uname=$_GET['un'];
    // function to geocode address, it will return false if unable to geocode address
    function geocode($address){
        
        // url encode the address
        $address = urlencode($address);
        
        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
        
        // get the json response
        $resp_json = file_get_contents($url);
        
        // decode the json
        $resp = json_decode($resp_json, true);
        
        // response status will be 'OK', if able to geocode given address
        if($resp['status']=='OK'){
            
            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];
            echo $lati;
            echo $longi;
            echo $formatted_address;
            // verify if data is complete
            if($lati && $longi && $formatted_address){
                
                // put the data in the array
                $data_arr = array();
                
                array_push(
                           $data_arr,
                           $lati,
                           $longi,
                           $formatted_address
                           );
                
                return $data_arr;
                
                
            }else{
                return false;
            }
            
            
        }else{
            return false;
        }
        
    }
    
    
    ?>



<footer>
<div class="container">
<p>Sportsnet Copyright &copy; 2016.  All Rights Reserved</p>
</div>
</footer>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

</body>
</html>