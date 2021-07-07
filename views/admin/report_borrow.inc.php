<?php
try {
    $title = "S Super Cable";
    if (!isset($_SESSION['employee']) || !is_a($_SESSION['employee'], "Employee")) {
        header("Location: " . Router::getSourcePath() . "index.php");
    }
    ob_start();
    ?>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
        </ul>
    </nav>
    <!-- /.navbar -->

    <div class=" content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h1 class="m-0">รายงาน</h1>

                        <!-- content -->
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <form class="form-horizontal" method='get' action='' enctype="multipart/form-data">
                                        <input type="hidden" name="controller" value="report">
                                        <input type="hidden" name="action" value="borrow">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">วันที่เริ่ม</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="date_start" class="form-control" value="<?php echo $date_start ?>" data-date-format='yyyy-mm-dd' >
                                            </div>
                                            <label for="" class="col-sm-2 col-form-label">วันที่สิ้นสุด</label>
                                            <div class="col-sm-3">
                                                <input type="text"  name="date_end" class="form-control" value="<?php echo $date_end ?>">
                                            </div>
                                            <div class="col-sm-2">
                                                 <button type="submit" class="btn btn-info">ค้นหา</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <canvas id="myChart" width="100%"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- eof -->
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a class="brand-link">
            <img src="AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">S Super Cable</span>
        </a>
        <!-- Sidebar -->
        <?php
        $user_status = $_SESSION['employee']->getUser_Status_Employee();
        if(strtolower($user_status)=='sales'){
            include("templates/sales/sidebar_menu.inc.php");
        }else if(strtolower($user_status)=='admin'){
            include("templates/admin/sidebar_menu.inc.php");
        }else if(strtolower($user_status)=='user'){
            include("templates/users/sidebar_menu.inc.php");
        }
        ?>
        <!-- /.sidebar -->
    </aside>

    <?php
    include Router::getSourcePath() . "views/modal/modal_borrow.inc.php";
    ?>


    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0-rc
        </div>
    </footer>
    </div>
    <?php
    $content = ob_get_clean();
    // $user_jsonencode = json_encode($user);
    // echo '<PRE>';
    // print_r(ob_get_clean());exit();
    include Router::getSourcePath() . "templates/layout.php";
} catch (Throwable $e) { // PHP 7++
    echo "การเข้าถึงถูกปฏิเสธ: ไม่ได้รับอนุญาตให้ดูหน้านี้";
    exit(1);
}
?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="AdminLTE/assets/js/page/report_borrow.js"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var data = {
    labels: <?php echo $promotion_array; ?>,
    datasets: [
        {
            label: "ยืม",
            backgroundColor: "blue",
            data: <?php echo $borrow_array; ?>
        },
        {
            label: "คืน",
            backgroundColor: "red",
            data: <?php echo $borrow_return_array; ?>
        },
    ]
};
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

$('input[name="date_start"]').datepicker({
    format: 'yyyy-mm-dd'
});

$('input[name="date_end"]').datepicker({
    format: 'yyyy-mm-dd'
});
</script>

