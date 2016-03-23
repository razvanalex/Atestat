var main = function(){
    $('.arrow-next').click(function() {
        nextSlide();
        count=0;
    });
    
    $('.arrow-prev').click(function() {
        prevSlide();
        count=0;
    });
    
    $('.SignIn-btn').click(function() {
        $('.SignIn').animate({
            right:"0px"
        }, 1000);
    });
    
    $('.icon-close').click(function() {
        $('.SignIn').animate({
            right:"-285px"
        }, 1000);
    });
    
    $('.FgPss-btn').click(function() {
        $('.FgPss').animate({
            right:"0px"
        }, 1000);
    });
    
    $('.FgPss-close').click(function() {
        $('.FgPss').animate({
            right:"-285px"
        }, 1000);
    });
    
    setInterval(timer, 1000);
};

var nextSlide = function(){
        var currentSlide = $('.active-slide');
        var nextSlide = currentSlide.next();
    
        var currentDot = $('.active-dot');
        var nextDot = currentDot.next();
    
        if(nextDot.length === 0) {
            nextSlide = $('.slide').first();
            nextDot = $('.dot').first();
        }
        
        currentSlide.fadeOut(1000).removeClass('active-slide');
        nextSlide.fadeIn(1000).addClass('active-slide');
    
        currentDot.removeClass('active-dot');
        nextDot.addClass('active-dot');
};

var prevSlide = function(){
        var currentSlide = $('.active-slide');
        var prevSlide = currentSlide.prev();
    
        var currentDot = $('.active-dot');
        var prevDot = currentDot.prev();
     
        if(prevDot.length === 0) {
            prevSlide = $('.slide').last();
            prevDot = $('.dot').last();
        }
        
        currentSlide.fadeOut(1000).removeClass('active-slide');
        prevSlide.fadeIn(1000).addClass('active-slide');
    
        currentDot.removeClass('active-dot');
        prevDot.addClass('active-dot');
};

 var count = 0;
 var timer = function(){
    count++;
    if(count === 5)
    {
       nextSlide();
       count=0;
    }
 };
  

$(document).scroll(function () {
    var TScroll = $(document).scrollTop();
    var MenuBAR = $(".menu-bkg");
   // console.log((MenuBAR.height() - TScroll)/MenuBAR.height());
    if (TScroll >= 0 && TScroll < MenuBAR.height())
        MenuBAR.css("opacity", TScroll/MenuBAR.height());
    else if (TScroll > MenuBAR.height())
        MenuBAR.css("opacity", "1");
});
  
$(document).ready(main);