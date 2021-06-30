var columns = [
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
]

var dataTable_ = $("#tbl_file").DataTable({
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
      "sLast":     "หน้าสุดท้าย",
      "oAria": {
        "sSortAscending":  ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
        "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
      }
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



var form_validte = $("#form_fileManage").validate({
  rules: {
    Name_File: {
      required: true,
    },
    Path_File: {
      extension: "pdf",
    },
    Detail_File :
      {
        required: false,
      },
    Date_Upload_File :
      {
        required: false,
      },

    action: "required"
  },
  messages: {
    Name_File: {
      required: "กรุณาใส่ข้อมูล",
    },
    Path_File: "กรุณาอัพโหลดไฟล์ที่มีนามสกุลไฟล์คือ .pdf เท่านั้น",
    Detail_File: {
    },
    Date_Upload_File: {
    },
    action: "กรุณาใส่ข้อมูล"
  }, errorPlacement: function (error, element) {
    {
      error.insertAfter(element)
    }
  }
});


// show dialog create or edit
function  fileManageShow(type, ID_File ) {
  var title = "" ;

  /* clear old form value */
  $('#form_fileManage')[0].reset();
  $('#Path_File').attr("src", "");

  switch(type)
  {
    case "create":
      title = "สร้างไฟล์";

      // set id
      $('#button_fileManageModal').attr("data-id", null);

      //
      form_validte.resetForm();

      break;
    case "edit":

      // แก้ไขไฟล์
      title = "แก้ไขไฟล์";

      //clear error if exists
      form_validte.resetForm();
      get_file_to_edit(ID_File);
      // set id
      $('#button_fileManageModal').attr("data-id", ID_File);

      break;

    default:
      // ..
      break;
  }

  /* set title */
  $('#fileManageTitle').html(title);

  /* set button event  */
  $('#button_fileManageModal').attr("data-status", type);

  /* modal show  */
  $('#fileManageModal').modal('show');

}


function onAction_deleteFile(ID_File) {

  delete_file(ID_File);
}


function onaction_createorupdate(ID_File = null) {

  var type = $('#button_fileManageModal').attr('data-status');

  var data = new FormData();

  var form_data = $('#form_fileManage').serializeArray();
  $.each(form_data, function (key, input) {
    data.append(input.name, input.value);
  });

  var file_data = $('input[name="Path_File"]')[0].files;

  if (type == "create" )
  {
    //File data
    if (file_data.length > 0)
    {
      for (var i = 0; i < file_data.length; i++)
      {
        data.append("Path_File[]", file_data[i]);
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
          data.append("Path_File[]", file_data[i]);
        }
      }
    }
  }

  switch(type) {
    case 'create':
      create_file(data);
      break;
    case 'edit':
      update_file(data);
      break;
  }

}


// call ajax to insert data into server.
function create_file(formData)
{
  var url_string = "index.php?controller=File&action=create_file";
  if (!$("#form_fileManage").validate().form()) {
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
function get_file_to_edit(ID_File) {
  $.ajax({
    url: "index.php?controller=File&action=findById",
    data: {
      "ID_File": ID_File
    },
    type: "POST",
    dataType: 'json',
    async: false,
    success: function (response, status) {
      /* set input value */
      $("#ID_File").val(response.data.ID_File);
      $("#Name_File").val(response.data.Name_File);
      $("#Path_File").attr("src", response.data.Path_File);
      $("#Detail_File").val(response.data.Detail_File);
      $("#Date_Upload_File").val(response.data.Date_Upload_File);

    },
    error: function (xhr, status, exception) {
      console.log(xhr);
    }
  });

}


function update_file(formData)
{
  var ID_File = $("#button_fileManageModal").attr("data-id");
  var url_string = "index.php?controller=File&action=edit_file&ID_File=" + ID_File;
  if (!$("#form_fileManage").validate().form()) {
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


function delete_file(ID_File)
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
        url: "index.php?controller=File&action=delete_file&ID_File=" + ID_File,
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
