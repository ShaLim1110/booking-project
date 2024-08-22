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
    <nav class="navbar navbar-expand-xl navbar navbar-light" style="background-color: #e3f2fd;">
      <div class="container-fluid ">
        <a class="navbar-brand" href="reserve.php">
          <img src="img/bed.png" alt="bed" class="rounded-pill" width="40px"> 
          <span id="logoname" class="text-warning">OUT OF NOWHERE APARTELLE </span>
        </a>
        <ul class="navbar-nav">    
                  <li class="nav-item"><a class="nav-link  " href="reserve copy.php">User </a></li>
                  <li class="nav-item"><a class="nav-link" href="order.php">Tenant</a></li>
                  <li class="nav-item"><a class="nav-link " href="category.php">Location</a></li>
                  <li class="nav-item"><a class="nav-link active" href="product.php">Room</a></li>
                  <li class="nav-item"><a class="nav-link " href="walkins.php">Walk Ins</a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
         </ul>
      </div>
    </nav>   

<div class="container-fluid mt-3 text-danger">
  <div class="row">
    <div class="col-sm-12">
    <a class="btn btn-info btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#addmodal" ><i class="fa fa-add"></i> ADD NEW ROOM </a>
      
        <table class="table table-striped">
          <thead>
            <tr>
              <td>Room ID</td>
              <td>Room</td>
              <td>Price</td>
              <td>Quantity</td>
              <td>Location</td>
              <td>Edit/Delete</td>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT p.*, c.category_name FROM producttbl p 
            INNER JOIN categorytbl c ON p.category_id=c.category_id";
            $query = $connection->query($sql);
            while($row = $query->fetch_assoc()){
              $item_id = $row['item_id'];
              $item_name = $row['item_name'];
              $price = $row['price'];
              $quantity = $row['quantity'];
              $category_id = $row['category_id'];
              $category_name= $row['category_name'];

            ?>
            <tr>
                  <td><?php echo $item_id; ?></td>
                  <td><?php echo $item_name; ?></td>
                  <td><?php echo $price; ?></td>
                  <td><?php echo $quantity; ?></td>
                  <td><?php echo $category_name; ?></td>
                  <td>
                    <a class="btn btn-outline-primary btn-sm" id="btnedit" 
                      data-item_id="<?php echo $item_id;?>"  
                      data-item_name="<?php echo $item_name;?>"  
                      data-price="<?php echo $price;?>"  
                      data-quantity="<?php echo $quantity;?>"  
                      data-category_id="<?php echo $category_id;?>"  
                    href="#"><i class="fa fa-pencil" aria-hidden="true"> </i> Edit</a>
                    <a class="btn btn-outline-danger btn-sm" data-item_id="<?php echo $item_id;?>" id="btndelete" href="#"><i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>
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
  <div class="modal fade text-success" id="addmodal">
    <div class="modal-dialog dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
                <h3>ADD NEW ROOM</h3>
          </div>
          <div class="modal-body">
                <label class="form-label" for="item_name">Room:</label>
                <input type="text" class="form-control mb-2" id="item_name" />

                <label class="form-label" for="price">Price:</label>
                <input type="number" class="form-control mb-2" id="price" />

                <label class="form-label" for="qty">Quantity:</label>
                <input type="number" class="form-control mb-2" id="qty" />

                <label class="form-label" for="category">Location:</label>
                <select class="form-select mb-2" id="category">
                  <option value=""></option>
                  <?php
                    $sql = "SELECT * FROM categorytbl";
                    $query = $connection->query($sql);
                    while($row=$query->fetch_assoc()){
                      $category_id = $row['category_id'];
                      $category_name = $row['category_name'];
                  ?>
                      <option value="<?php echo $category_id?>"><?php echo $category_name;?> </option>
                  <?php
                    }
                  ?>
                </select>
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-info btn-sm" id="btnsave">CONTINUE</button>
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
                <h3>UPDATE ROOM</h3>
          </div>
          <div class="modal-body">
            <input type="hidden" id="item_id_e">
                <label class="form-label" for="item_name_e">ROOM:</label>
                <input type="text" class="form-control mb-2" id="item_name_e" />

                <label class="form-label" for="price_e">Price:</label>
                <input type="number" class="form-control mb-2" id="price_e" />

                <label class="form-label" for="qty_e">Quantity:</label>
                <input type="number" class="form-control mb-2" id="qty_e" />

                <label class="form-label" for="category_e">Location:</label>
                <select class="form-select mb-2" id="category_e">
                  <option value=""></option>
                  <?php
                    $sql = "SELECT * FROM categorytbl";
                    $query = $connection->query($sql);
                    while($row=$query->fetch_assoc()){
                      $category_id = $row['category_id'];
                      $category_name = $row['category_name'];
                  ?>
                      <option value="<?php echo $category_id?>"><?php echo $category_name;?> </option>
                  <?php
                    }
                  ?>
                </select>
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-success btn-sm" id="btnupdate">UPDATE ROOM</button>
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
    var item_id =  $('#item_id_e').val();
    var item_name =  $('#item_name_e').val();
    var price = $('#price_e').val();
    var qty =  $('#qty_e').val();
    var category =  $('#category_e').val();
    if(item_name==""){
      fieldcheck('Error','Please input the room!','error');
      return;
    }if(price==""){
      fieldcheck('Error','Please input the price!','error');
      return;
    }
    if(qty==""){
      fieldcheck('Error','Please input the quantity!','error');
      return;
    } if(category==""){
      fieldcheck('Error','Please select location!','error');
      return;
    }
    var values = {
        "item_id": item_id,
        "item_name": item_name,
        "price": price,
        "qty": qty,
        "category": category
    };
    Swal.fire({
      title: 'Are you sure you want to update this product?',
      text: "Doing this will not undo any changes",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Continue'
    }).then((result) => {
    if (result.isConfirmed) {
      updateItem(values);
    }
    });
   });

   $(document).on('click','#btnedit',function(){
    var item_id = $(this).data('item_id');
    var item_name = $(this).data('item_name');
    var price = $(this).data('price');
    var quantity = $(this).data('quantity');
    var category_id = $(this).data('category_id');

    $('#item_id_e').val(item_id);
    $('#item_name_e').val(item_name);
    $('#price_e').val(price);
    $('#qty_e').val(quantity);
    $('#category_e').val(category_id).change();
     $('#editmodal').modal('show');

   });
   $(document).on('click','#btnsave',function(){
    var item_name = $('#item_name').val();
    var price = $('#price').val();
    var qty = $('#qty').val();
    var category = $('#category').val();
    if(item_name==""){
      fieldcheck('Error','Please input room!','error');
      return;
    }if(price==""){
      fieldcheck('Error','Please input the price!','error');
      return;
    }
    if(qty==""){
      fieldcheck('Error','Please input the quantity!','error');
      return;
    } if(category==""){
      fieldcheck('Error','Please select location!','error');
      return;
    }

    var values = {
        "item_name": item_name,
        "price": price,
        "qty": qty,
        "category": category
    };
    Swal.fire({
      title: 'Adding new room?',
      text: "Please! Check the name first.",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Proceed'
    }).then((result) => {
    if (result.isConfirmed) {
      saveItem(values);
    }
    });
   });

   $(document).on('click','#btndelete',function(){
    var item_id = $(this).data('item_id');
    Swal.fire({
      title: 'Deleting room?',
      text: "Please! Check the room first.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Continue'
    }).then((result) => {
    if (result.isConfirmed) {
      deleteItem(item_id);  
    }
    });
   });

   function updateItem(values){
    $.ajax({
      type: "POST",
      url: "php/update_product.php",
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
      url: "php/save_product.php",
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

   function deleteItem(item_id){
    var values = {
      "item_id":item_id
    };
    $.ajax({
      type: "POST",
      url: "php/delete_product.php",
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