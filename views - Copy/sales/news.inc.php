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

    <div class="content-wrapper">
        <!-- -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-12">
                    <div class="col-md-12">
                        <h1 class="m-0" >หัวข้อ : <?php  echo $message->getTittle_Message(); ?></h1></font>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- -->
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <?php
                        $date = date_create($message->getDate_Message());
                    ?>
                    วันที่ : <?php echo date_format($date, 'd/m/Y'); ?>
                    <div class="row"> 
                        <?php 
                        if(count($img)>0){ 
                            foreach($img as $img_val){
                                $img_data = Router::getSourcePath() . "images/".$img_val->getImage_name();
                        ?>
                            <div class="col-xs-6 col-md-3"><img src="<?php echo $img_data; ?>" width="100%" height="100%"></div>
                        <?php 
                            }
                        } 
                        ?>
                    </div>
                    <p> <?php echo $message->getText_Message(); ?></p>
                </div>
            </div>
        </section>
        <!-- -->
    </div>
    
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a class="brand-link">
            <img src="AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">S Super Cable</span>
        </a>
        <?php
        $user_status = $_SESSION['employee']->getUser_Status_Employee();
        if(strtolower($user_status)=='sales'){
            include("templates/sales/sidebar_menu.inc.php");
        }else if(strtolower($user_status)=='user'){
            include("templates/users/sidebar_menu.inc.php");
        }
        ?>        <!-- /.sidebar -->
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
