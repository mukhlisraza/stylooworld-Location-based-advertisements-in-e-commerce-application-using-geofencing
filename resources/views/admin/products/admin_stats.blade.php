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
                    <h1>Stats</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Stats</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Monthly Report</h5>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 m-auto">
                                    <div class="chart">
                                        <div id="piechart"></div>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-2 col-7">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-success"></span>
                                        <h5 class="description-header">{{deliveredOrder()}}</h5>
                                        <span class="description-text">TOTAL DELIVERED ORDERS</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 col-7">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-warning"></span>
                                        <h5 class="description-header">{{totalOrder()}}</h5>
                                        <span class="description-text">TOTAL RECIEVED ORDERS</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4 col-7">
                                    <div class="description-block border-right">

                                        <span class="description-percentage text-success"></span>
                                        <h5 class="description-header">{{totalReports()}}</h5>
                                        <span class="description-text">TOTAL REPORTS</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-2 col-7">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-danger"></span>
                                        <h5 class="description-header">{{totalActiveUsers()}}</h5>
                                        <span class="description-text">TOTAL ACTIVE USERS</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <div class="col-md-2 col-7">
                                    <div class="description-block">
                                        <span class="description-percentage text-warning"></span>
                                        <h5 class="description-header">{{totalReviews()}}</h5>
                                        <span class="description-text">Total Reviews</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    var orders = <?php echo json_decode(totalOrder()); ?>;
    var deliveredOrders = <?php echo json_decode(deliveredOrder()); ?>;
    var pendingOrders = <?php echo json_decode(pendingOrder()); ?>;
    var newOrders = <?php echo json_decode(newOrder()); ?>;
    var processingOrders = <?php echo json_decode(processingOrder()); ?>;
    var cancelOrders = <?php echo json_decode(cancelOrder()); ?>;
    var dispatchOrders = <?php echo json_decode(dispatchOrder()); ?>;
    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per month'],
            ['New Orders', newOrders],
            ['Pending Orders', pendingOrders],
            ['In Process Orders', processingOrders],
            ['Delivered Orders', deliveredOrders],
            ['Cancel Orders', cancelOrders],
            ['Dispatch Orders', dispatchOrders],
            ['Orders Total', orders],

        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {

            'width': 800,
            'height': 250
        };

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>

<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.37.0/formatting.js"></script>


@endsection