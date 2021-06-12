var columns = [
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
  ]

var dataTable_ = $("#tbl_news").DataTable({
  "processing": true,
  "bDestroy": true,
  "bPaginate": true,
  "bFilter": true,
  "bInfo": true,
  "searching": true,
  "language": {
    "paginate": {
      "previous": "ก่อนหน้า",
      "next": "ถัดไป"
    }
  },

  // "responsive": true,
  rowReorder: {
    selector: 'td:nth-child(2)'
  },
  responsive: true,

  initComplete: function () {

  },
  "columns": columns


});



var form_validte = $("#form_newsManage").validate({
  rules: {
    Tittle_Message: {
      required: true,
    },
    Text_Message: {
      required: true,
    },
    profile_news: {
      extension: "jpg|jpeg|gif|png",
    },

    action: "required"
  },
  messages: {
    Tittle_Message: {
      required: "กรุณาใส่ข้อมูล",
    },
    Text_Message: {
      required: "กรุณาใส่ข้อมูล",
    },
    profile_news: "กรุณาอัพโหลดไฟล์รูปภาพที่มีนามสกุลไฟล์คือ .png , .jpg ,.jpeg ,.gif เท่านั้น",
    action: "กรุณาใส่ข้อมูล"
  }, errorPlacement: function (error, element) {
    {
      error.insertAfter(element)
    }
  }
});


// show dialog create or edit
function  newsManageShow(type, ID_Message ) {
  var title = "" ;

  /* clear old form value */
  $('#form_newsManage')[0].reset();
  $("#thumnails_award_pic").attr("src", "");

    switch(type)
    {
      case "create":
        title = "สร้างข่าวสาร";

        // set id
        $('#button_newsManageModal').attr("data-id", null);

        //
        form_validte.resetForm();

        break;
      case "edit":

        // แก้ไขข่าวสาร
        title = "แก้ไขข่าวสาร";

        //clear error if exists
        form_validte.resetForm();
        get_news_to_edit(ID_Message);
        // set id
        $('#button_newsManageModal').attr("data-id", ID_Message);

        break;

      default:
        // ..
        break;
    }

    /* set title */
    $('#newsManageTitle').html(title);

    /* set button event  */
    $('#button_newsManageModal').attr("data-status", type);

    /* modal show  */
    $('#newsManageModal').modal('show');

  }


function onAction_deleteMessage(ID_Message) {

  delete_news(ID_Message);
}


function onaction_createoredit(ID_Message = null) {

  var type = $('#button_newsManageModal').attr('data-status');

  var data = new FormData();

  var form_data = $('#form_newsManage').serializeArray();
  $.each(form_data, function (key, input) {
      data.append(input.name, input.value);
  });

  var file_data = $('input[name="profile_news"]')[0].files;

  if (type == "create" )
  {
      //File data
    if (file_data.length > 0)
    {
      for (var i = 0; i < file_data.length; i++)
      {
          data.append("profile_news[]", file_data[i]);
      }
    }
  }
  else
  {
    //File data
    // edit if insert picture
    if (file_data.length > 0)
    {
      for (var i = 0; i < file_data.length; i++)
      {
          data.append("profile_news[]", file_data[i]);
      }
    }
  }

  switch(type) {
    case 'create':
      create_news(data);
      break;
    case 'edit':
      update_new(data);
      break;
  }

}


// call ajax to insert data into server.
function create_news(formData)
{
  var url_string = "index.php?controller=News&action=create_news";
      if (!$("#form_newsManage").validate().form()) {
        Swal.fire({
          icon: 'error',
          title: 'ขออภัย...',
          text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
          confirmButtonText: 'ตกลง',
        }).then((result) => {
          return;

        });
      } else {
        $.ajax({
          type: "POST",
          url: url_string,
          data: formData,
          processData: false,
          contentType: false,
          enctype: 'multipart/form-data',
          success: function (res, status, xhr) {
            var data = JSON.parse(res);
            if (data.status == true) {
              Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                confirmButtonText: 'ตกลง',
              }).then((result) => {
                location.reload();

              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'ขออภัย...',
                text: 'มีบางอย่างผิดพลาด , อาจจะมีข้อมูลอยู่ในฐานข้อมูลเเล้ว , โปรดลองอีกครั้ง',
                confirmButtonText: 'ตกลง',
              }).then((result) => {
                location.reload();

              });
            }
          }
        });
      }
}

// set value into html tag
// call ajax get data from server.
function get_news_to_edit(ID_Message) {
  $.ajax({
    url: "index.php?controller=News&action=findbyID_Message",
    data: {
      "ID_Message": ID_Message
    },
    type: "POST",
    dataType: 'json',
    async: false,
    success: function (response, status) {
      /* set input value */

      $('#Tittle_Message').val(response.data.Tittle_Message);
      $('#Text_Message').val(response.data.Text_Message);
      $("#thumnails_new_profile").attr("src", response.data.Picture_Message);

    },
    error: function (xhr, status, exception) {
      console.log(xhr);
    }
  });

}


function update_new(formData)
{
  var ID_Message = $("#button_newsManageModal").attr("data-id");
  var url_string = "index.php?controller=News&action=edit_news&ID_Message=" + ID_Message;
  if (!$("#form_newsManage").validate().form()) {
    Swal.fire({
      icon: 'error',
      title: 'ขออภัย...',
      text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
      confirmButtonText: 'ตกลง',

    }).then((result) => {
      return;

    });
  } else {
    $.ajax({
      type: "POST",
      url: url_string,
      data: formData,
      processData: false,
      contentType: false,
      enctype: 'multipart/form-data',
      success: function (res, status, xhr) {
      var data = JSON.parse(res);
      if (data.status == true) {
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ',
          confirmButtonText: 'ตกลง',

        }).then((result) => {
          location.reload();

        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'ขออภัย...',
          text: 'มีบางอย่างผิดพลาด',
          confirmButtonText: 'ตกลง',

        }).then((result) => {
          location.reload();

        });
        }
      }
    });
  }

}


function delete_news(ID_Message)
{
  Swal.fire({
    title: 'คุณเเน่ใจใช่ไหม?',
    text: "คุณต้องการลบข้อมูลนี้ใช่ไหม?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'

  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "index.php?controller=News&action=delete_news&ID_Message=" + ID_Message,
        processData: false,
        contentType: false,
        success: function (res, status, xhr) {
          var data = JSON.parse(res);
          if (data.status == true) {
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ',
              confirmButtonText: 'ตกลง',
            }).then((result) => {
              location.reload();

            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'ขออภัย...',
              text: 'มีบางอย่างผิดพลาด , อาจจะมีข้อมูลอยู่ในฐานข้อมูลเเล้ว , โปรดลองอีกครั้ง',
              confirmButtonText: 'ตกลง',
            }).then((result) => {
              location.reload();

            });
          }
        }
      });

    }
  })
}
