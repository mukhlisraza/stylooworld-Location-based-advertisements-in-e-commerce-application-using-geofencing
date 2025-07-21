@extends('layouts.admin_layout.admin_layout')

@section('content')



<?php



use App\Brand;

use App\Product;

use App\Section;



$brands = Brand::brands();

$product = Product::products();

$sections = Section::sections();

?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">Dashboard</h1>

        </div><!-- /.col -->

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>

            <li class="breadcrumb-item active">Dashboard</li>

          </ol>

        </div><!-- /.col -->

      </div><!-- /.row -->

    </div><!-- /.container-fluid -->

  </div>

  <!-- /.content-header -->



  <!-- Main content -->

  <section class="content">

    <div class="container-fluid">

      <!-- Small boxes (Stat box) -->

      <div class="row">

        <div class="col-lg-3 col-6">

          <!-- small box -->

          <div class="small-box bg-info">

            <div class="inner">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <h3>Brands</h3>

              <p>Manage Brands</p>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <h3>Users</h3>

              <p>View Users</p>

              @endif

            </div>

            <div class="icon">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <i class="nav-icon fab fa-creative-commons"></i>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <i class="nav-icon fas fa-user-friends"></i>

              @endif

            </div>

            @if(Auth::guard('admin')->user()->type=='vendor')

            <a href="/admin/brands" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @else

            <a href="{{url('/admin/activeuser')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @endif

          </div>

        </div>

        <!-- ./col -->

        <div class="col-lg-3 col-6">

          <!-- small box -->

          <div class="small-box bg-secondary">

            <div class="inner">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <h3>Categories<sup style="font-size: 20px"></sup></h3>

              <p>Manage Categories</p>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <h3>Sections<sup style="font-size: 20px"></sup></h3>

              <p>Manage sections</p>

              @endif

            </div>



            <div class="icon">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <i class="nav-icon fas fa-copy"></i>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <i class="nav-icon fas fa-puzzle-piece"></i>

              @endif

            </div>

            @if(Auth::guard('admin')->user()->type=='vendor')

            <a href="{{url('admin/categories')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @else

            <a href="{{url('admin/sections')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @endif

          </div>

        </div>

        <!-- ./col -->



        <div class="col-lg-3 col-6">

          <!-- small box -->

          <div class="small-box bg-success">

            <div class="inner">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <h3>Products<sup style="font-size: 20px"></sup></h3>

              <p>Manage Products</p>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <h3>Coupons<sup style="font-size: 20px"></sup></h3>

              <p>Manage Coupons</p>

              @endif

            </div>



            <div class="icon">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <i class="nav-icon fas fa-coins"></i>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <i class="nav-icon fas fa-gift"></i>

              @endif

            </div>

            @if(Auth::guard('admin')->user()->type=='vendor')

            <a href="{{url('admin/products')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @else

            <a href="{{url('admin/coupons')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @endif

          </div>

        </div>

        <!-- ./col -->





        <!-- ./col -->

        <div class="col-lg-3 col-6">

          <!-- small box -->

          <div class="small-box bg-danger">

            <div class="inner">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <h3>Orders</h3>

              <p>Manage Orders</p>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <h3>Statistics</h3>

              <p>View Statistics</p>

              @endif

            </div>

            <div class="icon">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <i class="nav-icon fas fa-shopping-basket"></i>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <i class="nav-icon fas fas fa-chart-line"></i>

              @endif

            </div>

            @if(Auth::guard('admin')->user()->type=='vendor')

            <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @else

            <a href="{{url('admin/stats')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @endif

          </div>

        </div>



        <!-- ./col -->

        <div class="col-lg-3 col-6">

          <!-- small box -->

          <div class="small-box bg-dark">

            <div class="inner">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <h3>Stock</h3>

              <p>Manage Stock</p>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <h3>Banners</h3>

              <p>Manage Banners</p>

              @endif

            </div>

            <div class="icon">

              @if(Auth::guard('admin')->user()->type=='vendor')

              <i class="nav-icon fas fas fa-chart-line"></i>

              @endif

              @if(Auth::guard('admin')->user()->type=='admin')

              <i class="nav-icon fas fas fa-images"></i>

              @endif

            </div>

            @if(Auth::guard('admin')->user()->type=='vendor')

            <a href="{{url('/admin/stock')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @else

            <a href="{{url('/admin/banner')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>

            @endif

          </div>

        </div>

       

        <!-- ./col -->

      </div>

      <!-- /.row -->

      <!-- Main row -->



      <!-- /.row (main row) -->

    </div><!-- /.container-fluid -->

  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->



@endsection