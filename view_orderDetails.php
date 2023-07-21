<?php
session_start();

if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
      ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Company</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
   <?php include_once('include/navigation.php')?>
    
   <div id="body">
       <?php
            $conn=mysqli_connect('localhost','root','','dms');
            $sql="SELECT * from orders as o
            inner join order_details od on o.order_id = od.order_id
            order by order_date asc";
            $result=mysqli_query($conn,$sql);
            $data=[];
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    array_unshift($data,$row);
                }
            }
       ?>
       <h1>view Order details</h1>
       <br>
       <form action="" method="post">
           <table >
               <thead>
                   <tr>
                       <th>Order Id</th>
                       <th>Order Date</th>
                       <th>Customer Id</th>
                       <th>Product Id</th>
                       <th>Quantity Order</th>
                       <th>price_each</th>
                       <!-- <th>Action</th> -->


                   </tr>
               </thead>
               <?php
                    foreach($data as $d){

               ?>
               <tbody>
                   <td><?php echo $d['order_id'] ; ?></td>
                   <td><?php echo $d['order_date'] ; ?></td>
                   <td><?php   $id=$d['customer_id'];
                    $res=mysqli_query($conn,"select fullname from customers where customer_id=$id");
                    $row=mysqli_fetch_assoc($res);
                    echo $row['fullname']; ?></td>
                   <td><?php  $id=$d['product_id'];
                    $res=mysqli_query($conn,"select product_name from products where product_id=$id");
                    $row=mysqli_fetch_assoc($res);
                    echo $row['product_name']; ?></td>
                   <td><?php echo $d['quantity_order'];?></td>
                   <td><?php echo $d['price_each'];?></td>


                   <!-- <td>
                       <a href="invoice.php?order_id=<?php echo $d['order_id']  ?>">Print Invoice</a>
                    </td> -->
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