<?php
session_start();

if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
      ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
   <?php include_once('include/navigation.php')?>
   
    <div id="body">
    <div id="head">
<h1>Phaiju Dairy Farm</h1>
Changunarayan-7, Bhaktapur <br>
Phone no: 01554342
    </div>
    <table class="table mb-0" border="1">
<thead>
<tr>
<th>#</th>
<th >Product Name</th>
<th>Category</th>
<th>Company</th>
<th width="5%">Quantity</th>
<th width="10%">Unit Price</th>
<th width="10%">Price</th>

</tr>
 </thead>
<?php 
//Product Details
$result=mysqli_query($con,"select order_date,c.fullname,c.phone,p.payment_type ,od.product_id,od.quantity_order, od.price_each from customers as c
join orders o on c.customer_id = o.customer_id
join order_details od on o.order_id = od.order_id
join payments p on c.customer_id = p.customer_id
where od.orderNumber=3");
$data=[];
$cnt=1;

            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    array_unshift($data,$row);
                }
            }
            foreach($data as $d){
   
?>                                                
<tr>
<td><?php echo $cnt;?></td>
<td><?php echo $d['product_name'];?></td>
<td><?php echo $row['CategoryName'];?></td>
<td><?php echo $row['CompanyName'];?></td>
<td><?php echo $qty=$row['Quantity'];?></td>
<td><?php echo $ppu=$row['ProductPrice'];?></td>
<td><?php echo $subtotal=number_format($ppu*$qty,2);?></td>
</tr>

<?php
$grandtotal+=$subtotal; 
$cnt++;
} ?>
  <tr>
<th colspan="6" style="text-align:center; font-size:20px;">Total</th> 
<th style="text-align:left; font-size:20px;"><?php echo number_format($grandtotal,2);?></th>   

</tr>                                              
                                            </tbody>
                                        </table>

    
    </div>
    <div class="foot">
<?php include_once('include/footer.php')?>
<div>
</div>

</body>
</html>
<?php
}
?>