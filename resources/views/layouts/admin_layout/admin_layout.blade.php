<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ url('plugins/select2/css/select2.min.css')}}">
  <!-- iCheck -->
  <link rel=" stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ url('plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('css/admin_css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ url('plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- favicon -->
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/ico/android-icon-192x192.png')}}">

  <style>
    form.cmxform label.error,
    label.error {
      color: red;
      font-style: italic;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <style>
      .loader {
        width: 100%;
        height: 100%;
        position: fixed;
        padding-top: 16%;
        background-color: #f1f2f3;
        padding-left: 41%;
        margin: 0 auto;
        z-index: 9999;
      }
    </style>
    <div class="loader">
      <img src="{{asset('images/loader/Ball-1s-200px.svg')}}" alt="">
    </div>
    <!-- Navbar -->
    @include('layouts.admin_layout.admin_header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.admin_layout.admin_sidebar')

    <!-- Content Wrapper. Contains page content -->
    @yield('content')

    <!-- /.content-wrapper -->

    @include('layouts.admin_layout.admin_footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
  <!-- DataTables -->
  <script src="{{ url('plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
  <script>
    $(function() {
      $("#sections").DataTable();
      $("#categories").DataTable();
      $("#products").DataTable();
      $("#orders").DataTable();
      $("#contacts").DataTable();

    });
  </script>
  <!-- ChartJS -->
  <script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ url('plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ url('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ url('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ url('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ url('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ url('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

  <script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ url('plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    //Initialize Select2 Elements
    $('.select2').select2();
  </script>
  <!-- Summernote -->
  <script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ url('js/admin_js/adminlte.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ url('js/admin_js/pages/dashboard.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ url('js/admin_js/demo.js') }}"></script>
  <!-- My custom Admin JS -->
  <script src="{{ url('js/admin_js/admin_script.js') }}"></script>
  <script src="{{ url('js/front_js/jquery.validate.js') }}" type="text/javascript"></script>
  <!-- SweetAlert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    $(function() {
      setTimeout(() => {
        $(".loader").fadeOut(600);
      }, 600);
    });
  </script>
</body>

</html>