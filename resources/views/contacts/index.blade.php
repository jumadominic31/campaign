@extends('layouts.app')

@section('content')

  {{-- add contact modal--}}
  <div class="modal fade" id="addContactMdl" tabindex="-1" role="dialog" aria-labelledby="addContactLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">New Contact</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addForm">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="form-group">
                <label>Title</label>
                <select name="title" class="form-control select2" style="width: 100%;">
                  <option selected="selected"></option>
                  <option value="Mr">Mr</option>
                  <option value="Ms">Ms</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Dr">Dr</option>
                </select>
            </div>
            <div class="form-contact">
              <label for="name" class="col-form-label">Contact Name:</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-contact">
              <label for="phone" class="col-form-label">Phone:</label>
              <input type="text" class="form-control" name="phone">
            </div>
            <div class="form-contact">
                <label for="email" class="col-form-label">Email:</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control select2" style="width: 100%;">
                    <option selected="selected"></option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                    <option value="3">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Groups</label>
                <select class="select2" name="groups[]" multiple="multiple" data-placeholder="Select Group(s) to add User" style="width: 100%;">
                    <option value="1">Alabama</option>
                    <option value="2">Alaska</option>
                    <option value="3">California</option>
                    <option value="4">Delaware</option>
                    <option value="5">Tennessee</option>
                    <option value="6">Texas</option>
                    <option value="7">Washington</option>
                </select>
            </div>
            <div class="form-contact">
                <label>Opt In</label>
                <select name="opt_in" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="1">Yes</option>
                    {{-- <option value="1">Yes</option> --}}
                    <option value="0">No</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end add contact --}}

  {{-- edit contact modal --}}
  <div class="modal fade" id="editContactMdl" tabindex="-1" role="dialog" aria-labelledby="editContactLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Contact</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="editForm">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="modal-body">
            <div class="form-group">
                <label>Title</label>
                <select name="title" id="title" class="form-control select2" style="width: 100%;">
                  <option selected="selected"></option>
                  <option value="Mr">Mr</option>
                  <option value="Ms">Ms</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Dr">Dr</option>
                </select>
            </div>
            <div class="form-contact">
              <label for="name" class="col-form-label">Contact Name:</label>
              <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-contact">
              <label for="phone" class="col-form-label">Phone:</label>
              <input type="text" class="form-control" name="phone" id="phone">
            </div>
            <div class="form-contact">
                <label for="email" class="col-form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" id="gender" class="form-control select2" style="width: 100%;">
                    <option selected="selected"></option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                    <option value="3">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Multiple</label>
                <select class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                    <option>Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                </select>
            </div>
            <div class="form-contact">
                <label>Opt In</label>
                <select name="opt_in" id="opt_in" class="form-control select2" style="width: 100%;">
                    <option selected="selected" value="1">Yes</option>
                    {{-- <option value="1">Yes</option> --}}
                    <option value="0">No</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end edit contact --}}

  {{-- delete contact modal --}}
  <div class="modal fade" id="deleteContactMdl" tabindex="-1" role="dialog" aria-labelledby="editContactLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Contact</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form id="deleteForm">
          {{ csrf_field() }}
          <div class="modal-body">
            <input type="hidden" name="_method" value="DELETE">
            <p>Are you sure?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Delete Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end delete contact --}}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add Contact</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addContactMdl" >Add Contact</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Contacts</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="contacttable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Opt In</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                      <td>{{$contact['id']}}</td>
                      <td>{{$contact['title']}}</td>
                      <td>{{$contact['name']}}</td>
                      <td>{{$contact['phone']}}</td>
                      <td>{{$contact['email']}}</td>
                      <td>{{$contact['gender_id']}}</td>
                      <td>{{$contact['opt_in']}}</td>
                      <td>
                          <a href="#" class="btn btn-success editBtn">Edit</a>
                          <a href="#" class="btn btn-danger deleteBtn">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  {{-- edit and delete contacts script --}}
  {{-- <script>
    $(document).ready(function(e){
      var table = $('#contacttable').DataTable() ;
      table.on('click', '.editBtn', function(){
          $tr = $(this).closest('tr');
          if ($($tr).hasClass('child')){
            $tr = $tr.prev('.parent');
          }
          var data = table.row($tr).data();
          console.log(data);
          
          $('#title').val(data[1]);
          $('#name').val(data[2]);
          $('#phone').val(data[3]);
          $('#email').val(data[4]);
          $('#gender_id').val(data[5]);
          $('#opt_in').val(data[6]);
          
          $('#editForm').attr('action', '/contacts/'+data[0]);
          $('#editContactMdl').modal('show');
      });
      
      table.on('click', '.deleteBtn', function(){
          $tr = $(this).closest('tr');
          if ($($tr).hasClass('child')){
            $tr = $tr.prev('.parent');
          }
          var data = table.row($tr).data();
          console.log(data);
          
          $('#deleteForm').attr('action', '/contacts/'+data[0]);
          $('#deleteContactMdl').modal('show');
      });
    })

  </script> --}}

  <script type="text/javascript">
    $(document).ready(function (){
      $('#addForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: '/contacts/store',
          data: $('#addForm').serialize(),
          success: function(response) {
            if (response.contact){
              console.log(response)
              $('#addContactMdl').modal('hide')
              alert('Data Saved');
              location.reload();
            }
            else {
              console.log(response.error)
              alert('Error saving data');
            }
          } 
        });
      });
    });
  </script>

<script type="text/javascript">
  $(document).ready(function (){
    var table = $('#contacttable').DataTable() ;
    table.on('click', '.editBtn', function(){
    // $('.editBtn').on('click', function(){
      $('#editContactMdl').modal('show');
      
      $tr = $(this).closest('tr');
      var data = $tr.children('td').map(function(){
        return $(this).text();
      }).get();
      console.log(data);
      $('#title').val(data[1]);
      $('#name').val(data[2]);
      $('#phone').val(data[3]);
      $('#email').val(data[4]);
      $('#gender_id').val(data[5]);
      $('#opt_in').val(data[6]);

      $('#editForm').on('submit', function(e){
        e.preventDefault();
        // var id = $('#id').val();
        var id = data[0];
        $.ajax({
          type: 'PUT',
          url: '/contacts/'+id,
          dataType: 'text json',
          data: $('#editForm').serialize(),
          success: function(response) {
            // if (response.error){
            //   console.log(response.error)
            //   alert('Error saving data');
            // }
            // else {
              // console.log(JSON.stringify(response));
              console.log(response);
              $('#editContactMdl').modal('hide');
              alert('Data Updated');
              location.reload();
            // }
          },
          error: function(response) {
            console.log('Error:', response);
          }
        });
      })
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function (){
    var table = $('#contacttable').DataTable() ;
    table.on('click', '.deleteBtn', function(){
      $('#deleteContactMdl').modal('show');
      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function (){
        return $(this).text();
      }).get();
      console.log(data);
      
      // $('#deleteForm').val(data[0]);
      
      $('#deleteForm').on('submit', function(e){
        e.preventDefault();
        // var id = $('#id').val();
        var id = data[0];
        $.ajax({
          type: 'DELETE',
          url: '/contacts/'+id,
          data: $('#deleteForm').serialize(),
          success: function (response) {
            // if (response.status === 204){
              
              console.log(response);
              $('#deleteContactMdl').modal('hide');
              alert('Data Deleted');
              location.reload();
            // }
            // else {
            //   console.log(response.error)
            //   alert('Error saving data');
            // }
          } 
        });
      })
    });
  });
</script>
  
  {{-- end edit script --}}

@endsection