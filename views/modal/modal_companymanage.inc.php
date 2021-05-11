<div class="modal fade" id="companymanageModal" tabindex="-1" role="dialog" aria-labelledby="companymanageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="companymanageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_companymanage" method='post' action='' enctype="multipart/form-data">
                    <!--  <input type="hidden" name="ID_Company" value="" /> -->
                    <div class="form-group" id="div_idcompany">
                        <!--  <label for="ID_Company" class="col-form-label">ไอดีบริษัทลูกค้า:</label>-->
                        <!--   <input type="text" class="form-control" id="ID_Company" name="ID_Company" value=""  required="required"  > -->
                    </div>
                    <div class="form-group ">
                        <label for="Name_Company" class="col-form-label">ชื่อบริษัท:</label>
                        <input type="text" class="form-control" id="Name_Company" name="Name_Company" value=""
                               required="required">
                    </div>
                    <div class="form-group">
                        <label for="Address_Company" class="col-form-label">ที่อยู่บริษัท:</label>
                        <input type="text" class="form-control" id="Address_Company" name="Address_Company" value=""
                               required="required">
                    </div>

                    <div class="form-group">
                        <label for="Tel_Company" class="col-form-label">เบอร์บริษัท:</label>
                        <input type="tel" class="form-control" id="Tel_Company" name="Tel_Company" value=""
                               required="required">
                    </div>
                    <div class="form-group">
                        <label for="Email_Company" class="col-form-label">อีเมล์บริษัท:</label>
                        <input type="email" class="form-control" id="Email_Company" name="Email_Company" value=""
                               required="required">
                    </div>
                    <div class="form-group">
                        <label for="Tax_Number_Company" class="col-form-label">เลขผู้เสียภาษี:</label>
                        <input type="tel" class="form-control" id="Tax_Number_Company" name="Tax_Number_Company"
                               value="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="Credit_Limit_Company" class="col-form-label">Credit Limit:</label>
                        <input type="number" class="form-control" id="Credit_Limit_Company" name="Credit_Limit_Company"
                               value="" min='0' required="required">
                    </div>
                    <div class="form-group">
                        <label for="Credit_Term_Company" class="col-form-label">Credit Term:</label>
                        <input type="text" class="form-control" id="Credit_Term_Company" name="Credit_Term_Company"
                               value="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="Cluster_Shop" class="col-form-label">Cluster:</label>
                        <select name="Cluster_Shop" class="form-control" id="Cluster_Shop">
                            <option value="ภาครัฐ">ภาครัฐ</option>
                            <option value="ภาคเอกชน">ภาคเอกชน</option>
                            <option value="รัฐวิสาหกิจ">รัฐวิสาหกิจ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Contact_Name_Company" class="col-form-label">ชื่อที่ติดต่อ:</label>
                        <input type="text" class="form-control" id="Contact_Name_Company" name="Contact_Name_Company"
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="IS_Blacklist" class="col-form-label">ติด Blacklist:</label>
                        <select name="IS_Blacklist" class="form-control" id="IS_Blacklist">
                            <option value="ใช่">ใช่</option>
                            <option value="ไม่ใช่">ไม่ใช่</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Cause_Blacklist" class="col-form-label">สาเหตุที่ติด Blacklist:</label>
                        <input type="text" class="form-control" id="Cause_Blacklist" name="Cause_Blacklist" value="">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <a href="#" id="button_companymanageModal" onclick="onaction_createorupdate()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>