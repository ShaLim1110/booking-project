<?php
session_start();
require_once("db/database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Category page</title>
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
    <nav class="navbar navbar-expand-xl navbar navbar-light" style="background-color: #e3f2fd;">
      <div class="container-fluid ">
        <a class="navbar-brand" href="reserve.php">
          <img src="img/bed.png" alt="bed" class="rounded-pill" width="40px"> 
          <span id="logoname" class="text-warning">OUT OF NOWHERE APARTELLE </span>
        </a>
        <ul class="navbar-nav">    
                  <li class="nav-item"><a class="nav-link  " href="reserve copy.php">User </a></li>
                  <li class="nav-item"><a class="nav-link" href="order.php">Tenant</a></li>
                  <li class="nav-item"><a class="nav-link active" href="category.php">Location</a></li>
                  <li class="nav-item"><a class="nav-link " href="product.php">Room</a></li>
                  <li class="nav-item"><a class="nav-link " href="walkins.php">Walk Ins</a></li>
                  <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
         </ul>
      </div>
    </nav>   

<div class="container-fluid mt-3 text-danger">
  <div class="row">
    <div class="col-sm-12">
    <a class="btn btn-info btn-sm mb-3" href="#" data-bs-toggle="modal" data-bs-target="#addmodal"><i class="fa fa-add"></i> ADD NEW APARTELLE </a>
        <table id="categorytbl" class="table table-striped">
          <thead>
            <tr>
              <td>Location ID</td>
              <td>Location Name</td>
              <td>Delete</td>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM categorytbl ORDER BY category_id DESC";
            $query = $connection->query($sql);
            while($row = $query->fetch_assoc()){
              $category_id = $row['category_id'];
              $category_name = $row['category_name'];
            ?>
            <tr>
                  <td><?php echo $category_id; ?></td>
                  <td><?php echo $category_name; ?></td>
                  <td>
                    <a class="btn btn-outline-danger btn-sm" id="btndelete" data-category_id="<?php echo $category_id;?>" href="#"><i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>
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
                <h3>ADD NEW LOCATION</h3>
          </div>
          <div class="modal-body">
                <label class="form-label" for="category_name">Location</label>
                <input type="text" class="form-control" id="category_name" />
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-info btn-sm" id="btnsave">SAVE LOCATION</button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"  >CANCEL</button>

          </div>
      </div>
    </div>
  </div>

  <!-- status modal -->
  <div class="modal fade" id="statusmodal">
    <div class="modal-dialog dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
                <h3 id="title">Status</h3>
          </div>
          <div class="modal-body">
              <p id="message"></p> 
         </div>
           <div class="modal-footer">
            <button type="button" id="btncontinue" class="btn btn-danger btn-sm" data-bs-dismiss="modal"  >CONTINUE</button>
          </div>
      </div>
    </div>
  </div>

  <!-- question modal -->
  <div class="modal fade" id="questionmodal">
    <div class="modal-dialog dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
                <h3 >DELETE LOCATION</h3>
          </div>
          <div class="modal-body">
              <p>Please review the information first.</p> 
              <input type="hidden" id="category_id" >
         </div>
           <div class="modal-footer">
            <button type="button" id="btndeleteproceed" class="btn btn-danger btn-sm"   >CONTINUE</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"   >CANCEL</button>
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
<script>

  $('#categorytbl').DataTable({
    "responsive":true,
    "autoWidth":false
  });

  $(document).on('click','#btndeleteproceed',function(){
    var category_id = $("#category_id").val();
    $("#questionmodal").modal("hide");
    var values = { 
        "category_id": category_id
    };

    $.ajax({
      type:"POST",
      url:"php/delete_category.php",
      data:values,
      dataType:"JSON",
      success:function(response){
        var status = response[0].status;
        var message = response[0].message;

        if(status=="success"){
          $("#title").text("Success");

        }else{
          $("#title").text("Error");
        }
        $("#message").text(message);
        $("#statusmodal").modal("show");
      },
    }); 
  });

  $(document).on('click','#btndelete',function(){
    var category_id = $(this).data('category_id');
    $("#questionmodal").modal("show");
    $("#category_id").val(category_id);
  });

  $(document).on('click','#btncontinue',function(){
    location.reload(true);
  });

  $(document).on('click','#btnsave',function(){
    $("#addmodal").modal("hide");
    var category_name = $('#category_name').val();
    var values = {
           "category_name": category_name
    };

    $.ajax({
      type: "POST",
      url: "php/save_category.php",
      data: values,
      dataType: "JSON",
      success:function(response){
       var status = response[0].status;
       var message = response[0].message;

       if(status=="success"){
          $("#title").text("Success");  
       }else{
         $("#title").text("Error");
       }
         $("#message").text(message);
        $("#statusmodal").modal("show");

      },
    });
  });
   
</script>

</html>