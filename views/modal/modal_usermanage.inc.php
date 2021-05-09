<div class="modal fade" id="usermanageModal" tabindex="-1" role="dialog" aria-labelledby="usermanageModalDialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usermanageTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <!-- Form -->
        <form id="form_usermanage" method='post' action='' enctype="multipart/form-data">
        <div class="form-group" id="div_idemployee">
            <label for="ID_Employee" class="col-form-label">ไอดีพนักงาน:</label>
            <input type="text" class="form-control" id="ID_Employee" name="ID_Employee" value=""  required="required" >
          </div>

          <div class="form-group row">
                <div class="col-md-6">
                    <label for="firstname" class="col-form-label">ชื่อ:</label>
                    <input type="text" class="form-control"  id="Name_Employee" name="Name_Employee" value="" required="required" >
                </div>
                <div class="col-md-6">
                    <label for="surname" class="col-form-label">นามสกุล:</label>
                    <input type="text" class="form-control" id="Surname_Employee" name="Surname_Employee" value="" required="required" >
                </div>
          </div>
          
          <div class="form-group">
            <label for="username" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="Username_Employee" name="Username_Employee" value=""  required="required" >
          </div>

            <a href="#" id="resetpassword" class="btn btn-primary btn-block"><i class="fa fa-key"></i> Reset Password</a>

            <div class="form-group" id="div_password" style="display:none;">
                <label for="Password_Employee" id="lbl_Password_Employee" class="col-form-label">Password:</label>
                 <!-- <input type="password" class="form-control" id="Password_Employee" name="Password_Employee" value="" > -->
                 <div class="input-group" id="Password_Employee"  required="required">
                  <input class="form-control" name="Password_Employee" type="password">
                  <div class="input-group-append">
                    <a href="" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
                </div>
                <span class="error_replacement"></span>

            </div>

          <div class="form-group">
            <label for="email" class="col-form-label">อีเมล์:</label>
            <input type="email" class="form-control" id="Email_Employee" name="Email_Employee" value="" required="required" >
          </div>

          <div class="form-group">
          <label for="role" class="col-form-label">สถานะ:</label>
          <select name="User_Status_Employee" class="form-control" id="User_Status_Employee">
                
                <option value="Admin">Admin</option>
                <option value="Sales">Sales</option>
                <option value="User">User</option>
                
          </select>

          </div>
      
        </form>
      </div>
      
      <div class="modal-footer">
        <a href="#" id="button_usermanageModal" onclick="onaction_createorupdate()" data-status="" data-id="" class="btn btn-primary">ตกลง</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      </div>
      
    </div>
  </div>
</div>