var columns = [
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
  {"width": "5%", "class": "text-center"},
]

var dataTable_ = $("#tbl_invoicemanagement").DataTable({
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

function invoicemanageShow(type, ID_Message ) {
  
  var title = "" ;

  /* clear old form value */
 

    switch(type)
    {
      case "create":
        title = "สร้าง Invoice";

        // set id
        $('#button_invManageModal').attr("data-id", null);

        //
        //form_validte.resetForm();

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
      case 'view':
      title = "ดูข่าวสาร ";
      //clear error if exists
      form_validte.resetForm();

      get_news_to_view(ID_Message);


      //$('#form_companymanage input').attr('readonly', 'readonly');
      //$('#form_companymanage select').attr("disabled", true);
      //$('#button_companymanageModal').hide();

      break;
      default:
        // ..
        break;
    }

    /* set title */
    $('#invManageTitle').html(title);

    /* set button event  */
    $('#button_invManageModal').attr("data-status", type);

    /* modal show  */
    if(type=='view'){
      $('#invManageViewModal').modal('show')
    }else{
      $('#invManageModal').modal('show');
    }
  }

