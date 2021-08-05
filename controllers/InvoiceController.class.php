<?php


class InvoiceController
{
    /**
     * handleRequest จะทำการตรวจสอบ action และพารามิเตอร์ที่ส่งเข้ามาจาก Router
     * แล้วทำการเรียกใช้เมธอดที่เหมาะสมเพื่อประมวลผลแล้วส่งผลลัพธ์กลับ
     *
     * @param string $action ชื่อ action ที่ผู้ใช้ต้องการทำ
     * @param array $params พารามิเตอร์ที่ใช้เพื่อในการทำ action หนึ่งๆ
     */
    public function handleRequest(string $action = "index", array $params)
    {
        switch ($action) {
            case "index":
                $this->index();
                break;
            case "manage_invoice" :
                $this->$action();
                break;
            case "create_invoice" :
                $result = $this->$action($params["POST"]);
                echo $result;
                break;
            case "edit_invoice" :
                $ID_Invoice = isset($params["GET"]["ID_Invoice"]) ? $params["GET"]["ID_Invoice"] : "";
                $result = $this->$action($params["POST"], $ID_Invoice);
                echo $result;
                break;
            case "delete_invoice":
                $result = $this->$action($params["POST"]["ID_Invoice"]);
                echo $result;
                break;
            case "findbyID":
                $ID_Invoice = isset($params["POST"]["ID_Invoice"]) ? $params["POST"]["ID_Invoice"] : "";

                if (!empty($ID_Invoice)) {
                    $result = $this->$action($ID_Invoice);
                    echo $result;
                }
                break;
            default:
                break;
        }
    }
    private function create_invoice($params)
    {
        # สร้างใบเสนอราคา
        $access_invoice = new Invoice();

        $invoice_result = $access_invoice->create_invoice(
            $params
        );
        return json_encode($invoice_result);
    }
    private function edit_invoice($params, $ID_Invoice)
    {
        # อัปเดตสินค้าส่งเสริมการขาย
        $access_invoice = new Invoice();
        $invoice_result = $access_invoice->edit_invoice(
            $params, $ID_Invoice
        );
        echo json_encode($invoice_result);

    }
    private function delete_invoice($ID_Invoice)
    {
        # ลบใบเสนอราคา
        $access_invoice = new Invoice();
        $invoice_result = $access_invoice->delete_invoice(
            $ID_Invoice
        );
        return json_encode($invoice_result);
    }
    private function findbyID(string $ID_Invoice)
    {
        $invoice = Invoice::findById($ID_Invoice);//echo json_encode($sales);


        $data_sendback = array(
            "ID_Invoice" => $invoice->getID_Invoice(),
            "Invoice_No" => $invoice->getInvoice_No(),
            "Invoice_Date" => $invoice->getInvoice_Date(),
            "Credit_Term_Company" => $invoice->getCredit_Term_Company(),
            "Name_Company" => $invoice->getName_Company(),
            "Contact_Name_Company" => $invoice->getContact_Name_Company(),
            "Address_Company" => $invoice->getAddress_Company(),
            "PROVINCE_ID" => $invoice->getPROVINCE_ID(),
            "AMPHUR_ID" => $invoice->getAMPHUR_ID(),
            "Email_Company" => $invoice->getEmail_Company(),
            "Tel_Company" => $invoice->getTel_Company(),
            "Tax_Number_Company" => $invoice->getTax_Number_Company(),
            "Vat_Type" => $invoice->getVat_Type(),
            "Percent_Vat" => $invoice->getPercent_Vat(),
            "Vat" => $invoice->getVat(),
            "Discount" => $invoice->getDiscount(),
            "Total" => $invoice->getTotal(),
            "Grand_Total" => $invoice->getGrand_Total(),
            "ID_Company" => $invoice->getID_Company(),
            "ID_Setting_Vat" => $invoice->getID_Setting_Vat(),
        );
        echo json_encode(array("data" => $data_sendback));

    }
    private function error_handle(string $message)
    {
        $this->index($message);
    }

    // ควรมีสำหรับ controller ทุกตัว
    private function index($message = null)
    {
        include Router::getSourcePath() . "views/login.inc.php";

    }
    //หน้าจัดการใบเสนอราคา
    private function manage_invoice($params = null)
    {
        session_start();
        $employee = $_SESSION["employee"];

        # retrieve data
        $company = Company::findAll();
        $provinceList = Province::findAll();
        $amphurList = Amphur::findAll();
        $invoiceList = Invoice::findAll();
        $invoice_detailList = Invoice_Detail::findAll();
        $goodsList = Goods::findAll();
        if ($employee->getUser_Status_Employee() == "Admin") {
            include Router::getSourcePath() . "views/admin/manage_invoice.inc.php";
        } else if ($employee->getUser_Status_Employee() == "Sales") {
            include Router::getSourcePath() . "views/sales/manage_invoice.inc.php";
        }
    }
}