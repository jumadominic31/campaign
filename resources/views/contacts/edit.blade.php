@extends('layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>View Contact</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('contacts.index')}}">Contacts</a></li>
                <li class="breadcrumb-item active">View Contact</li>
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
                  <h3 class="card-title">Contact Details</h3>
                </div>
                <!-- /.card-header -->
                
                  {!!Form::open(['action' => ['ContactsController@update', $contact->id],'method' => 'POST'])!!}
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div class="card-body">
                      <div class="form-group">
                          <label>Title</label>
                          <select name="title" id="title" class="form-control select" style="width: 100%;">
                            <option selected="selected">{{$contact->title}}</option>
                            <option value="Mr">Mr</option>
                            <option value="Ms">Ms</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Dr">Dr</option>
                          </select>
                      </div>
                      <div class="form-contact">
                        <label for="name" class="col-form-label">Contact Name:</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{$contact->name}}" required>
                      </div>
                      <div class="form-contact">
                        <label for="phone" class="col-form-label">Phone:</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{$contact->phone}}" required>
                      </div>
                      <div class="form-contact">
                          <label for="email" class="col-form-label">Email:</label>
                          <input type="email" class="form-control" name="email" id="email" value="{{$contact->email}}">
                      </div>
                      <div class="form-group">
                          <label>Gender</label>
                          {{Form::select('gender', ['' => '', '1' => 'Male', '2' => 'Female', '3' => 'Other'], $contact->gender_id, ['class' => 'form-control select'])}}
                      </div>
                      <div class="form-contact">
                          <label>Opt In</label>
                          {{Form::select('opt_in', ['' => '', '1' => 'Yes', '0' => 'No'], $contact->opt_in, ['class' => 'form-control select'])}}
                      </div>
                      <div class="">
                          <label>Groups</label>
                          @foreach ($groups as $group)
                          
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$group->id}}" name="groups[]" id="{{$group->id}}" 
                              @if (in_array($group->id, $membership))
                                checked="true"
                              @endif
                            >
                            <label class="form-check-label" for="groups">
                              {{$group->name}}
                            </label>
                          </div>
                          @endforeach
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Back</a>
                      <button type="submit" class="btn btn-primary">Update Contact</button>
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