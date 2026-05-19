$(document).ready(function(){
    var width1 = $('.slider-box').css('width');
    width1 = parseInt(width1);
    //console.log(width1);
    $('.slider').css('margin-left', '-400px');
    setInterval(function(){
        var margin = $('.slider').css('margin-left');
        margin = parseInt(margin);
        if(margin == -width1*6){
            margin = -800
            $('.slider').css('margin-left', '-400px');
        }else{
            margin = margin - width1 
        }
        console.log(margin);
        $('.slider').animate({'marginLeft':margin}, 1000)
    },2000);
});
