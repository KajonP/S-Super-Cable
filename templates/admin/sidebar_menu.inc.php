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
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=Admin&action=manage_user"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                ผู้ใช้
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/zone.html" class="nav-link">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <p>
                                โซนพนักงาน
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=Company&action=manage_company"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                บริษัท
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=File&action=manage_file"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                เอกสาร
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=Goods&action=manage_goods"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                สินค้า
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=Promotion&action=manage_promotion"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-gifts"></i>
                            <p>
                                สินค้าส่งเสริมการขาย
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=News&action=manage_news"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>
                                ข่าวสาร
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=Award&action=manage_award"; ?>"
                           class="nav-link">
                            <i class=" nav-icon fas fa-award"></i>
                            <p>
                                รางวัล
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="pages/quotation.html" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>
                                ใบเสนอราคา
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=ResultSales&action=manage_sales"; ?>"
                           class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>ยอดขาย </p>
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
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=borrow&action=borrow"; ?>" class="nav-link">
                            <i class="nav-icon fas fa-gift "></i>
                            <p>
                                ส่งเสริมการขาย
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=borrow&action=borrow_approve_list"; ?>" class="nav-link">
                            <i class="nav-icon fas fa-history "></i>
                            <p>
                               การอนุมัติ
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo Router::getSourcePath() . "index.php?controller=borrow&action=borrow_approve_history"; ?>" class="nav-link">
                            <i class="nav-icon fas fa-history "></i>
                            <p>
                                ประวัติการอนุมัติ
                            </p>
                        </a>
                    </li>
                </ul>
            </li>
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
                        <a href="./index.html" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>เปอร์เซ็นของกลุ่มลูกค้า </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>ลูกค้าที่ไม่เคลื่อนไหว </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                            <p>เอกสาร </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>ยอดขายเเต่ละคน</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>เปรียบเทียบยอดขาย</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                            <i class="nav-icon fas fa-wallet "></i>
                            <p>แนวโน้มยอดขาย </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="index.php?controller=report&action=borrow" class="nav-link">
                            <i class="nav-icon fas fa-gift "></i>
                            <p>ส่งเสริมการขาย </p>
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