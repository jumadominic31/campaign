@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Compose Message</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
            <li class="breadcrumb-item active">Compose</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
            <div class="card-header">
            <h3 class="card-title">Compose New Message</h3>
            </div>
            <!-- /.card-header -->
            <form id="composeForm" action="{{action('SmsController@sendmsg')}}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="card-body">
                <div class="form-group">
                  <label>Contacts</label>
                  <select id="contactsSel" class="select2" class="phone-group" name="contacts[]" multiple="multiple" data-placeholder="Select Contact(s)" style="width: 100%;">
                    <option value="">Choose...</option>
                    @foreach ($contacts as $contact)
                      <option value="{{ $contact['id'] }}" 
                      @if ($contact['id'] == old('contacts[]'))
                        selected = 'selected'
                      @endif
                      >{{ $contact['name']}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Groups</label>
                  <select id="groupsSel" class="select2" class="phone-group" name="groups[]" multiple="multiple" data-placeholder="Select Group(s)" style="width: 100%;">
                    <option value="">Choose...</option>
                    @foreach ($groups as $group)
                      <option value="{{ $group['id'] }}" 
                      @if ($group['id'] == old('groups[]'))
                        selected = 'selected'
                      @endif
                      >{{ $group['name']}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <p> To specify: title {title}, firstname {fname} or lastname {lname} </p> 
                    <textarea id="msgarea" name="msgarea" class="form-control" style="height: 100px" placeholder="Message goes here"></textarea>
                </div>
              </div>
            
              <!-- /.card-body -->
              <div class="card-footer">
              <div class="float-right">
                  <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
              </div>
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
              </div>
            </form>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </div>
  </section>

  <script>
    $(document).ready(function() {
      $('.select2').select2();
      
      
    });
</script>
<script>
    // $if ($("#composeForm").length > 0) {
        $('#composeForm').validate({
          rules: {
            "contacts[]": {
              required: '#groupsSel:blank'
            },
            "groups[]": {
              required: '#contactsSel:blank'
            },
            msgarea: {
              required: true
            }
          },
          messages: {
            msgarea: {
              required: "Please enter a message"
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
          }
        });
      // }
  </script>
  

@endsection