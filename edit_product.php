<?php
session_start();

if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
      ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product </title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
   
   <?php include_once('include/navigation.php') ?>
    <div id="body">
       <?php
            $product_id=$_GET['product_id'];
           echo $product_id;
            $conn=mysqli_connect('localhost','root','','dms');
            if(isset($_POST['submit'])){
                $product_name=$_POST['product_name'];
                $product_id=$_POST['product_id'];
                $sp=$_POST['selling_price'];
                $cp=$_POST['cost_price'];
                $qtystc=$_POST['quantity_stock'];
                $mfgdatepick=$_POST['mfgdatepick'];
                $mfg=date('y-m-d',strtotime($mfgdatepick));
                $expdatepick=$_POST['expdatepick'];
                $exp=date('y-m-d',strtotime($expdatepick));
                $company_id=$_POST['company_id'];
                $query="UPDATE products set product_name='$product_name',selling_price='$sp',cost_price='$cp',quantity_stock='$qtystc',
                expired_date='$exp',mfg_date='$mfg',company_id='$company_id' where product_id='$product_id'";
                mysqli_query($conn,$query);
                if(mysqli_affected_rows($conn)==1){
                    header('location:view_product.php');
                }
                else{
                    echo "Data update failed ".mysqli_error($conn);
                }
            }
            $sql1="select * from products where product_id ='$product_id'";
            $res =mysqli_query($conn,$sql1);
            $data = mysqli_fetch_assoc($res);
       ?>
       <h1>Update Company </h1>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="product_id" value="<?php echo $data['product_id']  ?>">
        Product Name: <input type="text" name="product_name" value="<?php echo $data['product_name']?>"><br>
        Selling Price: <input type="text" name="selling_price" value="<?php echo $data['selling_price']?>" ><br>
        Cost Price: <input type="text" name="cost_price" value="<?php echo $data['cost_price']?>"><br>
        Quantity Stock: <input type="text" name="quantity_stock" value="<?php echo $data['quantity_stock']?>"><br>
        Manufacture Date: <input type="date" name="mfgdatepick" value="<?php echo $data['mfg_date']?>"> <br>
        Expire Date: <input type="date" name="expdatepick" value="<?php echo $data['expired_date']?>"><br>
        Company id: 
         <?php
            $sql2="select * from companys";
            $result=mysqli_query($conn,$sql2);
            echo "<select name='company_id'>";
            While($row=mysqli_fetch_assoc($result)){
          echo "<option value=$row[company_id]>". $row['company_name'] ."</option>";    
     }
     ?>   
    </select>

     <input type="submit" value="Update" name="submit">
        </form>
    
    </div>
</div>
<?php include_once('include/footer.php')?>

</body>
</html>
<?php
}?>