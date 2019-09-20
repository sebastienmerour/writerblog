$(document).ready(function() {


    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function(){
        readURL(this);
    });
});


$(document).ready(function() {
    $('#usermodification').on('submit', function(evt) {
          evt.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
    });
});
