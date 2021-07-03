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
                    <div class="form-group ">
                        <label for="Name_Goods" class="col-form-label">สินค้า:<span class="text-danger" >*</span></label>
                        <select  class="form-control" id="ID_Promotion" name="ID_Promotion">
                            <option value="">--เลือก--</option>
                            <?php
                            if(count($promotion)>0){
                                foreach($promotion as $val){
                            ?>
                             <option value="<?php echo $val->getID_Promotion(); ?>"><?php echo $val->getName_Promotion(); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Detail_Goods" class="col-form-label">รายละเอียดการยืม:</label>
                        <textarea class="form-control" name="Detail_BorrowOrReturn" id="Detail_BorrowOrReturns" rows="5" cols="60"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Price_Goods" class="col-form-label">จำนวน:<span class="text-danger" >*</span></label>
                        <input type="number" class="form-control" id="Price_Goods" name="Price_Goods" value=""
                               required="required" min="1">
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