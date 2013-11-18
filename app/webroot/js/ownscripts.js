function displayError()
{
  $('.display_error').text('Your form is invalid. Correct inputs.').animate({
                    opacity: 1
               }, 500, function() {
                    $(this).animate({
                        opacity: 0,
                    }, 2000, function() {
                        $(this).text("");
                    });
              });
};