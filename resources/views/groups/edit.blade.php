@extends('layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>View Group</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('groups.index')}}">Groups</a></li>
                <li class="breadcrumb-item active">View Group</li>
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
                  <h3 class="card-title">Group Details</h3>
                </div>
                <!-- /.card-header -->
                {!!Form::open(['action' => ['GroupsController@update', $group->id],'method' => 'POST'])!!}
                  {{ csrf_field() }}
                  {{ method_field('PATCH') }}
                  <div class="card-body">
                      <div class="form-group">
                          <label for="name" class="col-form-label">Group Name:</label>
                          <input type="text" class="form-control" name="name" id="name" value="{{$group->name}}" required>
                      </div>
                      <div class="form-group">
                          <label for="description" class="col-form-label">Description:</label>
                          <input type="text" class="form-control" name="description" id="description" value="{{$group->description}}">
                      </div>
                    
                      <label>Group Members</label>
                        @foreach ($membership as $contact)
                          <p>{{$contact['contact']['name']}}</p>
                        @endforeach
                    
                  </div>
                  <div class="card-footer">
                    <a href="{{ route('groups.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Group</button>
                  </div>
                {!! Form::close() !!}
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

   <!-- End Content Wrapper. Contains page content -->   

@endsection