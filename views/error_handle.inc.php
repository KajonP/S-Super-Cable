<html>
<head>
    <link rel="stylesheet" href="AdminLTE/plugins/sweetalert2/sweetalert2.min.css">
    <script src="AdminLTE/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body>
<div id="">

</div>

<script type='text/javascript'>
    Swal.fire({
        icon: 'error',
        title: 'ขออภัย ...',
        text: <?= $_GET["message"] ?>,
    }).then((result) => {
        window.history.back();
    });
</script>

</body>
</html>