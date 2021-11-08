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
                        <h1 class="m-0">แนวโน้มยอดขายแบบที่ 2  </h1>

                        <!-- content -->
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="form-group row mt-2 mb-2 mr-1">
                                <div class="col-md-12 text-right">


                                    
                                </div>
                            </div>
                            <div class="card-body p-0 d-flex">
                                <table border="1" width="100%">
                                    <tr>
                                        <th width="20%" style="text-align:center;">เดือน</th>
                                        <th style="text-align:center;">ยอดขาย</th>
                                        <th style="text-align:center;">ทำนาย</th>
                                    </tr>
                                <?php
                                $m = number_format(date('m'));
                                $total_sum = 0;
                                $avg = '';
                                for($i=1;$i<=12;$i++){
                                    $startDate = date('Y').'-'.str_pad($i,2,"0",STR_PAD_LEFT).'-01';
                                    $endDate = date('Y').'-'.str_pad($i,2,"0",STR_PAD_LEFT).'-31';
                                    $total = Sales::sumDate($startDate,$endDate);
                                    if($total['p']==''){
                                        $total['p'] = 0;
                                    }
                                    $total_sum = $total_sum+$total['p'];
                                    
                                    if($i>$m and $avg == ''){
                                        $avg = $total_sum/($i-1);
                                    }
                                ?>
                                    <tr>
                                        <td style="text-align:center;">
                                            <?php echo $i; ?> 
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $total['p']; ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $avg; ?>
                                        </td>
                                    </tr>
                                <?php   
                                }
                                ?>
                                </table>
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

