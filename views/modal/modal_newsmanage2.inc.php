<div class="modal fade" id="newsManageViewModal" tabindex="-1" role="dialog" aria-labelledby="newsManageViewModalDialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsManageTitle">รายละเอียด</h5>
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
                        <input type="text" class="form-control" id="Tittle_Message_view" name="Tittle_Message_view" value="" required="required" >
                    </div>
                    
                   <!-- Text_Message -->
                   <div class="form-group ">
                    <label for="Text_Message" class="col-form-label">เนื้อข่าวสาร:</label>
                        <!--<input type="text" class="form-control" id="Text_Message" name="Text_Message" value="">-->
                        <div id="Text_Message_view" rows="10" cols="80"></div>
                    </div>
                    
                    <div class="form-group">
                        <!-- select image to upload -->
                        <img id="thumnails_new_profile_view" browsid="profile_news_view" class="thumnails-premise"  src="" style=""/>
                        
                        <!-- chosse file -->
                        <input id="profile_news_view" name="profile_news_view" type="file"  style="" onchange="preview();" >      
                        <!-- -->
                        <br/><br/>
                        <img id="thumnails_new_profile_view2" browsid="profile_news_view2" class="thumnails-premise"   src="" style=""/>
                        
                        <!-- chosse file -->
                        <input id="profile_news_view2" name="profile_news_view2" type="file" style="" onchange="preview2();" >        
                        <!-- -->  
                        <br/><br/>
                        <img id="thumnails_new_profile_view3" browsid="profile_news_view3" class="thumnails-premise" src=""  style=""/>
                        
                        <!-- chosse file -->
                        <input id="profile_news_view3" name="profile_news_view3" type="file"  style="" onchange="preview3();" >          
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