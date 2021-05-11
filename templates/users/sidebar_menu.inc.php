<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <?php include("templates/sidebar_profile.inc.php"); ?>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
                <a class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        หน้าหลัก
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="index.php?controller=Homepage&action=index" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                หน้าหลัก
                            </p>
                        </a>
                    </li>
                </ul>
            <li class="nav-item menu-open">
                <a class="nav-link active">
                    <i class="nav-icon  fas fa-gift"></i>
                    <p>
                        เบิก/คืน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/promotion.html" class="nav-link">
                            <i class="nav-icon fas fa-gift "></i>
                            <p>
                                ส่งเสริมการขาย
                            </p>
                        </a>
                    </li>
                </ul>

            <li class="nav-item menu-open">
                <a class="nav-link active">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        ออกจากระบบ
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" onclick="logout()" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>ออกจากระบบ </p>
                        </a>
                    </li>
                </ul>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->