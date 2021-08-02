var columns = [
  {"width": "5%", "class": "text-center"},
  {"width": "10%", "class": "text-center"},
  {"width": "20%", "class": "text-center"},


]

var dataTable_ = $('#tbl_clustershopmanagement').DataTable({
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

var form_validte = $("#form_clustershopmanage").validate({
  rules: {
    Cluster_Shop_ID: {
      //required: true,
    },
    Cluster_Shop_Name: {
      required: true,
      minlength: 3
    },
    action: "required"
  },
  messages: {
    Cluster_Shop_ID: {
      // required: "กรุณาใส่ข้อมูล",
    },
    Cluster_Shop_Name: {
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

function clustershopmanageShow(type, Cluster_Shop_ID = null) {
  var title = "";

  /* clear old form value */
  $('#form_clustershopmanage')[0].reset();

  switch (type) {
    case 'create':
      title = "สร้างกลุ่มลูกค้า";

      $('#div_idclustershop').show();

      // set id
      $('#button_clustershopmanageModal').attr("data-id", null);
      break;
    case 'edit':
      title = "เเก้ไขกลุ่มลูกค้า";
      //clear error if exists
      form_validte.resetForm();

      $.ajax({
        url: "index.php?controller=ClusterShop&action=findbyCluster_Shop_ID",
        data: {
          "Cluster_Shop_ID": Cluster_Shop_ID
        },
        type: "POST",
        dataType: 'json',
        async: false,
        success: function (response, status) {
          /* set input value */
          $('#div_idclustershop').hide();
          console.log(response);
          $('#Cluster_Shop_ID').val(response.data.Cluster_Shop_ID);
          $('#Cluster_Shop_Name').val(response.data.Cluster_Shop_Name);


          // set id
          $('#button_clustershopmanageModal').attr("data-id", Cluster_Shop_ID);
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
  $('#clustershopmanageTitle').html(title);

  /* set button event  */
  $('#button_clustershopmanageModal').attr("data-status", type);

  /* modal show  */
  $('#clustershopmanageModal').modal('show');
}
function onaction_deleteclustershop(Cluster_Shop_ID) {
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
        url: "index.php?controller=ClusterShop&action=delete_cluster_shop",
        data: {
          "Cluster_Shop_ID": Cluster_Shop_ID
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
function onaction_createorupdate(Cluster_Shop_ID = null) {

  var type = $('#button_clustershopmanageModal').attr("data-status");

  var form = $('#form_clustershopmanage')[0];
  var formData = new FormData(form);

  switch (type) {
    case 'create':
      var url_string = "index.php?controller=ClusterShop&action=create_cluster_shop";
      if (!$("#form_clustershopmanage").validate().form()) {
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
      var Cluster_Shop_ID = $("#button_clustershopmanageModal").attr("data-id");

      var url_string = "index.php?controller=ClusterShop&action=edit_cluster_shop&Cluster_Shop_ID=" + Cluster_Shop_ID;
      if (!$("#form_clustershopmanage").validate().form()) {
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



