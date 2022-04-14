(function($) {

	"use strict";

	$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

})(jQuery);

function showProfileDialogueBox(event){
    event.preventDefault();
    $("#profilepic").click();
}
$(document).ready(function () {
    $('#profilepic').change(function () {
        $('#profilepic-img').attr('src', URL.createObjectURL(this.files[0]));
    });
    $('[data-toggle="tooltip"]').tooltip();
});
