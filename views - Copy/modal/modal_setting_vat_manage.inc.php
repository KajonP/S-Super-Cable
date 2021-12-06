<div class="modal fade" id="setting_vatmanageModal" tabindex="-1" role="dialog" aria-labelledby="setting_vatmanageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setting_vatmanageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_setting_vatmanage" method='post' action='' enctype="multipart/form-data">
                    <!-- <input type="hidden" name="ID_Excel" value=""/> -->
                    <div class="form-group" id="div_idsetting_vat">
                        <!--   <label for="ID_Excel" class="col-form-label">ไอดียอดขาย:</label> -->
                        <!--                        <input type="text" class="form-control" id="ID_Excel" name="ID_Excel" value=""> -->
                    </div>
                    <div class="form-group">
                        <label for="Percent_Vat" class="col-form-label">อัตราภาษีมูลค่าเพิ่ม:<span class="text-danger" >*</span></label>
                        <input type="number" class="form-control" id="Percent_Vat" name="Percent_Vat" value="" required="required" min ="0" >
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <a href="#" id="button_setting_vatmanageModal" onclick="onaction_createorupdate()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>