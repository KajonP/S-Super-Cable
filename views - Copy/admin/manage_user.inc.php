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
                    <div class="col-md-12">
                        <h1 class="m-0">จัดการผู้ใช้งาน</h1>

                        <!-- content -->
                        <div class="card">
                            <!-- <div class="card-header">
                                <h3 class="card-title">User Management</h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="form-group row mt-2 mb-2 mr-1">
                                <div class="col-md-12 text-right">
<!--                                    <a href="index.php?controller=Admin&action=export_pdf"-->
<!--                                       class="collapse-link text-right mt-2 mb-2 mr-2" style="color: #415468;">-->
<!--                                        <span class="btn btn-round btn-success"-->
<!--                                              style=" font-size: 13px; padding: 0 15px; margin-bottom: inherit;"><i-->
<!--                                                    class="fa fa-file"></i> ดาวน์โหลดไฟล์  </span>-->
<!--                                    </a>-->
                                    <a href="#" onclick="importShow()" class="collapse-link text-right mt-2 mb-2 mr-2"
                                       style="color: #415468;">
                                        <span class="btn btn-round btn-success"
                                              style=" font-size: 13px; padding: 0 15px; margin-bottom: inherit;"><i
                                                    class="fa fa-file"></i> อัปโหลดไฟล์ excel </span>
                                    </a>

                                    <a href="#" onclick="usermanageShow('create')"
                                       class="collapse-link text-right mt-2 mb-2 mr-2" style="color: #415468;">
                                        <span class="btn btn-round btn-success"
                                              style=" font-size: 13px; padding: 0 15px; margin-bottom: inherit;"><i
                                                    class="fa fa-plus"></i> สร้างผู้ใช้งาน </span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0 d-flex">
                                <div class="table-responsive">
                                    <table id="tbl_usermanagement" class="table table-md" style="width:100%;">
                                        <thead>
                                        <tr>
                                            <th>ไอดีพนักงาน</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>Username</th>
                                            <th>สถานะ</th>
                                            <th>การกระทำ</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($user as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $value->getID_Employee(); ?></td>
                                                <td><?php echo $value->getName_Employee() . " " . $value->getSurname_Employee(); ?></td>
                                                <td><?php echo $value->getUsername_Employee(); ?></td>
                                                <td><?php echo $value->getUser_Status_Employee(); ?></td>
                                                <td class=" last">
                                                    <a href="#"
                                                       onclick="usermanageShow('edit','<?php echo $value->getID_Employee(); ?>')">
                                                        <button type="button"
                                                                class="btn btn-round btn-warning text-center"
                                                                style=" font-size: 13px; padding: 0 15px; margin-bottom: inherit;width:96px !important;">
                                                            <i class="fa fa-wrench"></i> เเก้ไข
                                                        </button>
                                                    </a>
                                                    <a href="#"
                                                       onclick="onaction_deleteuser('<?php echo $value->getID_Employee(); ?>')">
                                                        <button type="button" class="btn btn-round btn-danger"
                                                                style=" font-size: 13px; padding: 0 15px; margin-bottom: inherit;width:96px !important;">
                                                            <i class="fa fa-trash"></i> ลบ
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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
    # modal dialog ( user manage )
    include Router::getSourcePath() . "views/modal/modal_usermanage.inc.php";
    # modal dialog ( import excel  )
    include Router::getSourcePath() . "views/modal/modal_importuser.inc.php";
    include Router::getSourcePath() . "templates/footer_page.inc.php";

    ?>


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

<script type="text/javascript" src="AdminLTE/assets/js/page/manage_user.js"></script>
