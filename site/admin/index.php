<?php
session_start();


if(isset($_SESSION['admin']))
 {
   header('location:dashboard.php');
 };

require 'db/config.php';

if(isset($_POST['submit']))
{
  

 $username=$_POST['username'];
 $password=md5($_POST['password']);
// $password=$_POST['password'];

$sql="SELECT * FROM auth WHERE username='$username' AND password='$password'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
    
if(mysqli_num_rows($result)==1)
{
    $_SESSION['admin']=$row;
    header('location:dashboard.php');
}
$stmt = $conn->prepare('SELECT * FROM auth WHERE username = ? AND password = ?');
$stmt->bind_param('ss', $username, $password); 
$stmt->execute();
$result = $stmt->get_result();  
$row=mysqli_fetch_assoc($result);
   if(mysqli_num_rows($result)==1)
{
    $_SESSION['admin']=$row;
    header('location:dashboard.php');

}
  


else
{

echo "<script language='javascript'>alert('login failed,try again')</script>";
}




};

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <link rel="icon" href="favicon.ico">

    <title>HERMAS | Admin</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST">
              <h1> Admin Login</h1>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>

                <button type="submit" class="btn btn-default submit" name="submit">Log In</button> 
               
              </div>

              <div class="clearfix"></div>

              <div class="separator">
              

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>HERMAS</h1>
                  <p>©2018 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      
      </div>
    </div>
  </body>
</html>
