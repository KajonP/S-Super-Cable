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
            </li>


            <li class="nav-item menu-open">
                <a class="nav-link active">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        จัดการ
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>
                                เสนอราคา
                            </p>
                        </a>
                    </li>
                </ul>
            </li>
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
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-gifts"></i>
                            <p>
                                ส่งเสริมการขาย
                            </p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item menu-open">
                <a class="nav-link active">
                    <i class="nav-icon fas fa-eye"></i>
                    <p>
                        เเสดงผล
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=NewsStatus&action=show_news"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-comment"></i>
                            <p>
                                ข่าวสาร
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=AwardStatus&action=show_award"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-award"></i>
                            <p>
                                รางวัล
                            </p>
                        </a>
                    </li>
                </ul>
            <li class="nav-item menu-open">
                <a class="nav-link active">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                        รายงาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                เปรียบเทียบยอดขาย
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                เปรียบเทียบรายได้
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                ประวัติลูกค้า
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                ลูกค้าที่ไม่เคลื่อนไหว
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/company.html" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                ไฟล์สเปกสินค้า
                            </p>
                        </a>
                    </li>
                </ul>
            </li>
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
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
