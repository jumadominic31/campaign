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
                <select name="title" class="form-control select" style="width: 100%;">
                  <option selected="selected"></option>
                  <option value="Mr">Mr</option>
                  <option value="Ms">Ms</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Dr">Dr</option>
                </select>
            </div>
            <div class="form-contact">
              <label for="name" class="col-form-label">Contact Name:</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-contact">
              <label for="phone" class="col-form-label">Phone:</label>
              <input type="text" class="form-control" name="phone" required placeholder="format 254722000000">
            </div>
            <div class="form-contact">
                <label for="email" class="col-form-label">Email:</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control select" style="width: 100%;">
                    <option selected="selected"></option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                    <option value="3">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Groups</label>
                <select class="select2" name="groups[]" multiple="multiple" data-placeholder="Select Group(s) to add User" style="width: 100%;">
                  @foreach ($groups as $group)
                    <option value="{{ $group['id'] }}" 
                    @if ($group['id'] == old('groups[]'))
                      selected = 'selected'
                    @endif
                    >{{ $group['name']}}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-contact">
                <label>Opt In</label>
                <select name="opt_in" class="form-control select" style="width: 100%;">
                    <option selected="selected" value="1">Yes</option>
                    {{-- <option value="1">Yes</option> --}}
                    <option value="0">No</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="addSubmit" type="submit" class="btn btn-primary">Save Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end add contact --}}

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

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contacts</h1>
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
                <div class="row">
                  <div >
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addContactMdl" >Add Contact</button>
                  </div>
                  {!! Form::open(['action' => 'ContactsController@index', 'method'=>'POST', 'files'=>'true']) !!}
                    <div class="col-12">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" accept=".xls,.xlsx,.csv">
                            <label class="custom-file-label" for="exampleInputFile">Add multiple contacts file</label>
                          </div>
                          <div class="input-group-append">
                            <button type="submit" class="input-group-text" id="">Upload</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  {!! Form::close() !!}
                </div>
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
                      <td>{{$contact['gender']['name']}}</td>
                      <td>
                        @if ($contact['opt_in'] == '1')
                        Yes
                        @else
                        No
                        @endif
                      </td>
                      <td>
                          <a href="{{ route('contacts.edit', ['id' => $contact->id ]) }}" class="btn btn-primary">View/Edit</a>
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

  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function (){
      $('#addForm').on('submit', function(e){
        e.preventDefault();
        
        // $(this).find("button[type='submit']").prop('disabled',true);
        

        $('#addForm').validate({
          rules: {
            name: {
              required: true
            },
            phone: {
              required: true
            }
          },
          messages: {
            name: {
              required: "Please enter name"
            },
            phone: {
              required: "Please enter a phone number"
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          },

          submitHandler: function(form) {
            $("#addSubmit").prop('disabled', true); 
            $.ajax({
              type: 'POST',
              url: '/contacts/store',
              data: $('#addForm').serialize(),
              success: function(response) {
                if (response.contact){
                  console.log(JSON.stringify(response))
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
          }
        });
        
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

@endsection