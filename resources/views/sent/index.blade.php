@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Sent Messages</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Sent Messages</li>
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
                    <h3 class="card-title">Sent Messages</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="sentmsgtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contact</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sentmsgs as $sentmsg)
                        <tr>
                            <td>{{$sentmsg['updated_at']}}</td>
                            <td>{{$sentmsg['contact']['name']}}</td>
                            <td>{{$sentmsg['contact']['phone']}}</td>
                            <td>{{$sentmsg['message']}}</td>
                            <td>{{$sentmsg['status']}}</td>
                            <td>{{$sentmsg['cost']}}</td>
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
    <script>
        $(document).ready(function (){
            var table = $('#sentmsgtable').DataTable({
                "order": [[ 0, "desc" ]]
            } ) ;
        })
    </script>
@endsection