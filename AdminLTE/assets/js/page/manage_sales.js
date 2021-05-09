var columns = [
  { "width": "1%" , "class": "text-left"},
  { "width": "5%" , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-center"},
  { "width": "5%"  , "class": "text-right"},
  { "width": "5%"  , "class": "text-center"},

]

var dataTable_ = $('#tbl_salesmanagement').DataTable( {
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

var form_validte = $("#form_salesmanage").validate({
  rules: {
    ID_Excel: {
      //required: true,
    },
    Date_Sales: {
      required: true,
    },
    ID_Company: {
      required: true,
     // minlength: 3
    },
    ID_Employee: {
      required: true,
    },
    Result_Sales: {
      required: true,
    },
    action: "required"
  },
  messages: {
    ID_Excel: {
     // required: "กรุณาใส่ข้อมูล",
    },
    Date_Sales: {
      required: "กรุณาใส่ข้อมูล",
    },
    ID_Company: {
      required: "กรุณาใส่ข้อมูล",
      //minlength: "ข้อมูลต้องมีอย่าง 3 ตัวอักษร"
    },
    ID_Employee: {
      required: "กรุณาใส่ข้อมูล",
    },
    Result_Sales: {
      required: "กรุณาใส่ข้อมูล",
    },
    action: "กรุณาใส่ข้อมูล"
  },errorPlacement: function(error, element) { {
    error.insertAfter(element)}
  }
});

function salesmanageShow(type,ID_Excel =null){
  var title = "";

  /* clear old form value */
  $('#form_salesmanage')[0].reset();

  switch(type) {
    case 'create':
      title = "สร้างยอดขาย";

      $('#div_idsales').show();

      // set id
      $('#button_salesmanageModal').attr("data-id" , null);
      break;
    case 'edit':
      title = "เเก่ไขยอดขาย";
      //clear error if exists
      form_validte.resetForm();

      $.ajax({
        url: "index.php?controller=Sales&action=findbyID",
        data: {
          "ID_Excel" : ID_Excel
        },
        type: "POST",
        dataType: 'json',
        async:false,
        success: function(response, status) {
          /* set input value */
          $('#div_idsales').hide();

          $('#ID_Excel').val(response.data.ID_Excel);
          $('#Date_Sales').val(response.data.Date_Sales);
          $('#ID_Company').val(response.data.ID_Company);
          $("#ID_Employee").val(response.data.ID_Employee);
          $('#Result_Sales').val(response.data.Result_Sales);

          // set id
          $('#button_salesmanageModal').attr("data-id" , ID_Excel);
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
  $('#salesmanageTitle').html(title);

  /* set button event  */
  $('#button_salesmanageModal').attr("data-status" , type);

  /* modal show  */
  $('#salesmanageModal').modal('show');
}
function onaction_deletesales(ID_Excel){
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
        url: "index.php?controller=Sales&action=delete_sales",
        data: {
          "ID_Excel" : ID_Excel
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

$("#button_importsalesModal").on('click', function(event) {
  var form_importexcel = $('#form_importexcel')[0];
  var formData_importexcel = new FormData(form_importexcel);
  var url_string  =  "index.php?controller=Sales&action=import_excel";
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

function onaction_createorupdate(ID_Excel = null){ //มันมาเข้า method นี้

  var type = $('#button_salesmanageModal').attr("data-status");

  var form = $('#form_salesmanage')[0];
  var formData = new FormData(form);

  switch(type) {
    case 'create':
      var url_string  =  "index.php?controller=Sales&action=create_sales";
      if (!$("#form_salesmanage").validate().form()) {
        Swal.fire({
          icon: 'error',
          title: 'ขออภัย...',
          text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
        }).then((result) => {
          return;

        });
      }else{
        console.log(formData);
        $.ajax({
          type: "POST",
          url:  url_string,
          data: formData,
          processData: false,
          contentType: false,
          success: function(res,status,xhr){
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
      var ID_Excel = $("#button_salesmanageModal").attr("data-id");

      var url_string  =  "index.php?controller=Sales&action=edit_sales&ID_Excel=" + ID_Excel;
      if (!$("#form_salesmanage").validate().form()) {
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
  $('#importsalesModal').modal('show');

}
