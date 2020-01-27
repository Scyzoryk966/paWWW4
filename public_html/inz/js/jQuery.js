$(document).ready(function(){
    $('.nav-link').click(function(e){
        e.preventDefault();
        var content = $(this)
        $("#dynamic").fadeOut(250, function(){
            $("#dynamic").load(content.attr('href'));
            });
            $("#dynamic").fadeIn(250, function(){
            });
    });
});