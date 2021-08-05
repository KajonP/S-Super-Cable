<div class="modal fade" id="invManageModal" tabindex="-1" role="dialog" aria-labelledby="invManageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invManageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_invManage" method='post' action='' enctype="multipart/form-data">
                <!-- -->
                <div class="form-group">
                    <label>ลูกค้า</label>
                    <select class="form-control" name="ID_Company" id="ID_Company">
                        <option value="">--เลือก--</option>
                        <?php
                        if(count($company) > 0){
                            foreach($company as $val){
                        ?>
                        <option value="<?php echo $val->getID_Company(); ?>"><?php echo $val->getName_Company(); ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- -->
                <div class="form-group">
                    <label>สถานะ</label>
                    <input type="text" class="form-control">
                </div>
                <!-- -->
                <div class="form-group" style="display:none;">
                    <label>จำนวนเงิน</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
                <!-- -->
                <div class="form-group">
                    <label>เลขที่ประจำตัวผู้เสียภาษี</label>
                    <input type="text" name="Tax_Number_Company" id="Tax_Number_Company" class="form-control">
                </div>
                <!-- -->
                <div class="form-group" style="display:none;">
                    <label>สาขา</label>
                    <input type="text" class="form-control">
                </div>
                <!-- -->
                <div class="form-group">
                    <label>ที่อยู่ลูกค้า</label>
                    <input type="text" name="Address_Company" id="Address_Company" class="form-control">
                </div>
                <!-- -->
                <div class="form-group">
                    <label>ชื่อผู้ติดต่อ</label>
                    <input type="text" name="Contact_Name_Company" id="Contact_Name_Company" class="form-control">
                </div>
                <!-- -->
                 <div class="form-group">
                    <label>อีเมล์ลูกค้า</label>
                    <input type="text" name="Email_Company" id="Email_Company" class="form-control">
                </div>
                <!-- -->
                 <div class="form-group">
                    <label>เบอร์โทรศัพท์ลูกค้า</label>
                    <input type="text" name="Tel_Company" id="Tel_Company" class="form-control">
                </div>
                <!-- -->
                 <div class="form-group" style="display:none;">
                    <label>เบอร์โทรสารลูกค้า</label>
                    <input type="text" class="form-control">
                </div>
                <!-- -->
                 <div class="form-group">
                    <label>วันที่เอกสาร</label>
                    <input type="text" name="Invoice_Date" id="Invoice_Date" class="form-control">
                </div>
                <!-- -->
                 <div class="form-group" style="display:none;">
                    <label>วันที่ครบกำหนด</label>
                    <input type="text" class="form-control">
                </div>
                
                <!-- -->
                 <div class="form-group">
                    <label>เครดิต (วัน)</label>
                    <input type="text" name="Credit_Term_Company" id="Credit_Term_Company" class="form-control">
                </div>
                <!-- -->
                <table class="table">
                    <thead>
                        <tr class="table-secondary">
                        <th scope="col" style="width: 10%;">#</th>
                        <th scope="col" style="width: 20%; font-size: 12px;">รหัสสินค้า</th>
                        <th scope="col" style="width: 20%; font-size: 12px;">สินค้า</th>
                        <th scope="col" class="text-center" style="width: 10%; font-size: 12px;">จำนวน</th>
                        <th scope="col" style="width: 15%; font-size: 12px;" class="text-right">ราคา/หน่วย</th>
                        <th scope="col" style="width: 15%; font-size: 12px;" class="text-right">รวมเป็นเงิน</th>
                        <th scope="col" style="width: 15%; font-size: 12px;" class="text-center">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
                <!-- -->
                </form>

            </div>

            <div class="modal-footer">
                <a href="#" id="button_invManageModal" onclick="onaction_createoredit()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>
