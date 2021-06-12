<div class="modal fade" id="goodsmanageModal" tabindex="-1" role="dialog" aria-labelledby="goodsmanageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="goodsmanageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_goodsmanage" method='post' action='' enctype="multipart/form-data">
                    <!--  <input type="hidden" name="ID_Company" value="" /> -->
                    <div class="form-group" id="div_idgoods">
                        <!--  <label for="ID_Company" class="col-form-label">ไอดีบริษัทลูกค้า:</label>-->
                        <!--   <input type="text" class="form-control" id="ID_Company" name="ID_Company" value=""  required="required"  > -->
                    </div>
                    <div class="form-group ">
                        <label for="Name_Goods" class="col-form-label">ชื่อสินค้า:<span class="text-danger" >*</span></label>
                        <input type="text" class="form-control" id="Name_Goods" name="Name_Goods" value=""
                               required="required">
                    </div>
                    <div class="form-group">
                        <label for="Detail_Goods" class="col-form-label">รายละเอียดสินค้า:</label>
                        <input type="text" class="form-control" id="Detail_Goods" name="Detail_Goods" value="">
                    </div>
                    <div class="form-group">
                        <label for="Price_Goods" class="col-form-label">ราคาสินค้า:<span class="text-danger" >*</span></label>
                        <input type="number" class="form-control" id="Price_Goods" name="Price_Goods" value=""
                               required="required" min="0">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <a href="#" id="button_goodsmanageModal" onclick="onaction_createorupdate()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>