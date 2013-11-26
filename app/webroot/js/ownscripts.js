function displayError(error)
{
    if(error == '')
    {
        error = 'Your form is invalid. Correct inputs.';
    }
  $("html, body").animate({ scrollTop: 0 }, "fast");
  $('.display_error').text(error).animate({
                    opacity: 1
               }, 500, function() {
                    $(this).animate({
                        opacity: 0,
                    }, 2000, function() {
                        $(this).text("");
                    });
              });
};