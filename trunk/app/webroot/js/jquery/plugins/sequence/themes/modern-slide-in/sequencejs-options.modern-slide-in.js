$(document).ready(function(){
    var options = {
        nextButton: true,
        prevButton: true,
        animateStartingFrameIn: true,
        autoPlay: true,
    };
    
    var mySequence = $("#sequence").sequence(options).data("sequence");
});