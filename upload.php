<?php
session_start();
require_once("db/database.php");
require_once("php/getdata.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Upload File page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
       
        <script src="bootstrap/bootstrap.bundle.min.js"></script>  
        <!-- css datatables -->
        <link rel="stylesheet" href="datatables/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="datatables/css/responsive.bootstrap4.min.css">

    </head>
    <body>
        
    <nav class="navbar navbar-expand-xl navbar navbar-light" style="background-color: #e3f2fd;">
      <div class="container-fluid ">
        <a class="navbar-brand" href="profile.php">
          <img src="<?php echo $user->picture<>""?$user->picture:'img/logo.png'; ?>" alt="Logo" class="rounded-pill" width="40px"> 
           <span id="logoname"> <?php echo $user->name; ?> </span>
           <input type="hidden" id="user_id" value="<?php echo $user->user_id; ?>" >
        </a>
          <ul class="navbar-nav">
                  <li class="nav-item"><a class="nav-link " href="reserve.php">Rooms </a></li>
                  <li class="nav-item"><a class="nav-link " href="index.php">About Us </a></li>
                  <li class="nav-item"><a class="nav-link active " href="upload.php">Upload Image </a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
                  <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
          </ul>
      </div>
    </nav>   

<div class="container mt-5">
  <div class="row">
    <div class="col-sm-6 offset-sm-5">

    <div class="card" style="width:200px">
      <img id="imgprev" class="img-thumbnail" src="<?php echo $user->picture<>""?$user->picture:'img/no_image.png';?>" width="200px" height="200px"/>
    </div>
    <div class="col-sm-6 mt-2">
   
    <p class="card-text">
        <label>Name:</label>
        <strong><?php echo $user->name;   ?> </strong>
        <br/>
        <label>Email:</label>
        <strong><?php echo $user->email;   ?> </strong>
        <br/>
    </p>
        <h5>Upload your File:</h3>
        <input type="file" id="file1" class="form-control mb-2"/>
        <button type="button" id="btnupload" class="btn btn-success float-end">UPLOAD <i class="fa fa-save"></i></button>
    </div>
    </div>
  </div>
</div> 
</div>

    </body>
<script src="js/jquery.min.js"></script>
<!-- DataTables -->
<script src="datatables/js/jquery.dataTables.min.js"></script>
<script src="datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="datatables/js/dataTables.responsive.min.js"></script>
<script src="datatables/js/responsive.bootstrap4.min.js"></script>
<script src="js/sweetalert2@11.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script> 
$(document).ready(function() {
    $.ajax({
        type: "POST",
        url: "php/user_getdetails.php",
        success: function(data) {
            $('#logoname').html(data);
        }
    });
});
$(document).on('click','#btnupload',function(){

    var file1 = $('#file1')[0].files[0];
    var user_id = $('#user_id').val();
    var fdata = new FormData();
    fdata.append('file1',file1);
    fdata.append('user_id',user_id);
    $.ajax({
      url: 'php/uploadfile.php',
      type: 'POST',
      data: fdata,
      contentType: false,
      cache: false,
      processData: false,
      dataType: "JSON",
      success: function (response) {
        var status = response[0].status;
        var message = response[0].message;
      
        Swal.fire({
          title: 'Are you sure you want to change your profile?',
          text: "Doing this will not undo any changes",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Proceed'
        }).then((result) => {
        if (result.isConfirmed) {
          location.reload(true);
        }
        });
      }
    });
});

$(document).on('change','#file1',function(){
    var file = $(this)[0].files[0];
    var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
   console.log('type of image:' + file.type);
    if($.inArray(file.type, validImageTypes) < 0){
            alert('Invalid image type!');
            return;
    }
    var getImgpath = window.URL.createObjectURL(file);
    console.log('path of image:' + getImgpath);
     $('#imgprev').attr('src',getImgpath);
});
</script>
</html>