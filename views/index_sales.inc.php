<?php
$title = "S Super Cable";

try {
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
                    <div class="col-sm-12">
                        <h1 class="m-0">แดชบอร์ด</h1>
                        <!-- content -->
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                  <i class="fas fa-bullhorn"></i>
                                  ข่าว
                                </h3>
                            </div>
                            <div class="card-body">
                                <?php $i = 1; foreach ($message as $key => $value) { ?>
                                <div class="callout callout-info">
                                    <h5><?php echo $value->getTittle_Message() ; ?></h5>
                                    <p><?php echo $value->getText_Message(); ?></p>
                                    <?php
                                        $date = date_create($value->getDate_Message());
                                    ?>
                                    <div>วันที่ : <?php echo date_format($date, 'd/m/Y'); ?></div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- end content -->
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
        <?php include("templates/sales/sidebar_menu.inc.php"); ?>
        <!-- /.sidebar -->
    </aside>

    <?php
    # modal dialog ( edit profile )
    include Router::getSourcePath() . "views/modal/modal_editprofile.inc.php";
    include Router::getSourcePath() . "templates/footer_page.inc.php";

    ?>


    <?php
    $content = ob_get_clean();

    include Router::getSourcePath() . "templates/layout.php";
} catch (Throwable $e) { // PHP 7++
    echo "การเข้าถึงถูกปฏิเสธ: ไม่ได้รับอนุญาตให้ดูหน้านี้";
    exit(1);
}
?>