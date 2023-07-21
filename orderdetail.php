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
    <title>Order details</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
    <?php include_once('include/navigation.php')?>
        <?php
               $errproduct_id=$errprice_each=$errorder_id=$errquantity_order='';
             
               $conn=mysqli_connect('localhost','root','','dms') or die("Error: could not connect.".mysqli_connect_error());
               $product_id=$price_each=$order_id=$quantity_order='';
                 if(isset($_POST['submit'])){
                $order_id=$_POST['order_id'];
                $product_id= $_POST['product_id'];
                $quantity_order=$_POST['quantity'];
                $price_each=$_POST['price'];
                if(empty($product_id)){
                 $errproduct_id="please select product name"."<br>";
                }
                else if(empty($quantity_order)){
                    $errquantity_order= "please select Quantity"."<br>";
                    }
                else if(empty($order_id)){
                    $errorder_id= "please enter order id"."<br>";
                    }
                else if(empty($price_each)){
                         $errprice_each="please enter select product"."<br>";
                        }
                    
                else{
                $sql6="INSERT into order_details(order_id,product_id,quantity_order,price_each) VALUES(?,?,?,?)";
                if($stmt1=mysqli_prepare($conn,$sql6)){
                mysqli_stmt_bind_param($stmt1,'iisi',$order_id,$product_id,$quantity_order,$price_each);
                
                if(mysqli_stmt_execute($stmt1)){
                echo "company added successfully";
                echo "<script> window.location.href='view_orderDetails.php'</script>";
                }
                else{
                echo "something went wrong. Please try again";
                echo "<script> alert(window.location.href='orderdetail.php'</script>)";
             }
            }
        
             else{
                echo " Error: could not prepared query: $sql.".mysqli_error($conn);
                 }
                
            mysqli_stmt_close($stmt1);
             
            mysqli_close($conn);
        }
    } 
            
                
        ?>
        <div id="body">
        <h1>Order Details</h1>
        
        <div>
            <br>
        <form action="" method="post">
                Order id: 
                <select name="order_id" > 
                    <option value="">select order id</option>
                <?php
                $sql="select * from orders";
                $query=mysqli_query($conn,$sql);
               
                while($row=mysqli_fetch_assoc($query)){
                    echo "<option value=$row[order_id] >".$row['order_id']."</option>";
                }
                ?>
                </select>
                <br>
                <div id="message"><?php 
                     echo $errorder_id;
                      ?> </div>
                Product Name:
                <select name="product_id" > 
                    <option value="">select Product Name</option>
                <?php
                $sql2="select * from products";
                $query2=mysqli_query($conn,$sql2);
               
                while($row=mysqli_fetch_assoc($query2)){
                    echo "<option value=$row[product_id] >".$row['product_name']."</option>";
                }
                ?>
                </select>
                <div id="message"><?php 
                     echo $errproduct_id;
                      ?> </div>
                </select><br>
                Quantity Order: <input type="text" name="quantity" ><br>
                <div id="message"><?php 
                     echo $errquantity_order;
                      ?> </div>
                Select product: 
                <select name="price" > 
                    <option value="">select product</option>
                <?php
                $sql3="select * from products";
                $query3=mysqli_query($conn,$sql3);
                while($row=mysqli_fetch_assoc($query3)){
                    echo "<option value=$row[selling_price] >".$row['product_name']."</option>";
                }
                ?>
                </select><br>
                <div id="message"><?php 
                     echo $errprice_each;
                      ?> </div>
                
                    <input type="submit" value="ADD" name="submit" >
        </form>
        <div class="foot">
<?php include_once('include/footer.php')?>
<div>
        </div>
        </div>


</body>
</html>
<?php
}
?>