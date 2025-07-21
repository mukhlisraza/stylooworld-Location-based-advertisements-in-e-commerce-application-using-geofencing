@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Subscribed User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Subscribed</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Subscribed Users</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="contacts" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>Id</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Subscribe At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getSubscriberUser as $subscribe)
                                <tr>

                                    <td>{{$subscribe['id']}}</td>
                                    <td>{{$subscribe['email']}}</td>
                                    <td>
                                        @if($subscribe['status']==1)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-warning">Deactive</span>
                                        @endif
                                    </td>
                                    <td> <span class="badge badge-success">{{date('d-m-Y',strtotime($subscribe['created_at']))}}</span></td>
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
@endsection