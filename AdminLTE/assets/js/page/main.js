function logout() {
  // เผื่อเก็บไว้ log
  var ID_Employee = "";
  Swal.fire({
    title: 'คุณเเน่ใจใช่ไหม?',
    text: "คุณต้องการออกจากระบบ?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirm'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "index.php?controller=Employee&action=logout",
        data: {
          "ID_Employee": ID_Employee
        },
        type: "POST",
        dataType: 'json',
        async: false,
        success: function (data, status) {

          window.location.href = "index.php";

        },
        error: function (xhr, status, exception) {
          //console.log(xhr);
        }
      });

    }
  })
}

$("#resetpassword_Profile").click(function () {
  $('#div_resetpassword_Profile').show();
  $(this).hide();
});

function showModalEditProfile() {
  /** show div password field */
  $('#resetpassword_Profile').show();
  $('#div_resetpassword_Profile').hide();

  /* modal show  */
  $('#editProfile').modal('show');
}

var form_profile_validate = $("#form_profile").validate({
  errorClass: 'errors',

  rules: {
    Name_Employee: {
      required: true,
      minlength: 3
    },
    Surname_Employee: {
      required: true,
      minlength: 3
    },
    Username_Employee: {
      required: true,
      minlength: 3
    },
    Password_Employee_Profile: {
      required: true,
      minlength: 3
    },
    Password_Employee_Profile_Confirm: {
      minlength: 3,
    },
    Email_Employee: {
      required: true,
      minlength: 3
    },
    profile: {

      extension: "jpg|jpeg|gif|png",
    },

    action: "required"
  },
  messages: {

    Name_Employee: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    Surname_Employee: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    Username_Employee: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    Password_Employee_Profile: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    Password_Employee_Profile_Confirm: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร",
      equalTo: "กรุณากรอกรหัสผ่านให้เหมือนกัน"
    },
    Email_Employee: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    profile: "กรุณาอัพโหลดไฟล์รูปภาพที่มีนามสกุลไฟล์คือ .png , .jpg ,.jpeg ,.gif เท่านั้น",
    action: "กรุณาใส่ข้อมูล"

  }, errorPlacement: function (error, element) {
    if (element.attr("name") == "Password_Employee_Profile" || element.attr("name") == "Password_Employee_Profile_Confirm") {


      error.insertAfter(".error_replacement_profile").after('<br>');


    } else {
      error.insertAfter(element);

    }
  }

});


$("#Password_Employee_Profile a").on('click', function (event) {
  event.preventDefault();
  if ($('#Password_Employee_Profile input').attr("type") == "text") {
    $('#Password_Employee_Profile input').attr('type', 'password');
    $('#Password_Employee_Profile i').addClass("fa-eye-slash");
    $('#Password_Employee_Profile i').removeClass("fa-eye");
  } else if ($('#Password_Employee_Profile input').attr("type") == "password") {
    $('#Password_Employee_Profile input').attr('type', 'text');
    $('#Password_Employee_Profile i').removeClass("fa-eye-slash");
    $('#Password_Employee_Profile i').addClass("fa-eye");
  }
});
$("#Password_Employee_Profile_Confirm a").on('click', function (event) {
  event.preventDefault();
  if ($('#Password_Employee_Profile_Confirm input').attr("type") == "text") {
    $('#Password_Employee_Profile_Confirm input').attr('type', 'password');
    $('#Password_Employee_Profile_Confirm i').addClass("fa-eye-slash");
    $('#Password_Employee_Profile_Confirm i').removeClass("fa-eye");
  } else if ($('#Password_Employee_Profile_Confirm input').attr("type") == "password") {
    $('#Password_Employee_Profile_Confirm input').attr('type', 'text');
    $('#Password_Employee_Profile_Confirm i').removeClass("fa-eye-slash");
    $('#Password_Employee_Profile_Confirm i').addClass("fa-eye");
  }
});
