var columns = [
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-right"},
  {"width": "5%", "class": "text-right"},
  {"width": "5%", "class": "text-center"},

]

var dataTable_ = $('#tbl_promotionmanagement').DataTable({
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

var form_validte = $("#form_promotionmanage").validate({
  rules: {
    ID_Promotion: {

    },
    Name_Promotion: {
      required: true,
    },
    Unit_Promotion: {
      required: true,
    },
    Price_Unit_Promotion: {
      required: true,
    },
    Have_To_Return: {
      required: true,
    },
    action: "required"
  },
  messages: {
    ID_Promotion: {

    },
    Name_Promotion: {
      required: "กรุณาใส่ข้อมูล",
    },
    Unit_Promotion: {
      required: "กรุณาใส่ข้อมูล",
    },
    Price_Unit_Promotion: {
      required: "กรุณาใส่ข้อมูล",
    },
    Have_To_Return: {
      required: "กรุณาใส่ข้อมูล",
    },
    action: "กรุณาใส่ข้อมูล"
  }, errorPlacement: function (error, element) {
    {
      error.insertAfter(element)
    }
  }
});

function promotionmanageShow(type, ID_Promotion = null) {
  var title = "";

  /* clear old form value */
  $('#form_promotionmanage')[0].reset();

  switch (type) {
    case 'create':
      title = "สร้างสินค้าส่งเสริมการขาย";

      $('#div_idpromotion').show();

      // set id
      $('#button_promotionmanageModal').attr("data-id", null);
      break;
    case 'edit':
      title = "เเก้ไขสินค้าส่งเสริมการขาย";
      //clear error if exists
      form_validte.resetForm();

      $.ajax({
        url: "index.php?controller=Promotion&action=findbyID_Promotion",
        data: {
          "ID_Promotion": ID_Promotion
        },
        type: "POST",
        dataType: 'json',
        async: false,
        success: function (response, status) {
          /* set input value */
          $('#div_idpromotion').hide();
          console.log(response);
          $('#ID_Promotion').val(response.data.ID_Promotion);
          $('#Name_Promotion').val(response.data.Name_Promotion);
          $('#Unit_Promotion').val(response.data.Unit_Promotion);
          $('#Price_Unit_Promotion').val(response.data.Price_Unit_Promotion);
          // case: dropdown
          /*
          $('#Have_To_Return')
            .val(response.data.Have_To_Return)
            .trigger('change');
          */
         
           $('#Have_To_Return')
            .val(response.data.Have_To_Return);
          // set id
          $('#button_promotionmanageModal').attr("data-id", ID_Promotion);
        },
        error: function (xhr, status, exception) {
          //console.log(xhr);
        }
      });


      break;
    default:
      // ..
      break;
  }

  /* set title */
  $('#promotionmanageTitle').html(title);

  /* set button event  */
  $('#button_promotionmanageModal').attr("data-status", type);

  /* modal show  */
  $('#promotionmanageModal').modal('show');
}

function onaction_deletepromotion(ID_Promotion) {
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
        url: "index.php?controller=Promotion&action=delete_promotion",
        data: {
          "ID_Promotion": ID_Promotion
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
function onaction_createorupdate(ID_Promotion = null) {

  var type = $('#button_promotionmanageModal').attr("data-status");

  var form = $('#form_promotionmanage')[0];
  var formData = new FormData(form);

  switch (type) {
    case 'create':
      var url_string = "index.php?controller=Promotion&action=create_promotion";
      if (!$("#form_promotionmanage").validate().form()) {
        Swal.fire({
          icon: 'error',
          title: 'ขออภัย...',
          text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง',
          confirmButtonText: 'ตกลง',
        }).then((result) => {
          return;

        });
      } else {
        console.log(formData);
        $.ajax({
          type: "POST",
          url: url_string,
          data: formData,
          processData: false,
          contentType: false,
          success: function (res, status, xhr) {
            var data = JSON.parse(res);
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
      var ID_Promotion = $("#button_promotionmanageModal").attr("data-id");

      var url_string = "index.php?controller=Promotion&action=edit_promotion&ID_Promotion=" + ID_Promotion;
      if (!$("#form_promotionmanage").validate().form()) {
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
  $('#importpromotionModal').modal('show');

}
