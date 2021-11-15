<?php
session_start();
$_SESSION['img'] = $_POST['img'];
echo $_POST['img'];
?>