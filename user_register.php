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
                            <?php
                                $rexist = isset($_SESSION['rexist']);
                                $rempty = isset($_SESSION['rempty']);
                                if($rexist){
                                    echo '
                                    <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong><i class="fa fa-xmark" aria-hidden="true"></i> ERROR! </strong>'.$_SESSION['rexist'].'</div> ';       
                                }
                                if($rempty){
                                    echo '
                                    <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong><i class="fa fa-xmark" aria-hidden="true"></i> ERROR! </strong>'.$_SESSION['rempty'].'</div> ';       
                                }
                            ?>
                    <h2 class="fw-bold mb-2 text-uppercase text-success">OUT OF NOWHERE APARTELLE</h2>
                    <p class=" mb-5">Please enter personal information</p>
                    <form method="post" action="php/save.php">
                            <label for="email">Enter Email: </label>
                            <input type="email" class="form-control" name="email" >
                            <br/>
                            <label for="firstname">Enter Firstname: </label>
                            <input type="text" class="form-control" name="firstname" >
                            <br/>
                            <label for="lastname">Enter Lastname: </label>
                            <input type="text" class="form-control" name="lastname" >
                            <br/>
                            <label for="password">Enter Password: </label>
                            <input type="password" class="form-control" name="password" >
                            <br/>

                            <input type="submit" class="btn btn-success btn-xs" value="CREATE" name="submit">
                            <a class="btn btn-danger btn-xs"  href="login.php">CANCEL</a>

                            
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