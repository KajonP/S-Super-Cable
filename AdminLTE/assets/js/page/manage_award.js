
var columns = [
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
    {"width": "5%", "class": "text-center"},
  ]

var dataTable_ = $("#tbl_award").DataTable({
  "processing": true,
  "bDestroy": true,
  "bPaginate": true,
  "bFilter": true,
  "bInfo": true,
  "searching": true,
  "language": {
    "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
    "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
    "sSearch": "ค้นหา :",
    "aaSorting" :[[0,'desc']],
    "paginate": {
      "sFirst":    "หน้าแรก",
      "sPrevious": "ก่อนหน้า",
      "sNext":     "ถัดไป",
      "sLast":     "หน้าสุดท้าย"
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

var form_validte = $("#form_awardManage").validate({
  rules: {
    Tittle_Award: {
      required: true,
    },
    ID_Employee: {
      required: true,
    },
    award_pic: {
      extension: "jpg|jpeg|gif|png",
    },

    action: "required"
  },
  messages: {
    Tittle_Award: {
      required: "กรุณาใส่ข้อมูล",
    },
    ID_Employee: {
      required: "กรุณาใส่ข้อมูล",
    },
    award_pic: "กรุณาอัพโหลดไฟล์รูปภาพที่มีนามสกุลไฟล์คือ .png , .jpg ,.jpeg ,.gif เท่านั้น",
    action: "กรุณาใส่ข้อมูล"
  }, errorPlacement: function (error, element) {
    {
      error.insertAfter(element)
    }
  }
});

// show dialog create or edit
function  awardManageShow(type, ID_Award ) {
    var title = "" ;

    /* clear old form value */
    $('#form_awardManage')[0].reset();
    $("#thumnails_award_pic").attr("src", "");

      switch(type)
      {
        case "create":
          title = "สร้างรางวัล";

          // set id
          $('#button_awardManageModal').attr("data-id", null);
          form_validte.resetForm();

          break;
        case "edit":

          title = "แก้ไขขรางวัล";

          form_validte.resetForm();
          get_award_to_edit(ID_Award);
          // set id
          $('#button_awardManageModal').attr("data-id", ID_Award);

          break;

        default:
          // ..
          break;
      }

      /* set title */
      $('#awardManageTitle').html(title);

      /* set button event  */
      $('#button_awardManageModal').attr("data-status", type);

      /* modal show  */
      $('#awardManageModal').modal('show');

  }


function onaction_createorupdate(ID_Award = null) {

  var type = $('#button_awardManageModal').attr('data-status');
  var data = new FormData();

  var form_data = $('#form_awardManage').serializeArray();
  $.each(form_data, function (key, input) {
      data.append(input.name, input.value);
  });

  var file_data = $('input[name="award_pic"]')[0].files;

  if (type == "create" )
  {
      //File data
    if (file_data.length > 0)
    {
      for (var i = 0; i < file_data.length; i++)
      {
          data.append("award_pic[]", file_data[i]);
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
          data.append("award_pic[]", file_data[i]);
      }
    }
  }

  switch(type) {
    case 'create':
      create_award(data);
      break;
    case 'edit':
      update_award(data);
      break;
  }
}


function create_award(formData)
{
  var url_string = "index.php?controller=Award&action=create_award";
  if (!$("#form_awardManage").validate().form()) {
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


function get_award_to_edit(ID_Award) {
  $.ajax({
    url: "index.php?controller=Award&action=findAwardbyID_Award",
    data: {
      "ID_Award": ID_Award
    },
    type: "POST",
    dataType: 'json',
    async: false,
    success: function (response, status) {
      /* set input value */


      // set vaule to html tag
      $('#Tittle_Award').val(response.data.Tittle_Award);
      $('#ID_Employee_Award').val(response.data.ID_Employee).trigger('change')
      $("#thumnails_award_pic").attr("src", response.data.Picture_Award);

    },
    error: function (xhr, status, exception) {
      console.log(xhr);
    }
  });

}


function update_award(formData)
{
  var ID_Award = $("#button_awardManageModal").attr("data-id");
  var url_string = "index.php?controller=Award&action=edit_award&ID_Award=" + ID_Award;
  if (!$("#form_awardManage").validate().form()) {
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
      console.log(res);
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


function onAction_deleteAward(ID_Award)
{
  delete_award(ID_Award);
}


function delete_award(ID_Award)
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
        url: "index.php?controller=Award&action=delete_award&ID_Award=" + ID_Award,
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
