<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/all.min.css" rel="stylesheet">
        <script src="bootstrap/bootstrap.bundle.min.js"></script>  
  
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
              <p class=" mb-5">Please log in your account</p>
                  
                  <form method="post">
                  <div class="mb-3">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" placeholder="apartelle@email.com" name="email">
                  </div>
                  <div class="mb-3">
                  <label for="password">Password:</label>
                  <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                  </div>
                  <div class="d-grid gap-2 d-md-block">
                  <button id="loginbtn" type="button" class="btn btn-primary">Submit</button>
                  </div>
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a class="btn btn-info btn-xs "  href="user_register.php">USER SIGN UP</a>
                  <a class="btn btn-outline-light btn-xs "  href="admin.php">Admin</a>
                  </div>
                  </form>
        </hr/>
        <div id="status">

      </div>
      </div>
      </div>
    </div>
    </div>
  </div>
    </body>

    <script src="js/jquery.min.js"></script>
    <script src="js/sweetalert2@11.js"></script>

<script>
    //LOGIN & CHECK user
    $(document).on('click','#loginbtn',function() {
      var email = $('#email').val();
      var password = $('#password').val();
      if(email==""){
        fieldcheck('Error','Please input your email!','error');
        return;
      }
      if(password==""){
        fieldcheck('Error','Please input your password!','error');
        return;
      }
      //send data to PHP file for validation
      $.ajax ({
        type: "POST",
        url: "php/userlogin_check.php",
        data: {email: email, password: password},
        dataType: "JSON",
        success: function(response) {
            var status  = response[0].status;
            var message  = response[0].message;
            if (status=="success") {
              adminLogNotif('Success!',message,status);
            }
            if(status=="error") {
              notif('Error!',message,status);
            }
        }
      });
    });

    function adminLogNotif(title,message,icon) {
      Swal.fire({
        title: title,
        text: message,
        icon: icon,
        confirmButtonColor: '#success',
        customClass: {
          confirmButton: 'my-custom-class'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          location.href="upload.php";
        }
      });
    }

</script>

</html>