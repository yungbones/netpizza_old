$(document).ready(function() {
    $(window).on("resize", function() {
        resizeCaptcha();
    });
    resizeCaptcha();

	$("#login-form").validate({
        submitHandler: submitForm
    });

    function submitForm() {
        var data = $("#login-form").serialize();

        $.ajax({
            type: "POST",
            url: "misc/login.php",
            data: data,

            success: function(data) {
                console.log(data);

                if (data == "captcha")
                    $.notify("Az azonosítás nem sikerült (captcha error)", "warning");
	            else if (data == "phone")
	            	$.notify("Hibás telefonszám", "error");
	            else if (data == "pw")
	            	$.notify("Hibás telefonszám és jelszó kombináció", "error");
	            else if (data == "logged")
	            	$.notify({
                        message: "Sikeresen bejelentkeztél",
                        status: "success",
                        timeout: 2000,
                        onClose: function() {
                            location.reload()
                        }
                    });
	        }
      	});
        
        return false;
    }

    $("#logout").click(function() {        
        $.ajax({
            type: "POST",
            url: "misc/logout.php",
            data: "log out",

            success: function(data) {
                if (data == "success")
                    $.notify({
                        message: "Sikeresen kijelentkeztél",
                        status: "success",
                        timeout: 2000,
                        onClose: function() {
                            location.href = "http://lovaszbence.nhely.hu"
                        }
                    });
            }
        });

        return false;
    })
});

function resizeCaptcha() {
    var width = $(".g-recaptcha").parent().width();
    //alert(width);

    scale = width < 302 ? width / 302 : 1;

    $(".g-recaptcha").css("transform", "scale(" + scale + ")");
    $(".g-recaptcha").css("-webkit-transform", "scale(" + scale + ")");
    $(".g-recaptcha").css("transform-origin", "0 0");
    $(".g-recaptcha").css("-webkit-transform-origin", "0 0");
};