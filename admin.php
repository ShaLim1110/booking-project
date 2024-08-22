<?php
require_once('db/database.php');
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create User Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
        <script src="bootstrap/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="datatables/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="datatables/css/responsive.bootstrap4.min.css">

    </head>

    <body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
            <div class="border border-3 border-primary"></div>
            <div class="card bg-white shadow-lg">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-2 text-uppercase text-success">OUT OF NOWHERE APARTELLE</h2>
                    <p class=" mb-5">Please log in your ADMIN account</p>
                    
                    <form method="post" action="php/admin_password.php">
                            <label for="admin_name">Admin: </label>
                            <input type="text" class="form-control" placeholder="apartelle@email.com" name="admin_name" >
                            <br/>
                            <label for="code">SecretCode </label>
                            <input type="password" class="form-control" placeholder="**********" name="code" >
                            <br/>
                            <div class="d-grid gap-2 d-md-block">

                            <input type="submit" class="btn btn-success btn-xs" value="LOG IN" name="submit">
                            <a class="btn btn-danger btn-xs"  href="login.php">CANCEL</a>
                            </div>
                           
                            
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</body>
</html>