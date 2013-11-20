function validpriority()
{
    if(!($('#priority_1').val() == '' && $('#priority_2').val() == '' && $('#priority_3').val() == ''))
    {
        if(!($('#priority_1').val() != '' && $('#priority_2').val() != '' && $('#priority_3').val() != ''))
        {
            displayMessage('Some priorities in first day are not set.');
            return false;
        }
    }
    if(!($('#priority_4').val() == '' && $('#priority_5').val() == '' && $('#priority_6').val() == ''))
    {
        if(!($('#priority_4').val() != '' && $('#priority_5').val() != '' && $('#priority_6').val() != ''))
        {
            displayMessage('Some priorities in second day are not set.');
            return false;
        }
    }
    if(!($('#priority_7').val() == '' && $('#priority_8').val() == '' && $('#priority_9').val() == ''))
    {
        if(!($('#priority_7').val() != '' && $('#priority_8').val() != '' && $('#priority_9').val() != ''))
        {
            displayMessage('Some priorities in third day are not set.');
            return false;
        }
    }

    
    if(($('#priority_1').val() == $('#priority_2').val() || $('#priority_1').val() == $('#priority_3').val() || $('#priority_2').val() == $('#priority_3').val()) && ($('#priority_1').val() != '' || $('#priority_2').val() != '' || $('#priority_3').val() != ''))
    {
        displayMessage('Each activity in first day must have other values.');
        return false;
    }
    if(($('#priority_4').val() == $('#priority_5').val() || $('#priority_4').val() == $('#priority_6').val() || $('#priority_5').val() == $('#priority_6').val()) && ($('#priority_4').val() != '' || $('#priority_5').val() != '' || $('#priority_6').val() != ''))
    {
        displayMessage('Each activity in second day must have other values.');
        return false;
    }
    if(($('#priority_7').val() == $('#priority_8').val() || $('#priority_7').val() == $('#priority_9').val() || $('#priority_8').val() == $('#priority_9').val()) && ($('#priority_7').val() != '' || $('#priority_8').val() != '' || $('#priority_9').val() != ''))
    {
        displayMessage('Each activity in third day must have other values.');
        return false;
    }
}

function validmaterial()
{

    for(var i=0; i<5; i++)
    {
        var value = $('.material_'+i).val();
        if(value == '' || !$.isNumeric(value) )
        {
            $('.material_'+i).val('0');
        }
    }
}

function aremorestudents()
{
    $('div.participants').css('display', 'block');
    $('#participants').text('Hide participants');
}

function displayMessage(message)
{
    $("html, body").animate({ scrollTop: 0 }, "fast");
    $('.display_error').text(message).animate({
        opacity: 1
        }, 500, function() {
        $(this).animate({
            opacity: 0,
        }, 2000, function() {
            $(this).text("");
        });
    });
}