<!DOCTYPE HTML>
<html>
<head>
<title>SIGN UP</title>
<div align="center"><h2 style="font-size:18pt;color:#3b5999; text-shadow: 0 8px 9px #c4b59d, 0px -2px 1px #fff;WIDTH: 500px;text-align:center;"><p>Welcome to Outdoor Sports Social Community!</p></h2>
<style>
.error {color: red;}
</style>
</head>
<body style="background-color:#F5F5F5;">
    <?php
    $nameErr = $emailErr = $unameErr = $passErr ="";
    $name = $email = $profile = $uname = $age = $password = $city ="";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }
        if (empty($_POST["uname"])) {
            $unameErr = "User Name is required";
        } else {
            $uname = test_input($_POST["uname"]);
        }
        if (empty($_POST["password"])) {
            $passErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST["age"])) {
            $age = "";
        } else {
            $age = test_input($_POST["age"]);
        }
        if (empty($_POST["city"])) {
            $city = "";
        } else {
            $city = test_input($_POST["city"]);
        }
        if (empty($_POST["profile"])) {
            $profile = "";
        } else {
            $profile = test_input($_POST["profile"]);
        }
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if($_POST['submit']){
        $servername = "localhost";
        $username = "root";
        $Password = "hym19921120";
        $conn=mysql_connect($servername, $username, $Password);
        if(!$conn){
            die("Connection failed: " . mysql_connect_error());
        }
        mysql_select_db('outdoor application',$conn);
        $sql = "select uname from USER where uname = '$_POST[uname]'";
        $result = mysql_query($sql);
        $num = mysql_num_rows($result);
        if($num)    //the account already exists
        {
            echo "<script>alert('The account already exists'); history.go(-1);</script>";
        }
        else
        {
            $sql="insert into USER (uname,name,password,age,city,email,sign_up_date,last_log_out_time,photo) values('$uname','$name','$password','$age','$city','$email',curdate(),now(),LOAD_FILE('/Library/WebServer/Documents/22.jpg'))";
            mysql_query($sql);
            $sql="insert into PROFILE values (null, '$profile', now(), 'everyone', '$uname')";
            mysql_query($sql);
            echo"<div align='center'><form method='POST' action='person.php?un=$uname'><input type='submit' name='homepage' value='Homepage'></div>";
        }
    }
    ?>
<div align="center"><h1>Personal Information</h1>
<p><span class="error">* required field.</span></p>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Name: <input type="text" name="name" value="<?php echo $name;?>">
<span class="error">* <?php echo $nameErr;?></span>
<br><br>
UserName: <input type="text" name="uname" value="<?php echo $uname;?>">
<span class="error">* <?php echo $unameErr;?></span>
<br><br>
Password: <input type="text" name="password" value="<?php echo $password;?>">
<span class="error">* <?php echo $passErr;?></span>
<br><br>
E-mail: <input type="text" name="email" value="<?php echo $email;?>">
<span class="error">* <?php echo $emailErr;?></span>
<br><br>
Age: <input type="text" name="age" value="<?php echo $age;?>">
<br><br>
City: <input type="text" name="city" value="<?php echo $city;?>">
<br><br>
Profile: <textarea name="profile" rows="5" cols="40"><?php echo $profile;?></textarea>
<br><br>
<input type="submit" name="submit" value="submit">
</form>
</div>
</body>
</html>