<div class="modal fade" id="fileManageModal" tabindex="-1" role="dialog" aria-labelledby="fileManageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileManageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_fileManage" method='post' action='' enctype="multipart/form-data">

                    <div class="form-group ">
                        <label for="Name_File" class="col-form-label">ชื่อไฟล์:<span class="text-danger" >*</span></label>
                        <input type="text" class="form-control" id="Name_File" name="Name_File" value=""
                               required="required">
                    </div>

                    <div class="form-group">
                        <label for="Path_File" class="col-form-label">อัปโหลดไฟล์:<span class="text-danger" >*</span></label>
                        <input type="file" name="Path_File"  accept= "application/pdf">
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <a href="#" id="button_fileManageModal" onclick="onaction_createorupdate()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>


