<!-- modal dialog ( edit profile ) -->
<style>
.premise-items{margin-bottom: 15px;}
.thumnails-premise{
    border: 1px #08080759 solid; 
    border-radius: 7px;width: 100%; display: block;cursor:pointer;
    height: 168px; width: 168px;
}
.thumnails-premise-valid{
    border: 1px solid #fd8a5c;
    box-shadow: 0px 0px 6px #ff4700a3;
}
</style>

<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Personal information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Form -->
        <form id="form_profile" method='post' action='' enctype="multipart/form-data">
            <div class="col-md-12 premise-items" >
                    <?php
                    $pic = Router::getSourcePath(). "images/" .$employee->Picuture_Employee;
                    ?>
                    <img id="thumnails_profile"  browsid="profile"  class="thumnails-premise" src="<?= $pic ?>" alt="image" style=""/>
            
                    <input id="profile" name="profile" type="file"  accept=".png, .jpg,.jpeg,.gif"style=""   >
                    <!-- <br>
                    <label class="" style=" padding-top: 5px;">Profile Picture</label> -->
            </div>

          <div class="form-group row">
                <div class="col-md-6">
                    <label for="firstname" class="col-form-label">ชื่อ:</label>
                    <input type="text" class="form-control" id="firstname" name="Name_Employee" value="<?php echo $employee->getName_Employee() ?>" required="required" >
                </div>
                <div class="col-md-6">
                    <label for="surname" class="col-form-label">นามสกุล:</label>
                    <input type="text" class="form-control" id="surname" name="Surname_Employee" value="<?php echo $employee->getSurname_Employee() ?>" required="required" >
                </div>
          </div>

          <div class="form-group">
            <label for="username" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="Username_Employee" value="<?php echo $employee->getUsername_Employee() ?>"  required="required" >
          </div>
          <a href="#" id="resetpassword_Profile" class="btn btn-primary btn-block"><i class="fa fa-key"></i> Reset Password</a>
          <div class="form-group" id="div_resetpassword_Profile" style="display:none;">
                <label for="Password_Employee_Profile" id="lbl_Password_Employee_Profile" class="col-form-label">Password:</label>
                 <!-- <input type="password" class="form-control" id="Password_Employee_Profile" name="Password_Employee_Profile" value="" > -->
                 <div class="input-group" id="Password_Employee_Profile"  required="required">
                  <input class="form-control" id="passEmProfile" name="Password_Employee_Profile" type="password"><br>
                  <div class="input-group-append">
                    <a href="" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
                </div>
                <label for="Password_Employee_Profile" id="lbl_Password_Employee_Profile" class="col-form-label">Confirm Password:</label>
                <div class="input-group" id="Password_Employee_Profile_Confirm"  required="required">
                  <input class="form-control" name="Password_Employee_Profile_Confirm"  data-rule-equalTo="#passEmProfile" type="password">
                  <div class="input-group-append">
                    <a href="" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
                </div>
                <span class="error_replacement_profile"></span>

          </div>
            <!-- <div class="form-group" id="formgroup_currentpwd">
                <label for="Password_Employee" class="col-form-label">Password:</label>
           

                 <div class="input-group"  id="show_hide_password" required="required">
                  <input class="form-control" id="Password_Employee"  name="Password_Employee" value="<?php echo $employee->getCurrent_Password_Employee(); ?>"  type="password"  >
                  <div class="input-group-append">
                    <a href="" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
                </div>
                <span class="error_replacement_edit_profile"></span>

            </div> -->

          <div class="form-group">
            <label for="email" class="col-form-label">อีเมล์:</label>
            <input type="email" class="form-control" id="email" name="Email_Employee" value="<?php echo $employee->getEmail_Employee(); ?>" required="required" >
          </div>
      
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="editProfile()" class="btn btn-primary">ตกลง</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>