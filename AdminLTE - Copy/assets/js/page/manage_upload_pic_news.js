

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        alert("nn");
        reader.onload = function (e) {
            $('#thumnails_new_profile')
                .attr('src', e.target.result);
        };
  
        reader.readAsDataURL(input.files[0]);
    }
  }

  


function preview() {

 thumnails_new_profile.src=URL.createObjectURL(event.target.files[0]);
}

function preview2() {

 thumnails_new_profile2.src=URL.createObjectURL(event.target.files[0]);
}

function preview3() {
 thumnails_new_profile3.src=URL.createObjectURL(event.target.files[0]);
}

