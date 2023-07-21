<?php
session_start();
$conn=mysqli_connect('localhost','root','','dms');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ADD contact</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
    <?php include_once('include/navigation.php')?>
        <?php
               
                $erremail=$erraddress=$errfname=$errgender=$errphone='';
                if(isset($_POST['submit']))
                {   $fullname=$email=$address=$phone=$gender='';
                    $fullname=$_POST['fullname'];
                    $email=$_POST['email'];
                    $address=$_POST['address'];
                    $phone=$_POST['phone'];
                    $gender=$_POST['gender'];
                    if(empty($fullname)){
                    $errfname ="please enter your fullname"."<br>";
                    }
                    if(empty($email) ){
                        $erremail ="please enter your email"."<br>";
                        }
                    
                            
                    else if(empty($address)){
                        $erraddress ="please enter your address"."<br>";
                    }
                    else if(empty($phone)){
                        $errphone ="please enter your phone"."<br>";
                    }
                    else if(empty($gender)){
                        $errgender ="please enter your gender"."<br>";
                    }else{
                    $conn=mysqli_connect('localhost','root','','dms') or die("Error: could not connect.".mysqli_connect_error());
                    $sql="INSERT into customers(fullname,email,address,phone,gender)
                    VALUES(?,?,?,?,?)";
                    if($stmt=mysqli_prepare($conn,$sql)){
                    mysqli_stmt_bind_param($stmt,'sssis',$fullname,$email,$address,$phone,$gender);
                    
                    
                    if(mysqli_stmt_execute($stmt)){
                    echo "company added successfully";
                    echo "<script> window.location.href='add_customer.php'</script>";
                    }
                    else{
                    echo "something went wrong. Please try again";
                    echo "<script> alert(window.location.href='customer_details.php'</script>)";
                 }
                }
                 else{
                    echo " Error: could not prepared query: $sql.".mysqli_error($conn);
                     }
                
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                    }
            }
                
        ?>
        <div id="body">
        <h1>Add Company</h1>
        
        <div>
            <br>
        <form action="" method="post">
                
                    Full Name: <input type="text" name="fullname" ><br>
                    <div id="message"><?php 
                     echo $errfname;
                      ?> </div>
                    Email: <input type="text" name="email" ><br><div id="message"><?php 
                     echo $erremail;
                      ?> </div>
                    Address: <input type="text" name="address" ><br><div id="message"><?php 
                     echo $erraddress;
                      ?> </div>
                    Phone: <input type="number" name="phone" ><br><div id="message"><?php 
                     echo $errphone;
                      ?> </div>
                    Gender:<select class="option" id="gender" name="gender" value="gender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                    <div id="message">
                     </select><br>
                        <?php 
                     echo $errgender;
                      ?> </div>
                    <input type="submit" value="ADD" name="submit" >
        </form>
        </div>
        </div>
<?php include_once('include/footer.php')?>

</body>
</html>
<?php
}
?>