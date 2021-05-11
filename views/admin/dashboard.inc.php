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
        <div class="small-box ">
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
            <a href="index.php?controller=Sales&action=manage_sales" class="small-box-footer">
                เพิ่มเติม <i class="fas fa-wallet"></i>
            </a>
        </div>
    </div>

</div>


