<?php
session_start();
require_once("db/database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Walk-In page</title>
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
        <a class="navbar-brand" href="reserve.php">
          <img src="img/bed.png" alt="bed" class="rounded-pill" width="40px"> 
          <span id="logoname" class="text-warning">OUT OF NOWHERE APARTELLE </span>
        </a>
          <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link  " href="reserve copy.php">User </a></li>
          <li class="nav-item"><a class="nav-link " href="order.php">Tenant</a></li>
          <li class="nav-item"><a class="nav-link " href="category.php">Location</a></li>
          <li class="nav-item"><a class="nav-link " href="product.php">Room</a></li>
          <li class="nav-item"><a class="nav-link active" href="walkins.php">Walk Ins</a></li>
          <li class="nav-item"><a class="nav-link" onclick="return confirm('Are you you want to logout?')" href="php/logout.php">Logout</a></li>
         </ul>
      </div>
    </nav>   

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-sm-12">
    <a id="adduserbtn" class="btn btn-info btn-sm mb-3" href="#"><i class="fa fa-add"></i> Walk In </a>
    <br/> 
        <table id="usertbl" class="table table-striped">
          <thead>
            <tr>
              <td>USER ID</td>
              <td>Name</td>
              <td>Email</td>
              <td>Password</td>
              <td>Action</td> 
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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
            <button type="button" id="btncontinue" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"  >CONTINUE</button>
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

initDataTable('#usertbl');
loadUser();

function initDataTable(tblname){
  $(tblname).DataTable({
    "responsive":true,
    "autoWidth":false
  });
}
function resetDataTable(tblname){
  $(tblname).DataTable().destroy();
}

$(document).on('click','#adduserbtn',function(){
        var html='';
         html+= '<tr>';
         html+= '<td><input id="in_user_id" type="text" class="form-control" /> </td> ';
         html+= '<td><input id="in_name" type="text" class="form-control" /></td>';
         html+= '<td><input id="in_email" type="email" class="form-control" /></td>';
         html+= '<td><input id="in_password" type="text" class="form-control" /></td>';
         html+= '<td><button id="savebtn" class="btn btn-outline-info btn-sm">SAVE</button> ';
         html+= ' <button id="cancelbtn" class="btn btn-outline-danger btn-sm">CANCEL</button></td>';
         html+= '</tr>';
        $('#usertbl tbody').append(html);
  });

  function addUser(user_id,name,email,password,row){
    var values = { 
        "user_id": user_id,
        "name": name,
        "email": email,
        "password": password
    };
    $.ajax({
      type:"POST",
      url:"php/save_user.php",
      data:values,
      dataType:"JSON",
      success:function(response){
        var status = response[0].status;
        var message = response[0].message;

        if(status=="success"){
          $("#title").text("Success");
          var html='';
          html+= '<td>'+user_id+'</td> ';
          html+= '<td>'+name+'</td>';
          html+= '<td>'+email+'</td>';
          html+= '<td>'+password+'</td>';
          html+='<td><a class="btn btn-outline-info btn-sm" href="#"';
          html+='<i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>';
          html+='<a class="btn btn-outline-danger btn-sm" id="btnuserdelete" data-user_id='+user_id+' href="#">';
          html+='<i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>';
          html+='</td>';
          row.html(html);
        }else{
          $("#title").text("Error");
        }
        $("#message").text(message);
        $("#statusmodal").modal("show");
      },
    });
  }

  $(document).on('click','#savebtn',function(){
     var row = $(this).closest('tr');
     var user_id = row.find('#in_user_id').val();
     var name = row.find('#in_name').val();
     var email = row.find('#in_email').val();
     var password = row.find('#in_password').val();
     Swal.fire({
      title: 'Are you sure you want to save this user?',
      text: "Doing this will not undo any changes",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Continue'
    }).then((result) => {
    if (result.isConfirmed) {
      addUser(user_id,name,email,password,row);
    }
    });
  });

  $(document).on('click','#updatebtn',function(){
     var row = $(this).closest('tr');
     var user_id = row.find('#in_user_id').val();
     var name = row.find('#in_name').val();
     var email = row.find('#in_email').val();
     var password = row.find('#in_password').val();
     Swal.fire({
      title: 'Are you sure you want to Update this user?',
      text: "Doing this will not undo any changes",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Continue'
    }).then((result) => {
    if (result.isConfirmed) {
      updateUser(user_id,name,email,password,row);
    }
    });
  });

  $(document).on('click','#btnuserdelete',function(){
    var row = $(this).closest('tr');
    var user_id = row.find('#td_user_id').text();
    var name = row.find('#td_name').text();
    var email = row.find('#td_email').text();
    var password = row.find('#td_password').text();
    Swal.fire({
      title: 'Are you sure you want to delete this user?',
      text: "Doing this will not undo any changes",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Continue'
    }).then((result) => {
    if (result.isConfirmed) {
       deleteUser(user_id,row); 
    }
    });
  });

  $(document).on('click','#cancelbtn',function(){
    $(this).closest('tr').remove();
  });

  $(document).on('click','#btnuseredit',function(){
    var row = $(this).closest('tr');
    var user_id = row.find('#td_user_id').text();
    var name = row.find('#td_name').text();
    var email = row.find('#td_email').text();
    var password = row.find('#td_password').text();
    var html='';
    html+= '<td><input id="in_user_id" type="text" class="form-control" value="'+user_id+'" readonly /> </td> ';
    html+= '<td><input id="in_name" type="text" class="form-control" value="'+name+'" /></td>';
    html+= '<td><input id="in_email" type="email" class="form-control" value="'+email+'" /></td>';
    html+= '<td><input id="in_password" type="text" class="form-control" value="'+password+'"   /></td>';
    html+= '<td><button id="updatebtn" class="btn btn-outline-info btn-sm">UPDATE</button> ';
    html+= ' <button id="restorebtn" class="btn btn-outline-danger btn-sm">CANCEL</button></td>';
    row.html(html);
  });

  $(document).on('click','#restorebtn',function(){
    var row = $(this).closest('tr');
    var user_id = row.find('#in_user_id').val();
    var name = row.find('#in_name').val();
    var email = row.find('#in_email').val();
    var password = row.find('#in_password').val();
    var html='';
    html+= '<td id="td_user_id" >'+user_id+'</td> ';
    html+= '<td id="td_name" >'+name+'</td>';
    html+= '<td id="td_email" >'+email+'</td>';
    html+= '<td id="td_password" >'+password+'</td>';
    html+='<td><a id="btnuseredit"  class="btn btn-outline-primary btn-sm" href="#"';
    html+='<i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>';
    html+='<a class="btn btn-outline-danger btn-sm" id="btnuserdelete" data-user_id='+user_id+' href="#">';
    html+='<i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>';
    html+='</td>';
    row.html(html);
  });


  function updateUser(user_id,name,email,password,row){
    var values = { 
        "user_id": user_id,
        "name": name,
        "email": email,
        "password": password
    };
    $.ajax({
      type:"POST",
      url:"php/update_user.php",
      data:values,
      dataType:"JSON",
      success:function(response){
        var status = response[0].status;
        var message = response[0].message;
        if(status=="success"){
          $("#title").text("Success");
          var html='';
          html+= '<td>'+user_id+'</td> ';
          html+= '<td>'+name+'</td>';
          html+= '<td>'+email+'</td>';
          html+= '<td>'+password+'</td>';
          html+='<td><a class="btn btn-outline-primary btn-sm" href="#"';
          html+='<i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>';
          html+='<a class="btn btn-danger btn-sm" id="btnuserdelete" data-user_id='+user_id+' href="#">';
          html+='<i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>';
          html+='</td>';
          row.html(html);
        }else{
          $("#title").text("Error");
        }
        $("#message").text(message);
        $("#statusmodal").modal("show");
      },
    });
  }

  $(document).on('click','#btncontinue',function(){
    location.reload(true);
  });

  function deleteUser(user_id,row){
    var values = { 
        "user_id": user_id
    };
    $.ajax({
      type:"POST",
      url:"php/delete_user.php",
      data:values,
      dataType:"JSON",
      success:function(response){
        var status = response[0].status;
        var message = response[0].message;

        if(status=="success"){
          $("#title").text("Success");
          row.remove();
        }else{
          $("#title").text("Error");
        }
        $("#message").text(message);
        $("#statusmodal").modal("show");
      },
    });
  }
     
  function loadUser(){
    resetDataTable('#usertbl');
    var values = {"id": '1'};
      $.ajax({
        type: 'GET',
        url: 'php/getusers.php',
        data: values,
        dataType:'JSON',
        success:function(response){
            var length = response.length;
            var html ='';
            for(var i=0;i<length; i++){
              var user_id = response[i].user_id;
              var name = response[i].name;
              var email = response[i].email;
              var password = response[i].password;
              html+='<tr>';
              html+='<td id="td_user_id">'+ user_id + '</td>';
              html+='<td id="td_name">'+ name+ '</td>';
              html+='<td id="td_email">'+ email+ '</td>';
              html+='<td id="td_password">'+ password+ '</td>';
              html+='<td><a id="btnuseredit" class="btn btn-outline-primary btn-sm" href="#"';
              html+='<i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>';
              html+='<a class="btn btn-outline-danger btn-sm" id="btnuserdelete" data-user_id='+user_id+' href="#">';
              html+='<i class="fa fa-trash" aria-hidden="true"> </i> Delete</a>';
              html+='</tr>';   
            }
            $('#usertbl tbody').append(html);
            initDataTable('#usertbl');
        }
    });
}
</script>

</html>