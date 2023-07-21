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
               $errcompany_name='';

               $admin_id=$_SESSION['id'];
               
               $company_name='';
                if(isset($_POST['submit']))
                {   $company_name='';
                    
                    $company_name=$_POST['company_name'];
                    if(empty($company_name)){
                    $errcompany_name="please enter company name";
                    }
                    else{
                    $conn=mysqli_connect('localhost','root','','dms') or die("Error: could not connect.".mysqli_connect_error());
                    
            
                    $sql="INSERT into companys(company_name,admin_id)
                    VALUES(?,?)";
                    if($stmt=mysqli_prepare($conn,$sql)){
                    mysqli_stmt_bind_param($stmt,'si',$company_name,$admin_id);
                    $admin_id= $_SESSION['id'];
                    
                    if(mysqli_stmt_execute($stmt)){
                    echo "company added successfully";
                    echo "<script> window.location.href='view_company.php'</script>";
                    }
                    else{
                    echo "something went wrong. Please try again";
                    echo "<script> alert(window.location.href='ADD_company.php'</script>)";
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
                
                    Company Name: <input type="text" name="company_name" ><br>
                    <div id="message"><?php 
                     echo $errcompany_name;
                      ?> </div>
                    <input type="submit" value="ADD" name="submit" >
        </form>
    </div><div class="foot">
        <?php include_once('include/footer.php')?>
        </div>
        </div>
</body>


</html>
<?php
}
?>