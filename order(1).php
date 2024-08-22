<?php
session_start();
require_once("db/database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Room page</title>
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
                  <li class="nav-item"><a class="nav-link  " href="reserve copy.php">User </a></li>
                  <li class="nav-item"><a class="nav-link active" href="order.php">Tenant</a></li>
                  <li class="nav-item"><a class="nav-link " href="category.php">Location</a></li>
                  <li class="nav-item"><a class="nav-link " href="product.php">Room</a></li>
                  <li class="nav-item"><a class="nav-link " href="walkins.php">Walk Ins</a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
         </ul>
      </div>
    </nav>   

<div class="container-fluid text-danger">
  <div class="row">
    <div class="col-sm-12">
      <br/>
    <a class="btn btn-info btn-sm mb-3" href="#" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-add"></i> ADD NEW TENANT </a>
      
        <table id="ordertbl" class="table table-striped">
          <thead>
            <tr>
              <td>Tenant ID</td>
              <td>Room</td>
              <td>Name</td>
              <td>Quantity</td>
              <td>Payment</td>
              <td>Edit/Delete</td>
            </tr>

          </thead>
          <tbody>
            <?php
            $sql = "SELECT o.*, p.item_name, u.firstname, u.lastname FROM ordertbl o 
              INNER JOIN producttbl p ON  o.item_id=p.item_id 
              INNER JOIN usertbl u ON o.user_id=u.user_id ";
            $query = $connection->query($sql);
            while($row = $query->fetch_assoc()){
              $order_id = $row['order_id'];
              $item_id = $row['item_id'];
              $user_id = $row['user_id'];
              $quantity = $row['quantity'];
              $total = $row['total'];
              $item_name = $row['item_name'];
              $lastname = $row['lastname'];
              $firstname = $row['firstname'];
              
            ?>
            <tr>
                  <td><?php echo $order_id; ?></td>
                  <td><?php echo $item_name; ?></td>
                  <td><?php echo $firstname. " ".$lastname; ?></td>
                  <td><?php echo $quantity; ?></td>
                  <td><?php echo $total; ?></td>
                  
                  <td>
                    <a id="editbtn" class="btn btn-outline-primary btn-sm" 
                    data-order_id="<?php echo $order_id; ?>" 
                    data-item_id="<?php echo $item_id; ?>" 
                    data-user_id="<?php echo $user_id; ?>" 
                    data-quantity="<?php echo $quantity; ?>" 
                    data-total="<?php echo $total; ?>" 
                    href="#"><i class="fa fa-pencil" aria-hidden="true"> </i> Edit</a>
                    <a class="btn btn-outline-danger btn-sm" data-order_id="<?php echo $order_id ?>" id="deletebtn"  href="#" ><i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>
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

<!-- modal add -->
<div class="modal fade text-success " id="addModal">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
            <h2 > ADD NEW TENANT </h2>
      </div>
      <div class="modal-body">
                      <label class="form-label text" for="item">Select Room:</label>
                      <select class="form-select mb-2" id="item">
                       <option value=""></option>
                            <?php
                            $sql ="SELECT * FROM producttbl";
                            $query = $connection->query($sql);
                            while($row=$query->fetch_assoc()){
                                $item_id = $row['item_id'];
                                $item_name = $row['item_name'];
                                $price = $row['price'];
                            ?>
                                <option value="<?php echo $item_id; ?>" data-price="<?php echo $price;?>"  ><?php echo $item_name; ?></option>
                            <?php
                            }
                            ?>
                       </select>
                        <br/>
                        <label class="form-label text" for="user">Select Tenant:</label>
                        <select class="form-select mb-2" id="user">
                            <option value=""></option>
                            <?php
                            $sql ="SELECT * FROM usertbl";
                            $query = $connection->query($sql);
                            while($row=$query->fetch_assoc()){
                                $user_id = $row['user_id'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                            ?>
                                <option value="<?php echo $user_id; ?>" ><?php echo $firstname." ".$lastname; ?></option>
                            <?php
                            }
                            ?>
                       </select>
                       <br/>
                       <label for="price">Price: </label>
                       <input type="text" class="form-control" name="price" id="price" readonly>
                       <br/>
                       <label for="quantity">Quantity: </label>
                       <input type="number" class="form-control" name="quantity" id="quantity" required>
                       <br/>
                       <label for="total">Payment: </label>
                       <input type="text" class="form-control" name="total" id="total" readonly>
                       <br/>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-outline-success btn-lg" id="btnsave">Save Tenant</button>
             <button type="button"class="btn btn-danger" data-bs-dismiss="modal">CANCEL </button>
      </div>
      </form>
    </div>
  </div>


</div>
<!-- modal edit -->
<div class="modal fade text-success" id="editModal">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
    <form method="post" action="php/update_order.php">
      <div class="modal-header">
            <h2> Edit Room </h2>
      </div>
      <div class="modal-body">
        <label for="item">Select Room: </label>
                          <input type="hidden" name="order_id_edit" id="order_id_edit" />
                       <select name="item" id="item" class="form-select" required>
                       <option value=""></option>
                            <?php
                            $sql ="SELECT * FROM producttbl";
                            $query = $connection->query($sql);
                            while($row=$query->fetch_assoc()){
                                $item_id = $row['item_id'];
                                $item_name = $row['item_name'];
                            ?>
                                <option value="<?php echo $item_id; ?>"  ><?php echo $item_name; ?></option>
                            <?php
                            }
                            ?>
                       </select>
                        <br/>
                        <label for="user">Select Tenant: </label>
                       <select name="user"  id="user"  class="form-select" required>
                            <option value=""></option>
                            <?php
                            $sql ="SELECT * FROM usertbl";
                            $query = $connection->query($sql);
                            while($row=$query->fetch_assoc()){
                                $user_id = $row['user_id'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                            ?>
                                <option value="<?php echo $user_id; ?>" ><?php echo $firstname." ".$lastname; ?></option>
                            <?php
                            }
                            ?>
                       </select>
                       <br/>
                       
                       <label for="quantity_edit">Quantity: </label>
                       <input type="text" class="form-control" id="quantity_edit" name="quantity_edit" required>
                       <br/>
                       <label for="total">Balance: </label>
                       <input type="text" class="form-control" id="total_edit"  name="total_edit" required>
                       <br/>

      </div>
      <div class="modal-footer">
             <input type="submit" class="btn btn-info" value="UPDATE TENANT" >
             <button type="button"class="btn btn-danger" data-bs-dismiss="modal">CANCEL </button>
      </div>
      </form>
    </div>
  </div>


</div>
<!-- modal delete -->
<div class="modal fade" id="deleteModal">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <form method="post" action="php/delete_order1.php">
      <div class="modal-header">
            <h3 > DELETE INFORMATION </h3>
      </div>
      <div class="modal-body">
        <input type="hidden" name="order_id" id="order_id" />
        <strong>Please review the information first. </strong>
        <p>Check if the information is correct</p>
      </div>
      <div class="modal-footer">
             <button type="button" class="btn btn-info" id="btnproceeddelete"> DELETE </button>
             <a href="#" class="btn btn-danger" data-bs-dismiss="modal" >CANCEL </a>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- modal logout -->
<div class="modal fade" id="logoutModal">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
            <h3 > Question </h3>
      </div>
      <div class="modal-body">
        <strong>Are you sure you want to logout? </strong>
        <p>Doing this will exit you in the website</p>
      </div>
      <div class="modal-footer">
             <a href="php/logout.php" class="btn btn-primary" >CONTINUE </a>
             <a href="#" class="btn btn-danger" data-bs-dismiss="modal" >CANCEL </a>     
      </div>
    </div>
  </div>

</div>
<!-- modal success -->
<div class="modal fade" id="successModal">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
     
      <div class="modal-header">
            <h3 > Confirmation </h3>
      </div>
      <div class="modal-body">
        <strong>You successfully deleted an order! </strong>
      </div>
      <div class="modal-footer">
              <a href="#" id="btnCont" class="btn btn-success" data-bs-dismiss="modal" >CONTINUE </a>   
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
     //datatable
$("#ordertbl").DataTable({
"responsive": true,
"autoWidth": false,
});


  $(document).on('click','#btnproceeddelete',function(){
    var order_id = $('#order_id').val();
  //  alert(order_id);
    var data = { "order_id": order_id};

    $.ajax({
      type: "POST",
      url: "php/delete_order1.php",
      data: data,
      dataType: "JSON",
      success:function(response){
        var status = response[0].status;
        
        $("#successModal").modal("show");
      
      },
    });
    
  });
  $(document).on('click','#btnCont',function(){
    location.reload(true);

  });
  $(document).on('click','#deletebtn',function(){
    $("#deleteModal").modal("show");
    var order_id = $(this).data("order_id");
    $("#order_id").val(order_id);
 // alert('order_id: '+order_id);
 

  });

  $(document).on('change','#item',function(){
      var price = $(this).find(':selected').data("price");
      $('#price').val(price);
      $('#total').val(0);
      $('#quantity').val(0);

  });

  $(document).on('keyup','#quantity',function(){
      var quantity = $(this).val();
      var price = $('#price').val();
      var total = quantity * price;
      $('#total').val(total);
  });

  $(document).on('click','#btnupdate',function(){
    var item =  $('#item').val();
    var user =  $('#user').val();
    var quantity = $('#quantity_edit').val();
    var total =  $('#total_edit').val();

    if(item==""){
      fieldcheck('Error','Please! Enter room.','error');
      return;

    }if(user==""){
      fieldcheck('Error','Please! Enter name','error');
      return;
    }
    if(quantity==""){
      fieldcheck('Error','Please! Enter quantity','error');
      return;

    }if(total==""){
      fieldcheck('Error','Please! Enter your payment. Put 0 if none.','error');
      return;  

    } 
    var values = {
        "item": item,
        "user": user,
        "quantity": quantity,
        "total": total
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
  $(document).on('click','#editbtn',function(){
    $("#editModal").modal("show");
    var order_id = $(this).data("order_id");
    var user_id = $(this).data("user_id");
    var item_id = $(this).data("item_id");
    var quantity = $(this).data("quantity");
    var total = $(this).data("total");
    $("#users").val(user_id).change();
    $("#item").val(item_id).change();
    $("#order_id_edit").val(order_id);
    $("#quantity_edit").val(quantity);
    $("#total_edit").val(total);

  });
  $(document).on('click','#btnsave',function(){
    var item =  $('#item').val();
    var user =  $('#user').val();
    var quantity = $('#quantity').val();
    var total =  $('#total').val();

    if(item==""){
      fieldcheck('Error','Please! Enter room.','error');
      return;

    }if(user==""){
      fieldcheck('Error','Please! Enter name','error');
      return;
    }
    if(quantity==""){
      fieldcheck('Error','Please! Enter quantity','error');
      return;

    }if(total==""){
      fieldcheck('Error','Please! Enter your payment. Put 0 if none.','error');
      return;  

    } 
    var values = {
        "item": item,
        "user": user,
        "quantity": quantity,
        "total": total
    };
    Swal.fire({
      title: 'Are those information correct?',
      text: "If yes please click 'Proceed'",
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
      url: "php/save_order.php",
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