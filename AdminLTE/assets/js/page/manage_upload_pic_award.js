



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
  
        reader.onload = function (e) {
            $('#thumnails_award_pic')
                .attr('src', e.target.result);
        };
  
        reader.readAsDataURL(input.files[0]);
    }
  }

  


  function preview() {
    thumnails_award_pic.src=URL.createObjectURL(event.target.files[0]);
 }