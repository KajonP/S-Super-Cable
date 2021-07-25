var columns = [
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

function onAction_downloadFile(ID_File) {

  download_file(ID_File);
}

function download_file(ID_File)
{
  Swal.fire({
    title: 'คุณเเน่ใจใช่ไหม?',
    text: "คุณต้องการดาวน์โหลดข้อมูลนี้ใช่ไหม?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ตกลง',
    cancelButtonText: 'ยกเลิก'

  }).then((result) => {
    if (result.isConfirmed) {
      //alert("index.php?controller=File&action=download_file&ID_File=" + ID_File);
      window.location = "index.php?controller=File&action=download_file&ID_File=" + ID_File;
      /*
      $.ajax({
        type: "POST",
        url: "index.php?controller=File&action=download_file&ID_File=" + ID_File,
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
      */
    }
  })
}
