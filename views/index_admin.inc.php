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
                    <div class="col-sm-6">
                        <h1 class="m-0">แดชบอร์ด </h1>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <?php
                                        # find all employee
                                        $user_count = count(Employee::findAll());
                                        ?>
                                        <h3><?php echo isset($user_count) ? $user_count : ""; ?> </h3>
                                        <p>ผู้ใช้งาน</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <a href="index.php?controller=Admin&action=manage_user" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-user"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-gradient-success">
                                    <div class="inner">
                                        <?php
                                        # find all company
                                        $company_count = count(Company::findAll());
                                        ?>
                                        <h3><?php echo isset($company_count) ? $company_count : ""; ?> </h3>
                                        <p>บริษัท</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <a href="index.php?controller=Company&action=manage_company" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-store"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-gradient-warning">
                                    <div class="inner">
                                        <?php
                                        # find all sales
                                        $sales_count = count(Sales::findAll());
                                        ?>
                                        <h3><?php echo isset($sales_count) ? $sales_count : ""; ?> </h3>
                                        <p>ยอดขาย</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <a href="index.php?controller=ResultSales&action=manage_sales" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-wallet"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-gradient-danger ">
                                    <div class="inner">
                                        <?php
                                        # find all news
                                        $news_count = count(Message::fetchAll());
                                        ?>
                                        <h3><?php echo isset($news_count) ? $news_count : ""; ?> </h3>
                                        <p>ข่าวสาร</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <a href="index.php?controller=News&action=manage_news" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-comments"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-gradient-light ">
                                    <div class="inner">
                                        <?php
                                        # find all award
                                        $award_count = count(Award::fetchAll());
                                        ?>
                                        <h3><?php echo isset($award_count) ? $award_count : ""; ?> </h3>
                                        <p>รางวัล</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <a href="index.php?controller=Award&action=manage_award" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-award"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="">
                                <!-- small card -->
                                <div class="small-box bg-gradient-blue ">
                                    <div class="inner">
                                        <?php
                                        # find all promotion
                                        $promotion_count = count(Promotion::findAll());
                                        ?>
                                        <h3><?php echo isset($promotion_count) ? $promotion_count : ""; ?> </h3>
                                        <p>สินค้าส่งเสริมการขาย</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-gifts"></i>
                                    </div>
                                    <a href="index.php?controller=Promotion&action=manage_promotion" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-gifts"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-gradient-gray ">
                                    <div class="inner">
                                        <?php
                                        # find all goods
                                        $goods_count = count(Goods::findAll());
                                        ?>
                                        <h3><?php echo isset($goods_count) ? $goods_count : ""; ?> </h3>
                                        <p>สินค้า</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <a href="index.php?controller=Goods&action=manage_goods" class="small-box-footer">
                                        เพิ่มเติม <i class="fas fa-boxes"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
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
        <?php   include Router::getSourcePath() . "templates/admin/sidebar_menu.inc.php"; ?>
        <!-- /.sidebar -->
    </aside>

    <?php
    # modal dialog ( edit profile )
    include Router::getSourcePath() . "views/modal/modal_editprofile.inc.php";
    include Router::getSourcePath() . "templates/footer_page.inc.php";


    ?>

    </div>
    <?php
    $content = ob_get_clean();

    include Router::getSourcePath() . "templates/layout.php";
} catch (Throwable $e) { // PHP 7++
    echo "การเข้าถึงถูกปฏิเสธ: ไม่ได้รับอนุญาตให้ดูหน้านี้";
    exit(1);
}
?>
