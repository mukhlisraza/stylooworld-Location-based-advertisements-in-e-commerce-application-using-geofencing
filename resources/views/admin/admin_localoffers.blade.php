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
                    <h1>Local Offers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Made Offers</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="card col-md-12 m-auto">
                    <div class="card-header">
                        <h3 class="card-title">All Offers</h3>
                        <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="far fa-plus-square"></i> Add Discount</button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Made Offers</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row">
                                            <form action="#" class="col-md-12 m-auto">

                                                <label for="brands">Brand*</label>
                                                <select class="form-control" id="brands">
                                                    <option selected disabled>Please Choose</option>
                                                    <option>VELVET DRESSES</option>
                                                    <option>LINEN DRESSES</option>
                                                    <option>KHADDAR DRESSES</option>
                                                    <option>COTTON DRESSES</option>
                                                    <option>None</option>

                                                </select>
                                                <div class="row productrow">
                                                    <div class="col-6 m-auto">
                                                        <label for="category">Category*</label>
                                                        <select class="form-control" id="category">
                                                            <option selected disabled>Please Choose</option>
                                                            <option>MEN'S FASHION</option>
                                                            <option>WOMEN'S FASHION</option>
                                                            <option>BEAUTY & HEALTH</option>
                                                            <option>KIDS FASHION</option>
                                                            <option>WATCHES</option>
                                                            <option>PERFUMES</option>
                                                            <option>WALLETS</option>
                                                            <option>SHOES</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 m-auto ">
                                                        <label for="subcategory">Sub-Category</label>
                                                        <select class="form-control" id="subcategory">
                                                            <option selected disabled>Please Choose</option>
                                                            <option>CLOTING</option>
                                                            <option>T-SHIRTS</option>
                                                            <option>UNSTITCHED FABRICS</option>
                                                            <option>WINTER CLOTHING</option>
                                                            <option>PERFUMES</option>
                                                            <option>WALLETS</option>
                                                            <option>HIJABS</option>
                                                            <option>JEWELLERY</option>
                                                            <option>HANDBAGS</option>
                                                            <option>WATCHES</option>
                                                            <option>HANDBAGS</option>
                                                            <option>CLUTCHES</option>
                                                            <option>BEAUTY TOOLS</option>
                                                            <option>HAIR CARE</option>
                                                            <option>MAKEUP KITS</option>
                                                            <option>SKIN CARE</option>
                                                            <option>PERSONAL CARE</option>
                                                            <option>HEALTH CARE</option>
                                                            <option>FRAGRANCE</option>
                                                            <option>BATHING & SKINCARE</option>
                                                            <option>DISAPERING</option>
                                                            <option>BABY CLOTHING</option>
                                                            <option>SHOES</option>
                                                            <option>TOYS</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Product Name*</label>
                                                    <select class="form-control select2" style="width: 100%;">
                                                        <option selected="selected" disabled>Search..</option>
                                                        <option>CLOTING</option>
                                                        <option>T-SHIRTS</option>
                                                        <option>PERFUMES</option>
                                                        <option>WALLETS</option>
                                                        <option>WATCHES</option>
                                                        <option>JEWELLERY</option>
                                                    </select>
                                                </div>
                                                <div class="row productrow">
                                                    <div class="col-12 m-auto">
                                                        <label for="purchase">Purchase(pk)*</label>
                                                        <input type="text" class="form-control" placeholder="2,200" id="purchase" disabled>
                                                    </div>

                                                </div>
                                                <label for="purchase">Discount* %</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                        <span class="input-group-text">0.00</span>
                                                    </div>
                                                </div>

                                                <div class="row productrow">
                                                    <div class="col-6">
                                                        <label for="exampleFormControlSelect1">Publish</label>
                                                        <select class="form-control" id="exampleFormControlSelect1">
                                                            <option selected disabled>Please Choose</option>
                                                            <option>Active</option>
                                                            <option>Deactive</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="exampleFormControlSelect1">Product Type</label>
                                                        <select class="form-control" id="exampleFormControlSelect1">
                                                            <option selected disabled>Please Choose</option>
                                                            <option>Normal</option>
                                                            <option>Arrival</option>
                                                            <option>Promotion</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Submit</button>
                                    </div>
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

                                    <th>Name/Code</th>
                                    <th>Category</th>
                                    <th>Sub-Category</th>
                                    <th>Price(PK)</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Publish</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>

                                    <td>
                                        Men's Leather Band Analog Wrist Watch T802B <br />
                                        <span style="background-color: #fcf8e3;">000014151118</span>
                                    </td>
                                    <td>MEN'S FASHION</td>
                                    <td>Watches</td>
                                    <td>200</td>
                                    <td>0 %</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="publish" class="dynamic-switch custom-control-input" id="publish1" checked="checked">
                                            <label class="custom-control-label" for="publish1"></label>
                                        </div>
                                    </td>
                                    <td>

                                        <a href="#" data-toggle="tooltip" title="Delete" class="text-danger"><i class="fas fa-archive"></i></a>
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

<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>

@endsection