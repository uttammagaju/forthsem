<?php
session_start();
$message="";
if(isset($_POST['submit'])){
    $con =mysqli_connect('localhost','root','','dms') or die('unable to connect');
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql ="SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);
    if(is_array($row)){
        $_SESSION['id']=$row['admin_id'];
        $_SESSION['name']=$row['username'];
    }
    else{
        $message ="invalid username or password!";
    }
}
if(isset($_SESSION['id'])){
    header('location:index.php');
}
?>
<html lang="en">
<head>
    <title>Login page</title>
    <link rel="stylesheet" href="css/login.css">
   
</head>
<body>

    <form name="validation"  action="" method="post">
        <div class="login_dash">

            <div class="message"><?php if($message!=''){
                echo $message;
                } ?> </div>
                
        username: <input type="text" name="username" ><br>
        password: <input type="password" name="password" ><br>
        <div class="button">

            <input type="submit" value="Login" name="submit" onclick="login()">
            <p id="result"></p>
            <script type="text/javascript" src="js/login.js"></script>
        </div>
    </div>
   
    </form>



</body>
</html>