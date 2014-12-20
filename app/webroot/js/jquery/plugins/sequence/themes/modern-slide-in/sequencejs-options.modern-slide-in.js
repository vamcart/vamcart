$(document).ready(function(){
    var options = {
        nextButton: true,
        prevButton: true,
        animateStartingFrameIn: true,
        autoPlay: false,
    };
    
    var mySequence = $("#sequence").sequence(options).data("sequence");
});