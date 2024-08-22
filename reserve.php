<?php
session_start();
require_once("db/database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reservation Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link href="bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/all.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
        <script src="bootstrap/bootstrap.bundle.min.js"></script>  
        <script src="bootstrap/bootstrap.bundle.min.js"></script>  
        <!-- css datatables -->
        <link rel="stylesheet" href="datatables/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="datatables/css/responsive.bootstrap4.min.css">
    </head>

    <body>
    <nav class="navbar navbar-expand-xl navbar navbar-light" style="background-color: #e3f2fd;">
      <div class="container-fluid ">
        <a class="navbar-brand" href="reserve.php">
          <img src="img/bed.png" alt="bed" class="rounded-pill" width="40px"> 
          <span id="logoname" class="text-warning">OUT OF NOWHERE APARTELLE </span>
        </a>
        <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="reserve.php">Rooms </a></li>
                  <li class="nav-item"><a class="nav-link  " href="index.php">About Us </a></li>
                  <li class="nav-item"><a class="nav-link " href="upload.php">Upload Image </a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
                  <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
          </ul>
      </div>
    </nav>   
  
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12 ">
    <a class="btn btn-outline-success btn-sm mt-2 mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addmodal" ><i class="fa fa-bed"></i> Reserve Now! </a>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/room1.jpg" class="d-block w-100" alt="room1">
          <div class="carousel-caption d-none d-md-block bg-black">
            <h4>Price 10,000 pesos</h4>
            <h5>Deluxe Room</h5>
            <p>Good for 2 persons. Own CR and Kitchen. With own lone meter. </p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/room2.jpg" class="d-block w-100" alt="room2">
          <div class="carousel-caption d-none d-md-block bg-black">
            <h4>Price 15,000 pesos</h4>
            <h5>Single Room</h5>
            <p>Good for 2 persons. Own CR, Kitchen, and Dining. With own lone meter. </p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/room3.jpg" class="d-block w-100" alt="room3">
          <div class="carousel-caption d-none d-md-block bg-black">
            <h4>Price 20,000 pesos</h4>
            <h5>Double Room</h5>
            <p>Good for 4 persons. Own CR, Kitchen, and Dining. With own lone meter. </p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    </div>
  </div>
</div>

  <!-- add modal -->
  <div class="modal fade" id="addmodal">
    <div class="modal-dialog dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
                <h3 class="text-success">Reservation Form</h3>
          </div>
          <div class="modal-body">
                <label class="form-label text-primary" for="fullname" >Enter Your Name:</label>
                <input type="text" class="form-control mb-2" placeholder="Firstname / Lastname" id="fullname" />

                <label class="form-label text-primary" for="contact">Enter Your Contact Number:</label>
                <input type="number" class="form-control mb-2" placeholder="09123456789" id="contact" />

                <label class="form-label text-primary" for="address">Enter Your Address:</label>
                <input type="text" class="form-control mb-2" placeholder="Your Address Here" id="address" />

                <label class="form-label text-primary" for="downpayment">Enter Your Desire Downpayment:</label>
                <input type="number" class="form-control mb-2" placeholder="Desire Amount You Want To Deposite" id="downpayment" />
                
                

                <label class="form-label text-primary" for="item">Select Room:</label>
                <select class="form-select mb-2" id="item">
                  <option value=""></option>
                  <?php
                    $sql = "SELECT * FROM producttbl";
                    $query = $connection->query($sql);
                    while($row=$query->fetch_assoc()){
                      $item_id = $row['item_id'];
                      $item_name = $row['item_name'];
                  ?>
                      <option value="<?php echo $item_id?>"><?php echo $item_name;?> </option>
                  <?php
                    }

                  ?>
                </select>
           </div>
           <div class="modal-footer d-grid gap-2 d-md-block">
              <button type="button" class="btn btn-outline-success btn-lg" id="btnsave">Save Reservation</button>
              <button type="button" class="btn btn-outline-danger btn-lg" data-bs-dismiss="modal">CANCEL</button>
          </div>
      </div>
    </div>
  </div>
    </body>

<script src="js/jquery.min.js"></script>
<script src="js/sweetalert2@11.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   
   $(document).on('click','#btnsave',function(){
    var fullname = $('#fullname').val();
    var contact = $('#contact').val();
    var address = $('#address').val();
    var downpayment = $('#downpayment').val();
    var item = $('#item').val();

    if(fullname==""){
      fieldcheck('Error','Please input your name!','error');
      return;

    }if(contact==""){
      fieldcheck('Error','Please input your contact number!','error');
      return;

    }if(address==""){
      fieldcheck('Error','Please input your address!','error');
      return;

    }if(downpayment==""){
      fieldcheck('Error','Please input your downpayment!','error');
      return; 
       
    }if(item==""){
      fieldcheck('Error','Please select your desire location!','error');
      return;
    }
    var values = {
        "fullname": fullname,
        "contact": contact,
        "address": address,
        "downpayment": downpayment,
        "item": item
    };
    Swal.fire({
      title: 'Are those information correct?',
      text: "You can send your reservation fee through Gcash/Paymaya (09123456789)(Alexis Loma). Please! Screenshot your receipt for proof of transaction. Thank you!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Proceed'
    }).then((result) => {
    if (result.isConfirmed) {
      saveItem(values); 
    }
    });
   });

   function saveItem(values){
    $.ajax({
      type: "POST",
      url: "php/save_reserve_copy.php",
      data: values,
      dataType: "JSON",
      success: function(response){
        var status = response[0].status;
        var message = response[0].message;
        if(status=="success"){
          notif('Success',message,'success');
        }if(status=="error"){
          notif('Error',message,'error');
        }if(status=="exist"){
          notif('Error',message,'error');
        }
      },
    });
   }

   function notif(title,message,icon){
    Swal.fire({
      title: title,
      text: message,
      icon: icon,
    }).then((result) => {
    if (result.isConfirmed) {
      location.reload(true);
    }
    });
   }

   function fieldcheck(title,message,icon){
    Swal.fire({
      title: title,
      text: message,
      icon: icon,
    });
   }
</script>
</html>