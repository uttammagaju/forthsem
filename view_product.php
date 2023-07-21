<?php
session_start();

if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
      ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Product</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
   <?php include_once('include/navigation.php')?>
    <div id="body">
       <?php
            $conn=mysqli_connect('localhost','root','','dms');
            $sql="Select * from products Order By product_id desc";
            $result=mysqli_query($conn,$sql);
            $data=[];
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    array_unshift($data,$row);
                }
            }
            
       ?>
       <h1>Manage Product</h1>
       <br>
     <form method="post">
         <table>
             <thead>
                 <tr>
                     <th>Product Id</th>
                     <th>Product Name</th>
                     <th>Selling Price</th>
                     <th>Cost Price</th>
                     <th>Quantity Stock</th>
                     <th>Manufacture Date</th>
                     <th>Expired Date</th>
                     <th>Company Name</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <?php foreach($data as $d){
                 
             ?>
             <tbody>
                <td><?php echo $d['product_id']; ?></td>
                <td><?php echo $d['product_name']; ?></td>
                <td><?php echo $d['selling_price']; ?></td>
                <td><?php echo $d['cost_price']; ?></td>
                <td><?php echo $d['quantity_stock']; ?></td>
                <td><?php echo $d['mfg_date']; ?></td>
                <td><?php echo $d['expired_date']; ?></td>
                <td><?php $id=$d['company_id'];
                $sql1="select company_name from companys where company_id=$id";
                $res=mysqli_query($conn,$sql1);
                $row=mysqli_fetch_assoc($res);
                echo $row['company_name']; ?></td>
                <td>
                <a href="edit_product.php?product_id=<?php echo $d['product_id']  ?>">Edit</a>
                    <a href="delete_product.php?product_id=<?php echo $d['product_id']?>" 
                    onclick="return confirm('are you sure want to delete')">Delete</a>
                </td>


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