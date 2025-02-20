$(document).ready(function () {

    console.log("Login js is loaded");



})

let baseUrl = $("#baseUrl").val();

function loginMe() {

    $(".error").text("");

    let checkForm = 1;

    $("#loginForm input").each(function () {
        if ($(this).val() == "") {
            $(this).parent('.mb-3').find(".error").text('Field is required');
            checkForm = 0;
        }
    })

    if(checkForm == 1){

        let formData = new FormData(loginForm);

        $(".alert").addClass("d-none");
        
        $.ajax({

            url: baseUrl+"loginController/success",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                if(data == 1){
                    $(".alert-success").removeClass("d-none")
                    $(".alert-success").text("Login successfully!")
                    $("#loginForm").trigger("reset");
                    window.location.href= baseUrl+"pagescontroller/sessionControl";
                }
                else if(data == 0){
                    $(".alert-danger").removeClass("d-none")
                    $(".alert-danger").text("Details are wrong") 
                }
                else if(data == 11){
                    $("#loginForm input").each(function () {
                        if ($(this).val() == "") {
                            $(this).parent('.mb-3').find(".error").text('Field is required');
                        }
                    })
                }
            }

        })

    }




}


