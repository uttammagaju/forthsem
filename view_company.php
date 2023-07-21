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
            $sql="SELECT company_id,company_name,posting_date,admin_id from companys ORDER BY company_id desc";
            $result=mysqli_query($conn,$sql);
            $data=[];
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    array_unshift($data,$row);
                }
            }
       ?>
       <h1>Manage Company</h1>
       <br>
       <form action="" method="post">
           <table >
               <thead>
                   <tr>
                       <th>Company Id</th>
                       <th>Company Name</th>
                       <th>Posting Date</th>
                       <th>Username</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <?php
                    foreach($data as $d){

               ?>
               <tbody>
                   <td><?php echo $d['company_id'] ; ?></td>
                   <td><?php echo $d['company_name'] ; ?></td>
                   <td><?php echo $d['posting_date'] ; ?></td>
                   <td><?php $id=$d['admin_id'];
                      $sql1="select username from admins where admin_id=$id";
                    $res=mysqli_query($conn,$sql1);
                    $row=mysqli_fetch_assoc($res);
                    echo $row['username']; ?></td>
                   <td>
                       <a href="edit_company_form.php?company_id=<?php echo $d['company_id']  ?>">Edit</a>
                       <a href="delete_company_form.php?company_id=<?php echo $d['company_id'] ?>" 
                       onclick="return confirm('are you sure want to delete')" >Delete</a>
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