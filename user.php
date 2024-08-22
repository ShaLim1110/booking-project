<?php
session_start();
require_once("db/database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>User page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
        <script src="bootstrap/bootstrap.bundle.min.js"></script>  
  
    </head>
    <body>
        
    <nav class="navbar navbar-expand-xl bg-dark navbar-dark">
      <div class="container-fluid ">
        <a class="navbar-brand" href="profile.php">
          <img src="img/logo.png" alt="Logo" class="rounded-pill" width="40px"> 
           <span id="logoname"> Logo </span>
        </a>
          <ul class="navbar-nav">
                  <li class="nav-item"><a class="nav-link " href="index.php">Home </a></li>
                  <li class="nav-item"><a class="nav-link " href="profile.php">Profile </a></li>
                  <li class="nav-item"><a class="nav-link active " href="user.php">User </a></li>
                  <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                  <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>
                  <li class="nav-item"><a class="nav-link" href="product.php">Product</a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
         </ul>
      </div>
    </nav>   
<div class="container-fluid p-5 bg-primary text-white text-center ">
  <h1>User Page</h1>
  <p>Welcome to my user page</p> 
</div>
  
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12">
      <a class="btn btn-primary btn-sm" href="#"><i class="fa fa-add"></i> ADD USER </a>
        <table class="table table-striped">
          <thead>
            <tr>
              <td>user id</td>
              <td>firstname</td>
              <td>lastname</td>
              <td>email</td>
              <td>password</td>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM usertbl";
            $query = $connection->query($sql);
            while($row = $query->fetch_assoc()){
              $user_id = $row['user_id'];
              $firstname = $row['firstname'];
              $lastname = $row['lastname'];
              $email = $row['email'];
              $password = $row['password'];
            ?>
            <tr>
                  <td><?php echo $user_id; ?></td>
                  <td><?php echo $firstname; ?></td>
                  <td><?php echo $lastname; ?></td>
                  <td><?php echo $email; ?></td>
                  <td><?php echo $password; ?></td>
                  <td>
                    <a class="btn btn-primary btn-sm" 
                    href="#"><i class="fa fa-pencil" aria-hidden="true"> </i> Edit</a>
                    <a class="btn btn-danger btn-sm" onclick="return confirm('Are you you want to delete this user?')" href="#"><i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>
                  </td>
                </tr>
                <?php
                }
                ?>
          </tbody>
        </table>
    </div>
  </div>
</div>
    </body>
<script src="js/jquery.min.js"></script>
<script>
   
</script>

</html>