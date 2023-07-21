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
    <title>Edit Company </title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
   
   <?php include_once('include/navigation.php') ?>
    <div id="body">
       <?php
       $company_id=$company_name=$posting_date='';
       $errcompany_name=$errposting_date='';

            $company_id=$_GET['company_id'];
           //echo $company_id;
            $conn=mysqli_connect('localhost','root','','dms');
            if(isset($_POST['submit'])){
                    
                $company_name=$_POST['company_name'];
                if(empty($company_name)){
                    $errcompany_name="please enter company name";
                    }
                $company_id=$_POST['company_id'];
                $posting_date=$_POST['posting_date'];
                if(empty($posting_date)){
                    $errposting_date="please enter company name";
                    }
                    else{
                $sql="UPDATE companys set company_name='$company_name'where company_id='$company_id' ";
                mysqli_query($conn,$sql);
                if(mysqli_affected_rows($conn)==1){
                    header('location:view_company.php');
                }
                else{
                    echo "Data update failed ".mysqli_error($conn);
                }
            }
        }
            $sql1="select * from companys where company_id =$company_id";
            $res =mysqli_query($conn,$sql1);
            $data = mysqli_fetch_assoc($res);
       ?>
       <h1>Update Company</h1>
       <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="company_id" value="<?php echo $data['company_id']  ?>">
        Company Name: <input type="text" name="company_name" value="<?php echo $data['company_name']?>" ><br>
        <div id="message"><?php 
                     echo $errcompany_name;
                      ?> </div>
        Posting date: <input type="text" name="posting_date" value="<?php echo $data['posting_date']?>"><br>
        <div id="message"><?php 
                     echo $errposting_date;
                      ?> </div>
        <input type="submit" value="Update" name="submit">
        </form>
    
    </div>
</div>
<?php include_once('include/footer.php')?>

</body>
</html>
<?php
}
?>