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
                        <h1 class="m-0">แนวโน้มยอดขายแบบที่ 1 คำนวณจากค่าเฉลี่ย </h1>

                        <!-- content -->
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="form-group row mt-2 mb-2 mr-1">
                                <div class="col-md-12 text-right">
                                <!-- -->
                                <form class="form-horizontal" method='get' action='' enctype="multipart/form-data">
                                        <input type="hidden" name="controller" value="Trend">
                                        <input type="hidden" name="action" value="trend">
                                       
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label" style="text-align:right;">ค้นหา</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="type">
                                                    <option value="3" <?php if(isset($_GET['type']) and $_GET['type']=='3'){ ?> selected <?php } ?>>3 เดือน</option>
                                                    <option value="6" <?php if(isset($_GET['type']) and $_GET['type']=='6'){ ?> selected <?php } ?>>6 เดือน</option>
                                                    <option value="12" <?php if(isset($_GET['type']) and $_GET['type']=='12'){ ?> selected <?php } ?>>1 ปี</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                 <button type="submit" class="btn btn-info">ค้นหา</button>
                                            </div>

                                           
                                        </div>
                                        <div class="row text-center">
                                            <div class="col col-sm-12">
                                                <?php 
                                                    $dayStart =  date('Y-m').'-01';
                                                    $dayEnd = date('Y-m-d');
                                                    $currentTotal = Sales::sumDate($dayStart,$dayEnd);
                                                    if($currentTotal['p']==''){
                                                        $currentTotal['p'] = 0;
                                                    }
                                                ?>
                                                ยอดปัจจุบันเดือน <strong> <?=$this->m(date('m'))?> : <?=$currentTotal['p']?> </strong> บาท
                                            </div>
                                        </div>
                                    </form>
                                <!-- -->
                                </div>
                            </div>
                            <div class="card-body p-0 d-flex">
                                <?php
                                if(isset($_GET['type'])){
                                ?>
                                <table class="table table-md dataTable no-footer dtr-inline" width="100%">
                                    <tr>
                                        <th width="20%" style="text-align:center;">เดือน</th>
                                        <!-- <th style="text-align:center;">ยอดขาย</th> -->
                                        <th style="text-align:center;">ทำนาย</th>
                                    </tr>
                                <?php
                                $m = number_format(date('m'));
                                $total_sum = 0;
                                $avg = '';
                                $labels = [];
                                $dataV = [];

                                array_push($dataV,  $currentTotal['p']);
                                array_push($labels,  $this->m(date('m')));

                                $expectPerMonth = $currentTotal['p']/$i;
                                for($index=0;$index<$i;$index++){

                                    array_push($dataV,   str_replace( ',', '', number_format($expectPerMonth,2)));
                                    array_push($labels,  $this->m( date('m',strtotime("+".($index+1)." month"))));

                                ?>
                
                                <tr>
                                        <td style="text-align:center;">
                                            <?php echo $this->m(date('m',strtotime("+".($index+1)." month")))." ".date('Y',strtotime("+".($index+1)." month")) ?> 
                                        </td>
                                   
                                        <td style="text-align:center;">
                                            <?=number_format($expectPerMonth,2)?>
                                        </td>
                                </tr>
            
                                <?php } ?>
                        
                                </table>
                            <?php } ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- eof -->
                        <?php
                            if(isset($_GET['type'])){
                        ?>
                        <div class="card">
                            <canvas id="myChart" width="100%"></canvas>
                        </div>
                        <?php } ?>
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
        <?php include("templates/admin/sidebar_menu.inc.php"); ?>
        <!-- /.sidebar -->
    </aside>

    <?php
    # modal dialog ( edit profile )
    include Router::getSourcePath() . "views/modal/modal_editprofile.inc.php";
    # modal dialog (zone manage )
    include Router::getSourcePath() . "templates/footer_page.inc.php";
    include Router::getSourcePath() . "views/modal/modal_zone_manage.inc.php";
    ?>

    <?php
    $content = ob_get_clean();
    // $user_jsonencode = json_encode($user);
    // echo '<PRE>';
    // print_r(ob_get_clean());exit();
    include Router::getSourcePath() . "templates/layout.php";
} catch (Throwable $e) { // PHP 7++
    print_r($e);
    echo "การเข้าถึงถูกปฏิเสธ: ไม่ได้รับอนุญาตให้ดูหน้านี้";
    exit(1);
}
?>
<script>

var ctx = document.getElementById('myChart').getContext('2d');;

const labels = <?php echo json_encode($labels); ?>;
const data = {
  labels: labels,
  datasets: [{
    label: 'ทำนาย',
    data: <?php echo json_encode($dataV); ?>,
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
};
const myChart = new Chart(ctx, {
    type: 'line',
    data: data,
});

</script>

