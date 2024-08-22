<?php
session_start();
require_once("db/database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Information Page</title>
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
                  <li class="nav-item"><a class="nav-link active " href="reserve copy.php">User </a></li>
                  <li class="nav-item"><a class="nav-link" href="order.php">Tenant</a></li>
                  <li class="nav-item"><a class="nav-link " href="category.php">Location</a></li>
                  <li class="nav-item"><a class="nav-link " href="product.php">Room</a></li>
                  <li class="nav-item"><a class="nav-link " href="walkins.php">Walk Ins</a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
         </ul>
      </div>
    </nav>   

  
<div class="container-fluid mt-5">
  <div class="row">
    <div class="col-sm-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <td>Information ID</td>
              <td>Full Name</td>
              <td>Contact</td>
              <td>Address</td>
              <td>Downpayment</td>
              <td>Room</td>
              <td>Edit/Delete</td>
            </tr>

          </thead>
          <tbody>
            <?php
            $sql = "SELECT i.*, p.item_name FROM infotbl i
            INNER JOIN producttbl p ON i.item_id=p.item_id";
            $query = $connection->query($sql);
            while($row = $query->fetch_assoc()){
              $info_id = $row['info_id'];
              $fullname = $row['fullname'];
              $contact = $row['contact'];
              $address = $row['address'];
              $downpayment = $row['downpayment'];
              $item_id = $row['item_id'];
              $item_name= $row['item_name'];

            ?>
            <tr>
                  <td><?php echo $info_id; ?></td>
                  <td><?php echo $fullname; ?></td>
                  <td><?php echo $contact; ?></td>
                  <td><?php echo $address; ?></td>
                  <td><?php echo $downpayment; ?></td>
                  <td><?php echo $item_name; ?></td>
                  <td>
                    <a class="btn btn-outline-primary btn-sm" id="btnedit" 
                      data-info_id="<?php echo $info_id;?>"  
                      data-fullname="<?php echo $fullname;?>"  
                      data-contact="<?php echo $contact;?>"  
                      data-address="<?php echo $address;?>"
                      data-downpayment="<?php echo $downpayment;?>"     
                      data-item_id="<?php echo $item_id;?>"
                    href="#"><i class="fa fa-pencil" aria-hidden="true"> </i> Edit</a>
                    <a class="btn btn-outline-danger btn-sm" data-info_id="<?php echo $info_id;?>" id="btndelete" href="#"><i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>
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

  <!-- add modal -->
  <div class="modal fade" id="addmodal">
    <div class="modal-dialog dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
                <h3>Add Product</h3>
          </div>
          <div class="modal-body">
                <label class="form-label" for="fullname">Enter Item fullnam:</label>
                <input type="text" class="form-control mb-2" id="fullname" />

                <label class="form-label" for="contact">Enter contact:</label>
                <input type="number" class="form-control mb-2" id="contact" />

                <label class="form-label" for="address">Enter Item address:</label>
                <input type="text" class="form-control mb-2" id="address" />

                <label class="form-label" for="downpayment">Enter downpayment:</label>
                <input type="number" class="form-control mb-2" id="downpayment" />
                
              

                <label class="form-label" for="item">Select Room:</label>
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
           <div class="modal-footer">
         
              <button type="button" class="btn btn-success btn-sm" id="btnsave">SAVE</button>
              <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"  >CANCEL</button>
          </div>
      </div>
    </div>
  </div>

  <!-- edit modal -->
  <div class="modal fade" id="editmodal">
    <div class="modal-dialog dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
                <h3>Update Information</h3>
          </div>
          <div class="modal-body">
            <input type="hidden" id="info_id_e">

                <label class="form-label" for="fullname_e">Update Fullname:</label>
                <input type="text" class="form-control mb-2" id="fullname_e" />

                <label class="form-label" for="contact_e">Update Contact Number:</label>
                <input type="number" class="form-control mb-2" id="contact_e" />

                <label class="form-label" for="address_e">Update Address:</label>
                <input type="text" class="form-control mb-2" id="address_e" />

                <label class="form-label" for="downpayment_e">Update Downpayment:</label>
                <input type="number" class="form-control mb-2" id="downpayment_e" />

                <label class="form-label" for="item_e">Select Location:</label>
                <select class="form-select mb-2" id="item_e">
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
           <div class="modal-footer">
              <button type="button" class="btn btn-info btn-sm" id="btnupdate">UPDATE</button>
              <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"  >CANCEL</button> 
          </div>
      </div>
    </div>
  </div>
    </body>

<script src="js/jquery.min.js"></script>
<script src="js/sweetalert2@11.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   
  
   $(document).on('click','#btnupdate',function(){
    var info_id =  $('#info_id_e').val();
    var fullname =  $('#fullname_e').val();
    var contact = $('#contact_e').val();
    var address =  $('#address_e').val();
    var downpayment =  $('#downpayment_e').val();
    var item =  $('#item_e').val();

    if(fullname==""){
      fieldcheck('Error','Please! Enter your name.','error');
      return;

    }if(contact==""){
      fieldcheck('Error','Please! Enter your contact','error');
      return;
    }
    if(address==""){
      fieldcheck('Error','Please! Enter your address','error');
      return;

    }if(downpayment==""){
      fieldcheck('Error','Please! Enter your downpayment. Put 0 if none.','error');
      return;  

    }if(item==""){
      fieldcheck('Error','Please! Enter the location','error');
      return;
    }
    var values = {
        "info_id": info_id,
        "fullname": fullname,
        "contact": contact,
        "address": address,
        "downpayment": downpayment,
        "item": item
    };

    Swal.fire({
      title: 'Review!',
      text: "Review first if you want changes. Thank You!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Update'
    }).then((result) => {
    if (result.isConfirmed) {
      updateItem(values);
    }
    });
   });

   $(document).on('click','#btnedit',function(){
    var info_id = $(this).data('info_id');
    var fullname = $(this).data('fullname');
    var contact = $(this).data('contact');
    var address = $(this).data('address');
    var downpayment = $(this).data('downpayment');
    var item_id = $(this).data('item_id');

    $('#info_id_e').val(info_id);
    $('#fullname_e').val(fullname);
    $('#contact_e').val(contact);
    $('#address_e').val(address);
    $('#downpayment_e').val(downpayment);
    $('#item_e').val(item_id).change();

     $('#editmodal').modal('show');
   });


   $(document).on('click','#btndelete',function(){
    var info_id = $(this).data('info_id');
    Swal.fire({
      title: 'Deleting Infomation',
      text: "Please! Review before deleting.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Delete'
    }).then((result) => {
    if (result.isConfirmed) {
      deleteItem(info_id);
    }
    });
   });
   
   function updateItem(values){
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

   function deleteItem(info_id){
    var values = {
      "info_id":info_id
    };
    $.ajax({
      type: "POST",
      url: "php/delete_reserve_copy.php",
      data: values,
      dataType: "JSON",
      success:function(response){
        var status = response[0].status;
        var message = response[0].message;
        if(status=="success"){
          notif('Success',message,"success");
        }if(status=="error"){
          notif('Error',message,"error");
        }if(status=="exist"){
          notif('Exist',message,"error");
        }
      }
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