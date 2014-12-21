$(function($){

    $('.form-anti-bot, .form-anti-bot-2').hide(); // hide inputs from users
    var answer = $('.form-anti-bot input#anti-bot-a').val(); // get answer
    $('.form-anti-bot input#anti-bot-q').val( answer ); // set answer into other input

    if ( $('form input#anti-bot-q').length == 0 ) {
        var current_date = new Date();
        var current_year = current_date.getFullYear();
        $('form').append('<input type="hidden" name="anti-bot-q" id="anti-bot-q" value="'+current_year+'" />'); // add whole input with answer via javascript to form
    }

});