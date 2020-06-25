@extends('layouts.app')

@section('content')

  {{-- add group modal--}}
  <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="addGroupLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">New Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('groups.store')}}" method="POST">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="form-group">
              <label for="name" class="col-form-label">Group Name:</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
              <label for="description" class="col-form-label">Description:</label>
              <input type="text" class="form-control" name="description">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Group</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end add group --}}

  {{-- edit group modal --}}
  <div class="modal fade" id="editGroupMdl" tabindex="-1" role="dialog" aria-labelledby="editGroupLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form action="#" method="POST" id="editForm">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}
          <div class="modal-body">
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
              <label for="name" class="col-form-label">Group Name:</label>
              <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="form-group">
              <label for="description" class="col-form-label">Description:</label>
              <input type="text" class="form-control" name="description" id="description">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Group</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end edit group --}}

  {{-- delete group modal --}}
  <div class="modal fade" id="deleteGroupMdl" tabindex="-1" role="dialog" aria-labelledby="editGroupLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Delete Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form action="#" method="POST" id="deleteForm">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <div class="modal-body">
            <input type="hidden" name="_method" value="DELETE">
            <p>Are you sure?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Delete Group</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- end delete group --}}

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
              <li class="breadcrumb-item active">Groups</li>
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
                <h3 class="card-title">Add Group</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGroup" >Add Group</button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Groups</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="grouptable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($groups as $group)
                    <tr>
                      <td>{{$group['id']}}</td>
                      <td>{{$group['name']}}</td>
                      <td>{{$group['description']}}</td>
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

  {{-- edit and delete groups script --}}
  <script>
    $(document).ready(function(e){
      var table = $('#grouptable').DataTable() ;
      table.on('click', '.editBtn', function(){
          $tr = $(this).closest('tr');
          if ($($tr).hasClass('child')){
            $tr = $tr.prev('.parent');
          }
          var data = table.row($tr).data();
          console.log(data);
          
          $('#name').val(data[1]);
          $('#description').val(data[2]);
          
          $('#editForm').attr('action', '/groups/'+data[0]);
          $('#editGroupMdl').modal('show');
      });
      
      table.on('click', '.deleteBtn', function(){
          $tr = $(this).closest('tr');
          if ($($tr).hasClass('child')){
            $tr = $tr.prev('.parent');
          }
          var data = table.row($tr).data();
          console.log(data);
          
          $('#deleteForm').attr('action', '/groups/'+data[0]);
          $('#deleteGroupMdl').modal('show');
      });
    
  
    })

  </script>
  
  {{-- end edit script --}}

@endsection