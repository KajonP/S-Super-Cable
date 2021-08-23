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

.item table {
  border-collapse: collapse;
  width: 100%;
}

.item th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}

.item td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

.item tr:nth-child(even) {
  background-color: #dddddd;
}

.header{
  text-align: center;
}



</style>
</head>
<body>
  <div style="text-align: center;"><h2>ใบเสนอราคา</h2></div>
    <table width="100%" border="0">
      <tr>
        <td width="50%">
          ลูกค่้า : <?php echo $data_sendback['Name_Company']; ?>
          <br/>
          ที่อยู่ : <?php echo $data_sendback['Address_Company']; ?>
        </td>
        <td width="50%" style="text-align:right;">
          Invoice No : <?php echo $data_sendback['Address_Company']; ?>
          <br/>
          วันที่ : <?php $date = date_create($data_sendback['Invoice_Date']) ;echo date_format($date, 'd/m/Y'); ?>
        </td>
      </tr>
    </table>
    <br/>
    <div class="item">
      <table width="100%" border="1">
        <tr>
          <th>ลำดับ</th>
          <th>รายการสินค้า</th>
          <th>ราคา</th>
          <th>จำนวน</th>
          <th>รวม</th>
        </tr>
        <?php
          if(count($data_sendback['invoice_detail'])>0){
            foreach($data_sendback['invoice_detail'] as $key => $val ){
        ?>
        <tr>
          <td><?php echo ($key+1); ?></td>
          <td><?php echo $val['Name_Goods']; ?></td>
          <td><?php echo $val['Price_Goods']; ?></td>
          <td><?php echo $val['Quantity_Goods']; ?></td>
          <td><?php echo $val['Total']; ?></td>
        </tr>
        <?php 
            }
          }
        ?>
        <tr>
          <td colspan="4" style="text-align: right;">รวม</td>
          <td><?php echo $data_sendback['Total']; ?></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: right;">ภาษี</td>
          <td><?php echo $data_sendback['Vat']; ?></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: right;">จำนวนเงินทั้งหมด</td>
          <td><?php echo $data_sendback['Grand_Total']; ?></td>
        </tr>
      </table>
    </div>
</body>
</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output("./download/inv.pdf");
//$mpdf->Output();
header('location:./download/inv.pdf');
//exit(0);
?>