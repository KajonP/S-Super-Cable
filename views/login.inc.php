<?php
$title = "S Super Cable";
try {
    ob_start();

    ?>
  
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a class="h1"><b>เข้าสู่ระบบ</b></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">เข้าสู่ระบบเพื่อเริ่มเซสชัน</p>

                    <form name="loginForm" id="loginForm" method="post"
                          action=<?= Router::getSourcePath() . "index.php?controller=Employee&action=login" ?>>

                        <div class="input-group mb-3">
                            <input type="username" class="form-control" placeholder="Username" name="Username_Employee"
                                   value="<?= isset($remember_me['Username_Employee']) ? $remember_me['Username_Employee'] : ""; ?>"
                                   id="Username_Employee">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="Password_Employee"
                                   value="<?= isset($remember_me['Password_Employee']) ? $remember_me['Password_Employee'] : ""; ?>"
                                   id="Password_Employee">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="RememberMe" name="RememberMe">
                                    <label for="RememberMe">
                                        จดจำฉัน
                                    </label>
                                </div>
                            </div>

                        </div>
                        <!-- /.col -->
                        <div class="col-16">
                            <button type="submit" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
                        </div>
                        <!-- /.col -->
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->
    </div>

    <?php

    $content = ob_get_clean();

    include Router::getSourcePath() . "templates/layout.php";
} // -- try
catch (Throwable $e) {
    ob_clean(); // ล้าง output เดิมที่ค้างอยู่จากการสร้าง page
    echo "การเข้าถึงถูกปฏิเสธ: ไม่ได้รับอนุญาตให้ดูหน้านี้";
    exit(1);
}
?>
