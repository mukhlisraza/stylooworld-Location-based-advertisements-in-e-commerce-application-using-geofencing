<?php

use App\User;

?>



@extends('layouts.admin_layout.admin_layout')
@section('content')

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Active Users</li>
                    </ol>
                </div>
                <br />
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="card col-md-11 m-auto">
                    <div class="card-header">
                        <h3 class="card-title">All Users</h3>

                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="sections" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($users as $user)

                                <?php $i++; ?>
                                <tr>
                                    <td>
                                        <span style="background-color: #fcf8e3;">{{$i}}</span>
                                    </td>

                                    <td>
                                        {{$user['mobile']}}
                                    </td>
                                    <td>
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="badge badge-primary">{{$user['type']}}</span>
                                    </td>
                                    <td>
                                        @if($user['status']==1)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Blocked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user['status']==1)
                                        <a class="updateUserStatus" id="user-{{$user['id']}}" user_id="{{$user['id']}}" title="Account Active" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden='true' status="Active"></i></a>

                                        @else
                                        <a class="updateUserStatus" id="user-{{$user['id']}}" user_id="{{$user['id']}}" title="Account Block" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden='true' status="Inactive"></i></a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a href="#" data-toggle="tooltip" class="confirmDelete" record="user" recordid="{{$user['id']}}" title="Delete Product"><i class="far fa-trash-alt text-danger"></i></a>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        <br />
    </section>
    <!-- /.content -->

</div>

<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>


@endsection