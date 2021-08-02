<div class="modal fade" id="clustershopmanageModal" tabindex="-1" role="dialog" aria-labelledby="clustershopmanageModalDialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clustershopmanageTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Form -->
                <form id="form_clustershopmanage" method='post' action='' enctype="multipart/form-data">
                    <!--  <input type="hidden" name="ID_Company" value="" /> -->
                    <div class="form-group" id="div_idclustershop">
                        <!--  <label for="ID_Company" class="col-form-label">ไอดีบริษัทลูกค้า:</label>-->
                        <!--   <input type="text" class="form-control" id="ID_Company" name="ID_Company" value=""  required="required"  > -->
                    </div>
                    <div class="form-group ">
                        <label for="Cluster_Shop_Name" class="col-form-label">ชื่อกลุ่มลูกค้า:<span class="text-danger" >*</span></label>
                        <input type="text" class="form-control" id="Cluster_Shop_Name" name="Cluster_Shop_Name" value=""
                               required="required">
                    </div>
            <div class="modal-footer">
                <a href="#" id="button_clustershopmanageModal" onclick="onaction_createorupdate()" data-status="" data-id=""
                   class="btn btn-primary">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            </div>

        </div>
    </div>
</div>