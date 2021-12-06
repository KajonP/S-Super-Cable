var columns = [
  {"width": "25%", "class": "text-center"},
  {"width": "50%", "class": "text-center"},
  {"width": "25%", "class": "text-center"},

]

var dataTable_ = $('#tbl_setting_vat').DataTable({
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

var form_validte = $("#form_setting_vatmanage").validate({
  rules: {
    ID_Setting_Vat: {

    },
    Percent_Vat: {
      required: true,
    },
    Date_Setting: {

    },
    action: "required"
  },
  messages: {
    ID_Setting_Vat: {

    },
    Name_Promotion: {
      required: "กรุณาใส่ข้อมูล",
    },
    Date_Setting: {

    },
    action: "กรุณาใส่ข้อมูล"
  }, errorPlacement: function (error, element) {
    {
      error.insertAfter(element)
    }
  }
});

function setting_vatmanageShow(type, ID_Setting_Vat = null) {
  var title = "";

  /* clear old form value */
  $('#form_setting_vatmanage')[0].reset();

  switch (type) {
    case 'edit':
      title = "เเก้ไขอัตราภาษีมูลค่าเพิ่ม";
      //clear error if exists
      form_validte.resetForm();

      $.ajax({
        url: "index.php?controller=SettingVat&action=findbyID",
        data: {
          "ID_Setting_Vat": ID_Setting_Vat
        },
        type: "POST",
        dataType: 'json',
        async: false,
        success: function (response, status) {
          /* set input value */
          $('#div_idsetting_vat').hide();
          console.log(response);
          $('#ID_Setting_Vat').val(response.data.ID_Setting_Vat);
          $('#Percent_Vat').val(response.data.Percent_Vat);
          $('#Date_Setting').val(response.data.Date_Setting);

          // set id
          $('#button_setting_vatmanageModal').attr("data-id", ID_Setting_Vat);
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
  $('#setting_vatmanageTitle').html(title);

  /* set button event  */
  $('#button_setting_vatmanageModal').attr("data-status", type);

  /* modal show  */
  $('#setting_vatmanageModal').modal('show');
}
function onaction_createorupdate(ID_Setting_Vat = null) {

  var type = $('#button_setting_vatmanageModal').attr("data-status");

  var form = $('#form_setting_vatmanage')[0];
  var formData = new FormData(form);
  switch (type) {
    case 'edit':
      var ID_Setting_Vat = $("#button_setting_vatmanageModal").attr("data-id");

      var url_string = "index.php?controller=SettingVat&action=edit_setting_vat&ID_Setting_Vat=" + ID_Setting_Vat;
      if (!$("#form_setting_vatmanage").validate().form()) {
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



