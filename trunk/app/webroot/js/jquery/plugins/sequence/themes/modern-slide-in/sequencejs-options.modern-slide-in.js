$(document).ready(function(){
    var options = {
        nextButton: true,
        prevButton: true,
        autoPlay: false,
    };
    
    var mySequence = $("#sequence").sequence(options).data("sequence");
});