

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    alert("nn");
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
function preview2() {

  thumnails_award_pic2.src=URL.createObjectURL(event.target.files[0]);
}

function preview3() {
  thumnails_award_pic3.src=URL.createObjectURL(event.target.files[0]);
}
