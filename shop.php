<?php
session_start();
$conn=mysqli_connect('localhost','root','','dms');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
      //code for Cart
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
    
    //code for adding product in cart
        case "add":
            if(!empty($_POST["quantity"])) {
                $pid=$_GET["pid"];
                $result=mysqli_query($conn,"SELECT * FROM products WHERE product_id='$pid'");
                  while($productByCode=mysqli_fetch_array($result)){
                $itemArray = array($productByCode["product_id"]=>array('company_id'=>$productByCode["company_name"], 'quantity'=>$_POST["quantity"], 'pname'=>$productByCode["product_name"], 'price'=>$productByCode["selling_price"],'code'=>$productByCode["product_id"]));
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode["Product_id"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode["product_id"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                }  else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
        }
        break; 
        // code for removing product from cart
    case "remove":
        if(!empty($_SESSION["cart_item"])) {
            foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);              
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
            }
        }
    break;
    // code for if cart is empty
    case "empty":
        unset($_SESSION["cart_item"]);
    break;  
}
}
//Code for Checkout
if(isset($_POST['checkout'])){
    $invoiceno= mt_rand(100000000, 999999999);
    $pid=$_SESSION['productid'];
    $quantity=$_POST['quantity'];
    $cname=$_POST['name'];
    $phone=$_POST['phone'];
    $pmode=$_POST['paymentmode'];
    $email=$_POST['email'];
    $gender=$_POST['gender'];
    $address=$_POST['address'];
    $value=array_combine($pid,$quantity);
    foreach($value as $pdid=> $qty){
    $query=mysqli_query($conn,"insert into customers(fullname,email,address,phone,gender) values('$name','$email','$address','$phone','$gender')") ; 
    $query=mysqli_query($conn,"insert into orders(ProductId,Quantity,InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode) values('$pdid','$qty','$invoiceno','$cname','$cmobileno','$pmode')") ; 
    $query=mysqli_query($conn,"insert into orders(ProductId,Quantity,InvoiceNumber,CustomerName,CustomerContactNo,PaymentMode) values('$pdid','$qty','$invoiceno','$cname','$cmobileno','$pmode')") ; 
    }
    echo '<script>alert("Invoice genrated successfully. Invoice number is "+"'.$invoiceno.'")</script>';  
     unset($_SESSION["cart_item"]);
     $_SESSION['invoice']=$invoiceno;
     echo "<script>window.location.href='invoice.php'</script>";
    
    }
      ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Product</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
<?php include_once('include/navigation.php') 

?>
<div id="body">
    <div id="search">
        <hr>
    <h1>Search product</h1>
    <hr>
    <form  method="post">
        Product Name:<br>
        <input type="text" name="productname">
        <input type="submit" value="Search" name="submit">
    </form>
    <?php if(isset($_POST['submit'])){?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>Product Name</th>
                    <th>Manufacture Date</th>
                    <th>Expired Date</th>
                    <th>Pricing</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>   
            </thead>
            <tbody>
                <?php
                $productname=$_POST['productname'];
                $pname=strtolower($productname);
                $conn=mysqli_connect('localhost','root','','dms');
                $sql="SELECT * FROM `products` WHERE product_name LIKE '%$pname%'";
                $result=mysqli_query($conn,$sql);
                $cnt=1;
                $data=[];
                if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_array($result))
                {
                    array_unshift($data,$row);
                }
            }
                foreach($data as $d){
                     
                ?>
         <form action="search_product.php?action=add&pid=<?php echo $d["product_id"]; ?>" method="post">
             <tr>
             <td><?php echo $cnt;?></td>
             <td><?php $id=$d['company_id'];
                $sql1="select company_name from companys where company_id=$id";
                $res=mysqli_query($conn,$sql1);
                $row=mysqli_fetch_assoc($res);
                echo $row['company_name'];?></td>
             <td><?php echo $d['product_name'];?></td>
             <td><?php echo $d['mfg_date'];?></td>
             <td><?php echo $d['expired_date'];?></td>
             <td><?php echo $d['selling_price'];?></td>
             <td><input type="text" name="quantity" value="1" size="2"></td>
             <td><input type="submit" value="Add to Cart"></td>
         </tr>
     </form>     
     <?php
     $cnt++;
                }
     ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
    <div id="shopping_Cart">
        <hr>
    <h1>Shopping Cart</h1>
    <hr>
    <a  href="search_product.php?action=empty" >Empty Cart</a>
      <?php
      if(isset($_SESSION["cart_item"])){
        $total_quantity = 0;
        $total_price = 0; 
      
      ?>  
      <table>
        <thead>
        <tr>
        <th >Product Name</th>
        <th>product_id</th>
        <th>Company</th>
        <th width="5%">Quantity</th>
        <th width="10%">Unit Price</th>
        <th width="10%">Price</th>
        <th width="5%">Remove</th>
        </tr>
      </thead>  
        <?php
        $productid=array() ;
        foreach ($_SESSION["cart_item"] as $item){
            $item_price = $item["quantity"]*$item["price"];
            array_push($productid,$item['code']);
    
            ?>
            <input type="hidden" value="<?php echo $item['quantity']; ?>" name="quantity[<?php echo $item['code']; ?>]">
            <tbody>
                <tr>
                <td><?php echo $item["pname"]; ?></td>
                <td><?php echo $item["product_id"]; ?></td>
                <td><?php echo $item["company_name"]; ?></td>
                <td><?php echo $item["quantity"]; ?></td>
                <td><?php echo $item["selling-price"]; ?></td>
                <td><?php echo number_format($item_price,2); ?></td>
                <td><a href="search_product.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="image/remove.png" alt="Remove Item" /></a></td>
                </tr>
                <?php
                $total_quantity += $item["quantity"];
                $total_price += ($item["price"]*$item["quantity"]);
                }
                $_SESSION['productid']=$productid;
                ?>
                <tr>
                <td colspan="3" align="right">Total:</td>
                <td colspan="2"><?php echo $total_quantity; ?></td>
                <td colspan=><strong><?php echo number_format($total_price, 2); ?></strong></td>
                <td></td>
                </tr>
             </tbody>
    </table>
    </div>
    <div class="customer">
        <form  method="post">
          Customer Name:  <input type="text" name="name" >
          Email: <input type="text" name="email" >
          Address: <input type="text" name="address" >
          Phone: <input type="text" name="phone">
          Gender: <input type="text" name="gender">
          payment Mode: <input type="radio" name="paymentmode" value="cash" >cash
          <input type="radio" name="paymentmode" value="card">Card
          <input type="submit" value="submit" name="checkout">
        </form>
        <?p
        } else {
        ?>
        <div style="color:red" align="center">Your Cart is Empty</div>
        <?php 
        }
        ?>
    </div>
    
</div>
<?php include_once('include/footer.php')?>

</body>
</html>
<?php
}
?>