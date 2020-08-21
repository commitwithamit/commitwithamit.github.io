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
    $("#in_name").on("focus blur", function () {
        $("#con_name").toggleClass("blue-i");
    });
    $("#in_numb").on("focus blur", function () {
        $("#con_numb").toggleClass("blue-i");
    });
    $("#in_mail").on("focus blur", function () {
        $("#con_mail").toggleClass("blue-i");
    });
    $("#in_pass").on("focus blur", function () {
        $("#con_pass").toggleClass("blue-i");
    });
    $("#in_cpass").on("focus blur", function () {
        $("#con_cpass").toggleClass("blue-i");
    });


    //form validation
    $("input[type=submit]").click(function () { 

        var name=$("#in_name") .val();
        var number=$("#in_numb") .val();
            moblength=number.length;
        var pass=$("#in_pass") .val();
            passlength=pass.length;
        var conpass=$("#in_cpass") .val();

        if(name== ""){
            $("#con_name").addClass("red-i");
            $("#message_name").show();
            return false;
        }else{
            $("#con_name").removeClass("red-i");
            $("#message_name").hide();
        }

        if(number== ""){
            $("#con_numb").addClass("red-i");
            $("#message_numb").show();
            return false;
        }else{
            $("#con_numb").removeClass("red-i");
            $("#message_numb").hide();
        }

        if(moblength!==10){
            $("#con_numb").addClass("red-i");
            $("#message_numb_length").show();
            return false;
        }else{
            $("#con_numb").removeClass("red-i");
            $("#message_numb_length").hide();
        }

        if(pass== ""){
            $("#con_pass").addClass("red-i");
            $("#message_pass").show();
            return false;
        }else{
            $("#con_pass").removeClass("red-i");
            $("#message_pass").hide();
        }

        if(passlength < 8){
            $("#con_pass").addClass("red-i");
            $("#message_pass_length").show();
            return false;
        }else{
            $("#con_pass").removeClass("red-i");
            $("#message_pass_length").hide();
        }

        if(conpass== ""){
            $("#con_cpass").addClass("red-i");
            $("#message_cpass").show();
            //below code will hide the pass does't match
            //error if it already open when conpass is left blank
            $("#message_cpass_match").hide();
            return false;
        }else{
            $("#con_cpass").removeClass("red-i");
            $("#message_cpass").hide();
        }

        if(pass!=conpass){
            $("#con_cpass").addClass("red-i");
            $("#message_cpass_match").show();
            return false;
        }else{
            $("#con_cpass").removeClass("red-i");
            $("#message_cpass_match").hide();
        }

    });
});