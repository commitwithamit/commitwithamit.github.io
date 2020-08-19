$(document).ready(function () {

    //floating label effect
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
        $("#con_e_mob").removeClass("red-i");
    });
    $("#pass").on("focus blur", function () {
        $("#con_pass").toggleClass("blue-i");
        $("#con_pass").removeClass("red-i");
    });

    //form validation
    //1)c-#con_e_mob i-#email_mobile 
    //1)c-#con_pass i-#pass 

    $("input[type=submit]").click(function () { 

        var em=$("#email_mobile") .val();
        var pw=$("#pass") .val();

        if(em== ""){
            alert("Enter your email or mobile number!");
            $("#con_e_mob").addClass("red-i");
            return false;
        }
        if(pw== ""){
            alert("Enter your password!");
            $("#con_pass").addClass("red-i");
            return false;
        }

    });
});