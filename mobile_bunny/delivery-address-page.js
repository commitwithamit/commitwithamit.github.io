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
    $(".textarea_field").blur(function () {

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
    $("#in_alnumb").on("focus blur", function () {
        $("#con_alnumb").toggleClass("blue-i");
    });
    $("#in_pin").on("focus blur", function () {
        $("#con_pin").toggleClass("blue-i");
    });
    $("#in_address").on("focus blur", function () {
        $("#con_address").toggleClass("blue-i");
    });
    $("#in_city").on("focus blur", function () {
        $("#con_city").toggleClass("blue-i");
    });
    $("#in_state").on("focus blur", function () {
        $("#con_state").toggleClass("blue-i");
    });
    $("select").on("focus blur", function () {
        $("#con_state").toggleClass("blue-i");
    });

    //form validation

    $("input[type=submit]").click(function () {
        //name
        var name = $("#in_name").val();

        if (name == "") {
            $("#con_name").addClass("red-i");
            $("#message_name").show();
            return false;
        } else {
            $("#con_name").removeClass("red-i");
            $("#message_name").hide();
        }

        //number
        var numb = $("#in_numb").val();
        numblength = numb.length;

        if (numb == "") {
            $("#con_numb").addClass("red-i");
            $("#message_numb").show();
            return false;
        } else {
            $("#con_numb").removeClass("red-i");
            $("#message_numb").hide();
        }

        //numb length
        if (numblength !== 10) {
            $("#con_numb").addClass("red-i");
            $("#message_length_numb").show();
            return false;
        } else {
            $("#con_numb").removeClass("red-i");
            $("#message_length_numb").hide();
        }


        //alternate numb length
       // var alnumb=$("#in_alnumb").val();

        //if (alnumb!== 10) {
        //    $("#con_alnumb").addClass("red-i");
        //    $("#message_length_alnumb").show();
        //    return false;
        //} else {
        //    $("#con_alnumb").removeClass("red-i");
        //    $("#message_length_alnumb").hide();
        //}

        //pincode
        var pin = $("#in_pin").val();
        pinlength = pin.length;

        if (pin == "") {
            $("#con_pin").addClass("red-i");
            $("#message_pin").show();
            return false;
        } else {
            $("#con_pin").removeClass("red-i");
            $("#message_pin").hide();
        }

        //pin length
        if (pinlength !== 6) {
            $("#con_pin").addClass("red-i");
            $("#message_length_pin").show();
            return false;
        } else {
            $("#con_pin").removeClass("red-i");
            $("#message_length_pin").hide();
        }

        //address
        var address= $("#in_address").val();

        if(address==""){
            $("#con_address").addClass("red-i");
            $("#message_address").show();
            return false;
        }else{
            $("#con_address").removeClass("red-i");
            $("#message_address").hide();
        }

        //city
        var city= $("#in_city").val();

        if(city==""){
            $("#con_city").addClass("red-i");
            $("#message_city").show();
            return false;
        }else{
            $("#con_city").removeClass("red-i");
            $("#message_city").hide();
        }

        //state
        var state= $("#in_state").val();

        if(state==""){
            $("#con_state").addClass("red-i");
            $("#message_state").show();
            return false;
        }else{
            $("#con_state").removeClass("red-i");
            $("#message_state").hide();
        }
    });

    $("input[type=submit]").click(function () {
        var state= $("#in_state").val();

        if(state!==""){
            $("#con_state").removeClass("red-i");
            $("#message_state").hide();
        }
    });

    //if reset is clicked remove all errors 
    $("input[type=reset]").click(function () {
        $("#con_name, #con_numb, #con_pin,#con_address, #con_city,#con_state").removeClass("red-i");
        $("#message_name, #message_numb, #message_length_numb, #message_pin, #message_length_pin, #message_address, #message_city, #message_state").hide();
    });




});