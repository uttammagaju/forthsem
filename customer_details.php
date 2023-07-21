<?php
session_start();

if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
      ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Details</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
   <?php include_once('include/navigation.php')?>
    <div id="body">
       <?php
            $conn=mysqli_connect('localhost','root','','dms');
            $sql="SELECT * from customers order by customer_id desc";
            $result=mysqli_query($conn,$sql);
            $data=[];
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    array_unshift($data,$row);
                }
            }
       ?>
       <h1>Manage Customer Details</h1>
       <br>
       <form action="" method="post">
           <table >
               <thead>
                   <tr>
                       <th>Customer Id</th>
                       <th>Full name</th>
                       <th>Email</th>
                       <th>Address</th>
                       <th>Phone</th>
                       <th>Gender</th>
                   </tr>
               </thead>
               <?php
                    foreach($data as $d){

               ?>
               <tbody>
                   <td><?php echo $d['customer_id'] ; ?></td>
                   <td><?php echo $d['fullname'] ; ?></td>
                   <td><?php echo $d['email'] ; ?></td>
                   <td><?php echo $d['address'] ; ?></td>
                   <td><?php echo $d['phone'] ; ?></td>
                   <td><?php echo $d['gender'] ; ?></td>                   
                   
               </tbody>
               <?php
                    }
               ?>
           </table>
       </form>
    
    </div>
</div>
<?php include_once('include/footer.php')?>

</body>
</html>
<?php
}
?>