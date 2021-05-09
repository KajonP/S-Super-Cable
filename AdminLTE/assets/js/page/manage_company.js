
var columns = [
  { "width": "5%" , "class": "text-left"},
  { "width": "5%" , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-left"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%" , "class": "text-right"},
  { "width": "5%" , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},

]

var dataTable_ = $('#tbl_companymanagement').DataTable( {
  "processing": true,
  "bDestroy": true,
  "bPaginate":true,
  "bFilter":true,
  "bInfo" : true,
  "searching": true,


  // "responsive": true,
  rowReorder: {
    selector: 'td:nth-child(2)'
  },
  responsive: true,

  initComplete: function(){

  } ,

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
    Contact_Name_Company :{
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
  },errorPlacement: function(error, element) { {
      error.insertAfter(element)}
  }
});

function companymanageShow(type,ID_Company =null){
  var title = "";

  /* clear old form value */
  $('#form_companymanage')[0].reset();

  switch(type) {
    case 'create':
      title = "สร้างบริษัทลูกค้า";

      $('#div_idcompany').show();

      // set id
      $('#button_companymanageModal').attr("data-id" , null);
      break;
    case 'edit':
      title = "เเก้ไขบริษัทลูกค้า ";
      //clear error if exists
      form_validte.resetForm();

      $.ajax({
        url: "index.php?controller=Company&action=findbyID",
        data: {
          "ID_Company" : ID_Company
        },
        type: "POST",
        dataType: 'json',
        async:false,
        success: function(response, status) {
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
          // set id
          $('#button_companymanageModal').attr("data-id" , ID_Company);
        },
        error: function(xhr, status, exception) {
          //console.log(xhr);
        }
      });


      break;
    default:
      // ..
      break;
  }

  /* set title */
  $('#companymanageTitle').html(title);

  /* set button event  */
  $('#button_companymanageModal').attr("data-status" , type);

  /* modal show  */
  $('#companymanageModal').modal('show');
}
function onaction_deletecompany(ID_Company){
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
          "ID_Company" : ID_Company
        },
        type: "POST",
        dataType: 'json',
        async:false,
        success: function(data, status) {
          if(data.status == true){
            Swal.fire(
              'ลบเรียบร้อย!',
              'ข้อมูลคุณถูกลบเรียบร้อยเเล้ว',
              'success'
            ).then((result) => {
              location.reload();

            });
          }

        },
        error: function(xhr, status, exception) {
          //console.log(xhr);
        }
      });

    }
  })
}

$("#button_importcompanyModal").on('click', function(event) {
  var form_importexcel = $('#form_importexcel')[0];
  var formData_importexcel = new FormData(form_importexcel);
  var url_string  =  "index.php?controller=Company&action=import_excel";
  if($('#form_importexcel input[type=file]').val() != ''){
    $.ajax({
      type: "POST",
      url:  url_string,
      processData: false,
      contentType: false,
      data: formData_importexcel,
      success: function(res,status,xhr){
        console.log(res);
        var data = JSON.parse(res);
        console.log(data);
        if(data.status == true){
          Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
          }).then((result) => {
            location.reload();

          });
        }else{
          Swal.fire({
            icon: 'error',
            title: 'ขออภัย...',
            text: data.message,
          }).then((result) => {
            location.reload();

          });
        }

      }
    });

  }else{
    // error handle
    Swal.fire({
      icon: 'error',
      title: 'ขออภัย...',
      text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
    }).then((result) => {
      return;

    });
  }

});

function onaction_createorupdate(ID_Company = null){

  var type = $('#button_companymanageModal').attr("data-status");

  var form = $('#form_companymanage')[0];
  var formData = new FormData(form);

  switch(type) {
    case 'create':
      var url_string  =  "index.php?controller=Company&action=create_company";
      if (!$("#form_companymanage").validate().form()) {
        Swal.fire({
          icon: 'error',
          title: 'ขออภัย...',
          text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
        }).then((result) => {
          return;

        });
      }else{
        $.ajax({
          type: "POST",
          url:  url_string,
          data: formData,
          processData: false,
          contentType: false,
          success: function(data,status,xhr){
            var data = JSON.parse(data);
            if(data.status == true){
              Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
              }).then((result) => {
                location.reload();

              });
            }else{
              Swal.fire({
                icon: 'error',
                title: 'ขออภัย...',
                text: 'มีบางอย่างผิดพลาด , อาจจะมีข้อมูลอยู่ในฐานข้อมูลเเล้ว , โปรดลองอีกครั้ง',
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

      var url_string  =  "index.php?controller=Company&action=edit_company&ID_Company=" + ID_Company;
      if (!$("#form_companymanage").validate().form()) {
        Swal.fire({
          icon: 'error',
          title: 'ขออภัย...',
          text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
        }).then((result) => {
          return;

        });
      }else{
        $.ajax({
          type: "POST",
          url:  url_string,
          data: formData,
          processData: false,
          contentType: false,
          success: function(data,status,xhr){
            var data = JSON.parse(data);
            console.log(data);
            if(data.status == true){
              Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
              }).then((result) => {
                location.reload();

              });
            }else{
              Swal.fire({
                icon: 'error',
                title: 'ขออภัย...',
                text: 'มีบางอย่างผิดพลาด',
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


function importShow(){

  /* modal show  */
  $('#importcompanyModal').modal('show');

}
