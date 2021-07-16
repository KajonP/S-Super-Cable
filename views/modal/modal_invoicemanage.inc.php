<div class="modal fade" id="invoicemanageModal" tabindex="-1" role="dialog" aria-labelledby="invoicemanageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoicemanageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>บริษัทลูกค้า</label>
                                                <select2 :options="Name_Company	"</select2>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="float-right d-flex justify-content-between">
                                                <div class="border-left pl-2 ml-2">
                                                    <span class="text-info font-bold" style="font-size: 18px;">THB {{ grand_total | numberFormat }}</span><br/>
                                                    <span class="text-muted">จำนวนเงินรวม</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label>เลขที่ประจำตัวผู้เสียภาษี</label>
                                                    <input class="form-control" name="Tax_Number_Company" id = "Tax_Number_Company">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label>ที่อยู่ลูกค้า</label>
                                                    <textarea class="form-control" name="Address_Company" id = "Address_Company"></textarea>
                                                    <textarea class="form-control" name="PROVINCE_ID" id = "PROVINCE_ID"></textarea>
                                                    <textarea class="form-control" name="AMPHUR_ID" id = "AMPHUR_ID"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label>ชื่อผู้ติดต่อ</label>
                                                    <input class="form-control" name="Contact_Name_Company" id = "Contact_Name_Company">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label>อีเมล์ลูกค้า</label>
                                                    <input class="form-control" name="Email_Company" id = "Email_Company">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label>เบอร์โทรศัพท์ลูกค้า</label>
                                                    <input class="form-control"name="Tel_Company" id = "Tel_Company">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 border-left">
                                            <div class="row">
                                                <div class="col-sm-4 form-group">
                                                    <label>วันที่เอกสาร</label>
                                                    <datepicker name="Invoice_Date" id = "Invoice_Date":local="dateEn" clearable format="DD/MM/YYYY"></datepicker>
                                                </div>

                                                <div class="col-sm-4 form-group">
                                                    <label>เครดิต (วัน)</label>
                                                    <input class="form-control"name="Credit_Term_Company" id = "Credit_Term_Company">
                                                </div>
                                                <div class="col-sm-4 form-group">
                                                    <label>การคิดภาษี</label>
                                                    <select2 :options="Vat_Type" name="Vat_Type" id = "Vat_Type"></select2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-4 mb-3">
                                            <select2 :options="ID_Goods" name="ID_Goods" id = "ID_Goods"></select2>
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="table">
                                                <thead>
                                                <tr class="table-secondary">
                                                    <th scope="col" style="width: 60px;">#</th>
                                                    <th scope="col">สินค้า</th>
                                                    <th scope="col" class="text-center" style="width: 100px;">จำนวน</th>
                                                    <th scope="col" style="width: 100px;" class="text-right">ราคา/หน่วย</th>
                                                    <th scope="col" style="width: 100px;" class="text-right">รวมเป็นเงิน</th>
                                                    <th scope="col" style="width: 60px;" class="text-center">&nbsp;</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <template if="document.products.length > 0">
                                                    <tr v-for="(product, index) in document.products">
                                                        <td>{{ index+1 }}</td>
                                                        <td><input type="text" class="form-control form-control-sm" name="Goods_Name" id = "Goods_Name"></td>
                                                        <td><input class="form-control form-control-sm text-right" type="number"  name="Quantity_Goods" id = "Quantity_Goods"></td>
                                                        <td class="text-right">{{ product.sell_price | numberFormat }}</td>
                                                        <td class="text-right">{{ (product.sell_price*product.amount) | numberFormat }}</td>
                                                        <td><button type="button" class="btn btn-sm btn-danger btn-circle" @click="removeProduct(index)"><i class="fa fa-times"></i></button></td>
                                                    </tr>
                                                </template>
                                                <template v-else>
                                                    <tr>
                                                        <td colspan="7" class="text-center text-danger">ไม่มีข้อมูล</td>
                                                    </tr>
                                                </template>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="float-right d-flex justify-content-between">
                                                <table class="table" style="width: 350px;">
                                                    <tr>
                                                        <th>รวม</th>
                                                        <td class="text-right">{{ total | numberFormat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ส่วนลด</th>
                                                        <td><input class="form-control form-control-sm text-right" type="number" name="Discout" id = "Discout"></td>
                                                    </tr>
                                                    <tr v-if="document.discount > 0">
                                                        <th>จำนวนเงินหลังหักส่วนลด</th>
                                                        <td class="text-right">{{ totalAfterDiscount | numberFormat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>ภาษีมูลค่าเพิ่ม</th>
                                                        <td class="text-right">{{ Percent_Vat | numberFormat }}</td>
                                                    </tr>
                                                    <tr v-if="document.vat_type == 2">
                                                        <th>ราคาไม่รวมภาษี</th>
                                                        <td class="text-right">{{total_after_vat | numberFormat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>จำนวนเงินรวมทั้งหมด</th>
                                                        <td class="text-right">{{ grandTotal | numberFormat }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .select2-container{
                        width: 100%!important;
                    }
                    .datepicker {
                        z-index: auto!important;
                    }
                </style>

            </div>

            <div class="modal-footer">
                <a href="#" id="buttoninviocemanageModal" onclick="onaction_createorupdate()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>