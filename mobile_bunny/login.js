$(document).ready(function () {

    //floating label effect
    //when input box has some text inside it the floating label won't
    //return to it's original place as a placeholder
    $(".inp_container .input_field").blur(function () {

        var input = $(this).val();

        if (input !== "") {
            $(this).siblings("label").addClass("active");
        } else {
            $(this).siblings("label").removeClass("active");
        }

    });


    //color change on focus & blur of input boxes
    $("#email_mobile").on("focus blur", function () {
        $("#con_e_mob").toggleClass("blue-i");
    });
    $("#pass").on("focus blur", function () {
        $("#con_pass").toggleClass("blue-i");
    });

    //form validation
    $("input[type=submit]").click(function () { 

        var em=$("#email_mobile") .val();
        var pw=$("#pass") .val();

        if(em== ""){
            $("#con_e_mob").addClass("red-i");
            $("#message_em").show();
            return false;
        }else{
            $("#con_e_mob").removeClass("red-i");
            $("#message_em").hide();
        }

        if(pw== ""){
            $("#con_pass").addClass("red-i");
            $("#message_pass").show();
            return false;
        }
 
    });

    //this wasn't working inside the else condition for password in the
    //code above so i wrote it seprately
    $("input[type=submit]").click(function () { 
        var yo=$("#pass").val();

        if(yo!==""){
            $("#con_pass").removeClass("red-i");
            $("#message_pass").hide();
        }
    });

});