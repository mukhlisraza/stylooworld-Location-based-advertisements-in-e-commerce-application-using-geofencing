@extends('layouts.admin_layout.admin_layout')
@section('content')

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<link rel="stylesheet" href="{{ url('css/admin_css/product.css') }}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Sliders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Manage Sliders</li>
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

                <div class="card col-md-12 m-auto">
                    <div class="card-header">
                        <h3 class="card-title">All Slider</h3>
                        <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#addslider"> <i class="far fa-plus-square"></i> Add Slider</button>
                    </div>

                    <!-- Slider View Model -->

                    <!-- Modal -->
                    <div class="modal fade" id="addslider" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Slider</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <form action="/action_page.php" class="col-md-10 m-auto">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Select Slider</label>
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option selected disabled>Please Choose</option>
                                                    <option>Main Slider</option>
                                                    <option>Banner Slider</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="text">Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter the name of the slider">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Discription</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Right a short discription about the slider..."></textarea>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slider Edit Model Can View and Change Their Status  -->

                    <div class="modal fade" id="slidereditModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Slider</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <form action="/action_page.php" class="col-md-10 m-auto">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Select Slider</label>
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option selected disabled>Please Choose</option>
                                                    <option>Main Slider</option>
                                                    <option>Banner Slider</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="text">Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter the name of the slider">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Discription</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Right a short discription about the slider..."></textarea>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Discription</th>
                                    <th>Slides</th>
                                    <th>Publish</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>
                                        Main Slider
                                    </td>
                                    <td>

                                    </td>
                                    <td><a href="sliderslides">(3) View</a></td>

                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="publish" class="dynamic-switch custom-control-input" id="publish1" checked="checked">
                                            <label class="custom-control-label" for="publish1"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" title="Edit" data-toggle="modal" data-target="#slidereditModel"> <i class="fa fa-align-center"></i></a>
                                        <a href="#" title="Delete" class="text-danger"><i class="fas fa-archive"></i></a>
                                    </td>

                                </tr>

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


<script src="{{ url('js/admin_js/product.js') }}"></script>
<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>


@endsection