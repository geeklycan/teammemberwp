;
(function($){
    $(document).ready(function(){
        $("#teammember_display").hide();
        if("template-team.php"==$("#page_template").val())
            $("#teammember_display").show();

        $("#page_template").on("change",function(){
            var temp = $(this).val();
            if("template-team.php"==temp){
                $("#teammember_display").show();
            }else{
                $("#teammember_display").hide();
            }

        });

    });
})(jQuery);