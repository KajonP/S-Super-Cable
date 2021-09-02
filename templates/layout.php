<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <div id="header">
        <?php include("templates/header.inc.php"); ?>
    </div>
</head>
<body>
    <div class="wrapper" id="container">
        <div id="content">
            <?= $content ?>
        </div>
        <div id="footer">
            <?php include("templates/footer.inc.php"); ?>
        </div>
    </div>
</body>
</html>