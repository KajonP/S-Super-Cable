<div class="modal fade" id="newsManageModal" tabindex="-1" role="dialog" aria-labelledby="newsManageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsManageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_newsManage" method='post' action='' enctype="multipart/form-data">
                    
                    <!-- Title_Message -->
                    <div class="form-group ">
                    <label for="Tittle_Message" class="col-form-label">ชื่อหัวข้อข่าวสาร:<span class="text-danger" >*</span></label>
                        <input type="text" class="form-control" id="Tittle_Message" name="Tittle_Message" value="" required="required" >
                    </div>
                    
                   <!-- Text_Message -->
                   <div class="form-group ">
                    <label for="Text_Message" class="col-form-label">เนื้อข่าวสาร:<span class="text-danger" >*</span></label>
                        <input type="text" class="form-control" id="Text_Message" name="Text_Message" value="">
                    </div>
                    
                    <div class="form-group">
                        <!-- set default image  -->
                        <?php $pic = Router::getSourcePath() . "images/" . $employee->Picuture_Employee; ?>
                        <!-- select image to upload -->
                        <img id="thumnails_new_profile" browsid="profile_news" class="thumnails-premise" src="<?= $pic ?>"  style=""/>
                        
                        <!-- chosse file -->
                        <input id="profile_news" name="profile_news" type="file" accept=".png, .jpg,.jpeg,.gif" style="" onchange="preview();" >                
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <a href="#" id="button_newsManageModal" onclick="onaction_createoredit()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript" src="AdminLTE/assets/js/page/manage_upload_pic_news.js"></script>