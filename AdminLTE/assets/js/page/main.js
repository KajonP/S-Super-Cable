function logout(){
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
                    "ID_Employee" : ID_Employee
                },
                type: "POST",
                dataType: 'json',
                async:false,
                success: function(data, status) {

                   window.location.href = "index.php";

                },
                error: function(xhr, status, exception) {
                    //console.log(xhr);
                }
            });

        }
    })
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
      Password_Employee: {
        required: true,
        minlength: 3
      },
      Email_Employee: {
        required: true,
        minlength: 3
      },
      action: "required"
    },
    messages: {

        Name_Employee: {
        required:  "กรุณาใส่ข้อมูล",
        minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
      },
      Surname_Employee: {
        required:  "กรุณาใส่ข้อมูล",
        minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
      },
      Username_Employee: {
        required:  "กรุณาใส่ข้อมูล",
        minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
      },
      Password_Employee: {
        required:  "กรุณาใส่ข้อมูล",
        minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
      },
      Email_Employee: {
        required:  "กรุณาใส่ข้อมูล",
        minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
      },
      action: "กรุณาใส่ข้อมูล"

    },errorPlacement: function(error, element) {
        if (element.attr("name") == "Password_Employee" ){

            $(".error_replacement_edit_profile").html(error);

        }else{
        error.insertAfter(element)}
    }

  });
