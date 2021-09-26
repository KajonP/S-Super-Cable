<?php
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

  <h1 class="header">สรุปรายการเบิกของ</h1>
  <h1 class="header">วันที่ <?php $date = date_create($date_start); echo date_format($date, 'd/m/Y'); ?> ถึง <?php $date = date_create($date_end); echo date_format($date, 'd/m/Y'); ?></h1>
<div>
<table>
  <tr>
    <th>ลำดับ</th>
    <th>รายชื่อผู้เบิก</th>
    <?php
    if(count($pro_name)>0){
      foreach($pro_name as $val){
    ?>
    <th><?php echo $val['name']; ?></th>
    <?php    
      }
    }
    ?>
    <th>จำนวนเงิน</th>
  </tr>

    <?php
    if(count($emp)>0){
      $n = 0;
      foreach($emp as $index => $val){
        $n++;
        $get_emp_id =  $val->getID_Employee();
    ?>
    <tr>
      <td style="text-align:center; width:10%;"><?php echo $n; ?></td>
      <td style="text-align:center; width:15%;"><?php echo $val->getName_Employee().' '.$val->getSurname_Employee(); ?></td>
      <?php
      $total = 0;
      if(count($pro_name)>0){
        foreach($pro_name as $item){
          $pro = Promotion::findById($item['id']);
          $price = $pro->getPrice_Unit_Promotion();
          $borrow_qty = $report[$get_emp_id][$item['id']]['borrow'];
          $total = ($borrow_qty*$price)+$total;
          if($borrow_qty=='0'){
            $borrow_qty = '-';
          }
      ?>
      <td style="text-align:center;"><?php echo $borrow_qty; ?></td>
      <?php    
        }
      }
      ?>
      <td style="text-align:right; width:15%;"><?php echo $total; ?></td>
    </tr>
    <?php
      }
    }
    ?>
 
</table>

</body>
</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output("./download/report_borroworreturn.pdf");

header('location:./download/report_borroworreturn.pdf');
exit(0);
?>