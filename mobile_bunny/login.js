$(document).ready(function () {
    
    $(".inp_container .input_field").blur(function () { 
        
        var input=$(this).val();

        if(input !==""){
            $(this).siblings("label").addClass("active");
        }else{
            $(this).siblings("label").removeClass("active");
        }
        
    });


});