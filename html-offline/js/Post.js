var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}

function init(text) {
    function resize () {
        text.style.height = 'auto';
        text.style.height = text.scrollHeight+'px';
    }
    /* 0-timeout to get the already changed text */
    function delayedResize () {
        window.setTimeout(resize, 0);
    }
    observe(text, 'change',  resize);
    observe(text, 'cut',     delayedResize);
    observe(text, 'paste',   delayedResize);
    observe(text, 'drop',    delayedResize);
    observe(text, 'keydown', delayedResize);

    text.focus();
    text.select();
    resize();
}

var Thread = null;
var Page = null;
var NoPerPage = 7;

var getInfo = function(th, pg){
    Thread = th;
    Page = pg;
}

var main = function(){
    $(".tablePosts td").mouseenter(function(){
        var row = $(this).parent().parent().children().index($(this).parent());
        var ebtn = "#editPost" + row;
        var sbtn = "#savePost" + row;
        var textspan = "#textPost" + row;
        var textarea = "#textarea" + row;
        
        $(ebtn).removeClass("notvisible");
        $(ebtn).click(function(){
            $(textarea).removeClass("notvisible");
            $(sbtn).removeClass("notvisible");
            $(textspan).addClass("notvisible");
            $(this).addClass("notvisible");
            
            $(textarea).val($(textspan).text());
            init(document.getElementById("textarea" + row));
        });
        $(sbtn).click(function(){
            var text = $(textarea).val();
            
            $(textarea).addClass("notvisible");
            $(this).addClass("notvisible");
            $(textspan).removeClass("notvisible");
            $(ebtn).removeClass("notvisible");
        
            $.ajax({
                method:'POST',
                url: "../ajax/EditPost.php",
                data:{
                    "Thread":Thread,
                    "Row":row + NoPerPage * (Page - 1),
                    "Text":text
                },
                success: function(result){
                    $(textspan).text(result);
                },
                error: function(err){
                    console.log(err);
                },
            });
        });
        if(!$(sbtn).hasClass("notvisible"))
            $(ebtn).addClass("notvisible");
    });
    $(".tablePosts td").mouseleave(function(){
        var row = $(this).parent().parent().children().index($(this).parent());
        $("#editPost" + row).addClass("notvisible");
    });
};

$(document).ready(main);


