var columns = [
  {"width": "10%", "class": "text-left"},
  {"width": "20%", "class": "text-center"},
  {"width": "15%", "class": "text-left"},
  {"width": "15%", "class": "text-right"},
  {"width": "40%", "class": "text-center"},

]

var dataTable_ = $('#tbl_companymanagement').DataTable({
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

var form_validte = $("#form_companymanage").validate({
  rules: {
    ID_Company: {
      //required: true,
    },
    Name_Company: {
      required: true,
      minlength: 3
    },
    Address_Company: {
      required: true,
      minlength: 3
    },
    AMPHUR_ID: {
      required: true,
    },
    Tel_Company: {
      required: true,
      minlength: 10
    },
    Email_Company: {
      required: true,
      minlength: 3
    },
    Tax_Number_Company: {
      required: true,
      minlength: 13
    },
    Credit_Limit_Company: {
      required: true,
    },
    Credit_Term_Company: {
      required: true,
      minlength: 3
    },
    Cluster_Shop: {
      required: true,
    },
    Contact_Name_Company: {
      required: false,
    },
    IS_Blacklist: {
      required: true,
    },
    Cause_Blacklist: {
      required: false,
    },
    action: "required"
  },
  messages: {
    ID_Company: {
      // required: "กรุณาใส่ข้อมูล",
    },
    Name_Company: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    Address_Company: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    AMPHUR_ID: {
      required: "กรุณาใส่ข้อมูล",
    },
    Tel_Company: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 10 ตัวอักษร"
    },
    Email_Company: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    Tax_Number_Company: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 13 ตัวอักษร"
    },
    Credit_Limit_Company: {
      required: "กรุณาใส่ข้อมูล",
    },
    Credit_Term_Company: {
      required: "กรุณาใส่ข้อมูล",
      minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    action: "กรุณาใส่ข้อมูล"
  }, errorPlacement: function (error, element) {
    {
      error.insertAfter(element)
    }
  }
});

function companymanageShow(type, ID_Company = null) {
  //clear ค่าเก่า
  $('#form_companymanage input').attr('readonly', false);
  $('#form_companymanage select').attr("disabled", false);
  $('#button_companymanageModal').show();


  var title = "";

  /* clear old form value */
  $('#form_companymanage')[0].reset();

  switch (type) {
    case 'create':
      title = "สร้างบริษัทลูกค้า";

      $('#div_idcompany').show();

      // set id
      $('#button_companymanageModal').attr("data-id", null);
      break;
    case 'edit':
      title = "เเก้ไขบริษัทลูกค้า ";
      //clear error if exists
      form_validte.resetForm();

      onaction_getinptval(ID_Company);

      break;
    case 'view':
      title = "บริษัทลูกค้า ";
      //clear error if exists
      form_validte.resetForm();

      onaction_getinptval(ID_Company);

      $('#form_companymanage input').attr('readonly', 'readonly');
      $('#form_companymanage select').attr("disabled", true);
      $('#button_companymanageModal').hide();

      break;
    default:
      // ..
      break;
  }

  /* set title */
  $('#companymanageTitle').html(title);

  /* set button event  */
  $('#button_companymanageModal').attr("data-status", type);

  /* modal show  */
  $('#companymanageModal').modal('show');
}

function onaction_getinptval(ID_Company) {
  $.ajax({
    url: "index.php?controller=Company&action=findbyID",
    data: {
      "ID_Company": ID_Company
    },
    type: "POST",
    dataType: 'json',
    async: false,
    success: function (response, status) {
      /* set input value */
      $('#div_idcompany').hide();

      $('#ID_Company').val(response.data.ID_Company);
      $('#Name_Company').val(response.data.Name_Company);
      $('#Address_Company').val(response.data.Address_Company);
      $("#Tel_Company").val(response.data.Tel_Company);
      $('#Email_Company').val(response.data.Email_Company);
      $('#Tax_Number_Company').val(response.data.Tax_Number_Company);
      $('#Credit_Limit_Company').val(response.data.Credit_Limit_Company);
      $("#Credit_Term_Company").val(response.data.Credit_Term_Company);
      // case: dropdown
      $('#Cluster_Shop')
        .val(response.data.Cluster_Shop)
        .trigger('change');
      $('#Contact_Name_Company').val(response.data.Contact_Name_Company);
      // case: dropdown
      $('#IS_Blacklist')
        .val(response.data.IS_Blacklist)
        .trigger('change');
      $('#Cause_Blacklist').val(response.data.Cause_Blacklist);
      // case: dropdown
      $('#AMPHUR_ID')
        .val(response.data.AMPHUR_ID)
        .trigger('change');
      // set id
      $('#button_companymanageModal').attr("data-id", ID_Company);
    },
    error: function (xhr, status, exception) {
      //console.log(xhr);
    }
  });
}

function onaction_deletecompany(ID_Company) {
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
        url: "index.php?controller=Company&action=delete_company",
        data: {
          "ID_Company": ID_Company
        },
        type: "POST",
        dataType: 'json',
        async: false,
        success: function (data, status) {
          if (data.status == true) {
            Swal.fire(
              'ลบเรียบร้อย!',
              'ข้อมูลคุณถูกลบเรียบร้อยเเล้ว',
              'success'
            ).then((result) => {
              location.reload();

            });
          }

        },
        error: function (xhr, status, exception) {
          //console.log(xhr);
        }
      });

    }
  })
}

// case: ตอนอัพโหลดไฟล์ excel validate ว่าใช่ไฟล์ excel ไหมถ้าไม่ใช่ขึ้นแจ้งเตือนว่า type ไม่ตรง
$('#form_importexcel').validate({
  rules: {
    file: {

      extension: "xlsx|xls|csv|xlsm",

    }
  },
  messages: {
    file: "กรุณาอัพโหลดไฟล์ Excel ที่นามสกุล .xlsx, .xlsm, .xls เท่านั้น"
  },
  errorPlacement: function (error, element) {
    //แจ้งเตือนผิด format
    Swal.fire({
      icon: 'error',
      title: 'ขออภัย...',
      text: "กรุณาอัพโหลดไฟล์ Excel ที่นามสกุล .xlsx, .xlsm, .xls เท่านั้น",
      confirmButtonText: 'ตกลง',

    }).then((result) => {
      // break
      location.reload();

    });
  }
});

// eof
function downloadExcel() {
  var url_string = "index.php?controller=Company&action=export_excel";
  $.ajax({
    type: "POST",
    url: "index.php?controller=Company&action=export_excel",
    data: {
      "page": 'manage_company'
    },

    dataType: 'json',

    success: function (data, status, xhr) {

      console.log(data);
      var filename = data.filename;
      //alert(data.filename);
      //window.location.href = "./uploads/" + filename;


    }
  });
}

$("#button_importcompanyModal").on('click', function (event) {
  var form_importexcel = $('#form_importexcel')[0];
  var formData_importexcel = new FormData(form_importexcel);
  var url_string = "index.php?controller=Company&action=import_excel";
  if ($('#form_importexcel #examfile').val() != '' || $('#form_importexcel #file').val() != '') {
    $.ajax({
      type: "POST",
      url: url_string,
      processData: false,
      contentType: false,
      data: formData_importexcel,
      success: function (data, status, xhr) {
        var data = JSON.parse(data);
        console.log(data);
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
            text: data.message,
            confirmButtonText: 'ตกลง',

          }).then((result) => {
            location.reload();

          });
        }


      }
    });

  } else {
    // error handle
    Swal.fire({
      icon: 'error',
      title: 'ขออภัย...',
      text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
      confirmButtonText: 'ตกลง',

    }).then((result) => {
      return;

    });
  }

});

function onaction_createorupdate(ID_Company = null) {

  var type = $('#button_companymanageModal').attr("data-status");

  var form = $('#form_companymanage')[0];
  var formData = new FormData(form);

  switch (type) {
    case 'create':
      var url_string = "index.php?controller=Company&action=create_company";
      if (!$("#form_companymanage").validate().form()) {
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
          success: function (data, status, xhr) {
            var data = JSON.parse(data);
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

      break;
    case 'edit':
      var ID_Company = $("#button_companymanageModal").attr("data-id");

      var url_string = "index.php?controller=Company&action=edit_company&ID_Company=" + ID_Company;
      if (!$("#form_companymanage").validate().form()) {
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
          success: function (data, status, xhr) {
            var data = JSON.parse(data);
            console.log(data);
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

      break;
    default:
      // ..
      break;
  }
}
function importShow() {

  /* modal show  */
  $('#importcompanyModal').modal('show');

}
