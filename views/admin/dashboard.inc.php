<?php
$title = "S Super Cable";

try {
if (!isset($_SESSION['employee']) || !is_a($_SESSION['employee'], "Employee")) {
    header("Location: " . Router::getSourcePath() . "index.php");
}
ob_start();
?>
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
    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-gradient-blue ">
            <div class="inner">
                <?php
                # find all promotion
                $promotion_count = count(Promotion::findAll());
                ?>
                <h3><?php echo isset($promotion_count) ? $promotion_count : ""; ?> </h3>
                <p>รางวัล</p>
            </div>
            <div class="icon">
                <i class="fas fa-gifts"></i>
            </div>
            <a href="index.php?controller=Promotion&action=manage_promotion" class="small-box-footer">
                เพิ่มเติม <i class="fas fa-gifts"></i>
            </a>
        </div>
    </div>

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


