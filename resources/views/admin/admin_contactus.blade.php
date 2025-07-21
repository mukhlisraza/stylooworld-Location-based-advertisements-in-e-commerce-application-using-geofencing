@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contact Us</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Contact</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        @if (Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">

            <!-- Order Edit Model Can View and Change Their Status  -->

            <div class="modal fade" id="ordereditModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Update Status (Seen/Unseen)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Main content -->
                            <section class="content">

                                <!-- Default box -->
                                <div class="card">
                                    <form action="{{url('admin/update-contact-status')}}" method="post">
                                        @csrf
                                        <script type="text/javascript">
                                            function reply_click(clicked_id) {
                                                $("#contact").val(clicked_id);
                                            }
                                        </script>
                                        <input type="hidden" name="contact" id="contact">
                                        <div class="card-header">
                                            <select name="contact_status" class="form-control select2">
                                                <option value="" selected disabled>Updated Status</option>
                                                <option value="Seen">Seen</option>
                                                <option value="Unseen">Unseen</option>
                                            </select>
                                            <br />
                                            <br />
                                            <button type="submit" class="btn btn-warning pull-right">Update</button>
                                        </div>

                                    </form>
                            </section>
                            <!-- /.content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Messages</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="sections" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th style="width: 40%;">Message</th>
                                    <th>Status</th>
                                    <th>Received</th>
                                    <th>Seen</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allContact as $contact)
                                <tr>
                                    <td>{{$contact['id']}}</td>
                                    <td>{{$contact['name']}}</td>
                                    <td>{{$contact['email']}}</td>
                                    <td>{{$contact['subject']}}</td>
                                    <td>
                                        {{$contact['message']}}
                                    </td>
                                    <td>
                                        @if($contact['status']=='Unseen')
                                        <span class="badge badge-warning">{{$contact['status']}}</span>
                                        (<a href="#" id="{{$contact['id']}}" onClick="reply_click(this.id)" data-toggle="modal" data-target="#ordereditModel">Update</i>)
                                            @else
                                            <span class="badge badge-success">{{$contact['status']}}</span>
                                            @endif
                                    </td>
                                    <td> <span class="badge badge-dark">{{date('d-m-Y',strtotime($contact['created_at']))}}</span></td>

                                    <td>
                                        @if($contact['status']=='Seen')
                                        <span class="badge badge-success">{{date('d-m-Y',strtotime($contact['updated_at']))}}</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection