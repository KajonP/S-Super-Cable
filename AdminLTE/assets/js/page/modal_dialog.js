$('#thumnails_profile').click(function () {


    browsFile("profile", this.id);
   
    
});


function browsFile(files, id){

    $("#"+files).trigger('click');
    $("#"+files).change(function(){
        readURL(this,id);
    });
}


function readURL(input, id) {
    
    //case: อัพโหลดรูป validate ใช่ไฟล์ jpg,png,jpeg,gif ไหม ถ้าไม่ใช่ขึ้นแจ้งเตือน type ไม่ตรง
    if(!$('#form_profile').validate().element('#profile')){
        Swal.fire({
            icon: 'error',
          title: 'ขออภัย...',
          text: 'กรุณาอัพโหลดไฟล์รูปภาพที่มีนามสกุลไฟล์คือ .png , .jpg ,.jpeg ,.gif เท่านั้น',
        }).then((result) => {
            return;

        });
    }

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function editProfile(form_serialize){

    var form = $('#form_profile')[0];
    console.log(form);
    var formData = new FormData(form);
    var url_string  =  "index.php?controller=Employee&action=edit_profile";
    if (!$("#form_profile").validate().form()) {
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
                    text: 'เเก้ไขโปรไฟล์สำเร็จเเล้ว',
                }).then((result) => {
                    //location.reload();

                    window.location.href = "index.php?controller=" +data.role+ "&action=index";
                });
           }else{
                Swal.fire({
                    icon: 'error',
                  title: 'ขออภัย...',
                  text: 'มีบางอย่างผิดพลาด , อาจจะมีข้อมูลอยู่ในฐานข้อมูลเเล้ว , โปรดลองอีกครั้ง',
                }).then((result) => {
                   // location.reload();

                   window.location.href = "index.php?controller=" +data.role+ "&action=index";
                });
           }
        }
    });
    }

}

// show hide password

$("#show_hide_password a").on('click', function(event) {
    event.preventDefault();
    if($('#show_hide_password input').attr("type") == "text"){
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password i').addClass( "fa-eye-slash" );
        $('#show_hide_password i').removeClass( "fa-eye" );
    }else if($('#show_hide_password input').attr("type") == "password"){
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password i').removeClass( "fa-eye-slash" );
        $('#show_hide_password i').addClass( "fa-eye" );
    }
});

