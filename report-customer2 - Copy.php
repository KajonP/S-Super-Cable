<?php
//session_start();
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
    'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' =>  'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

ob_start(); // Start get HTML code
?>


<!DOCTYPE html>
<html>
<head>
<title>PDF</title>
<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
<style>
body {
    font-family: sarabun;
}
table {
  border-collapse: collapse;
  width: 100%;
}

th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.header{
  text-align: center;
}

</style>
</head>
<body>
<div>

  <h1 class="header">รายงานเปอร์เซ็นของกลุ่มลูกค้า</h1>
  <h1 class="header">วันที่ <?php 
  $date = date_create($date_start); 
  echo date_format($date, 'd/m/Y'); 
  ?> ถึง 
  <?php 
  $date = date_create($date_end); 
  echo date_format($date, 'd/m/Y'); 
  ?></h1>
<div>
<div style="text-align:center;">
  <center><img src="<?php echo $_SESSION['img']; ?>"/></center>
</div>
<br/>
<table>
  <tr>
    <th>ลำดับ</th>
    <th>กลุ่มลูกค้า</th>
    <th>คิดเป็นเปอร์เซ็น</th>
  <tr>
  <tbody>
  <?php
    $no = 0;
    foreach($cluster_name as $key => $val){
      $no++;
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $val; ?></td>
    <td><?php   
      if($totalAll>'0'){
        echo number_format(($company[$key]/$totalAll)*100,2);
      }else{
        echo '0'; 
      } ?>%</td>
  </tr>
  <?php
    }
  ?>
  </tbody>
</table>

</body>
</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output("./download/report_customer.pdf");

header('location:./download/report_customer.pdf');
exit(0);
?>