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
    <title>Dashboard</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
    <?php include_once('include/navigation.php') ?>
    
    <div id="dashboard">
        <div class="box">
            <h3>Number of Product</h3>
            <div class="circle"> 
                <?php
                $conn=mysqli_connect('localhost','root','','dms');
                $sql="SELECT COUNT(product_id) FROM  products";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    foreach($result as $row) {
                        echo $row['COUNT(product_id)'];
                        }
                }
                else{
                    echo "0";
                }
                ?>
            </div>
        </div>
        <div class="box">
            <h3>Number of Company </h3>
            <div class="circle">
            <?php
               $conn=mysqli_connect('localhost','root','','dms');
               $result=mysqli_query($conn,"SELECT COUNT(company_id) FROM  companys");
               if(mysqli_num_rows($result)>0){
                   foreach($result as $row) {
                       echo $row['COUNT(company_id)'];
                       }
               }
               else{
                   echo "0";
               }
                ?>
            </div>
        </div>
        <div class="box">
            <h3> Male Customer Visited  </h3>
            <div class="circle">
            <?php
                $conn=mysqli_connect('localhost','root','','dms');
                $sql="SELECT COUNT(gender) FROM  customers where gender='male'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    foreach($result as $row) {
                        echo $row['COUNT(gender)'] ;
                        }
                }
                else{
                    echo "0";
                }
                ?>
            </div>
        </div>
        <div class="box">
            <h3>Female Customer visited </h3>
            <div class="circle">
            <?php
                $conn=mysqli_connect('localhost','root','','dms');
                $sql="SELECT COUNT(gender) FROM  customers where gender='female'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    foreach($result as $row) {
                        echo $row['COUNT(gender)'] ;
                        }
                }
                else{
                    echo "0";
                }
                ?>
            </div>
        </div>
    
    </div>
</div>
<?php include_once('include/footer.php')?>
</body>
</html>
<?php
}?>