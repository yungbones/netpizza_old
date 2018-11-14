$(document).ready(function() {
	$(".btn").click(function() {
		if ($(this).hasClass("start-btn")) {
			var btn = $(this);
			var sended = $.parseJSON('{"id": ' + btn.data("holder") + ', "newvalue": 1}');

	        $.ajax({
	            type: "POST",
	            url: "misc/backdoor-update.php",
	            data: sended,

	            success: function(data) {
	                if (data == "failed")
	                	$.notify("Hiba", "error");
	                else if (data == "updated")
	                	btn.html("<i class='fas fa-hourglass-end'></i> Futár megérkezett").removeClass("btn-success").addClass("btn-warning").removeClass("start-btn").addClass("finish-btn");
		        }
	      	});
	        
	        return false;
		}
		else if ($(this).hasClass("finish-btn")) {
			var btn = $(this);
			var sended = $.parseJSON('{"id": ' + btn.data("holder") + ', "newvalue": 2}');

	        $.ajax({
	            type: "POST",
	            url: "misc/backdoor-update.php",
	            data: sended,

	            success: function(data) {            	
	                if (data == "failed")
	                	$.notify("Hiba", "error");
	                else if (data == "updated") {
	                	btn.replaceWith("<button data-holder='" + sended["id"] + "' class='btn btn-dark' disabled><i class='fas fa-check-circle'></i> Rendelés teljesítve</button>");
	                	$("#remove-" + sended["id"]).remove();
	                }
		        }
	      	});
	        
	        return false;
		}
		else if ($(this).hasClass("delete-btn")) {
			var btn = $(this);
			var sended = $.parseJSON('{"id": ' + btn.data("holder") + ', "newvalue": 3}');

			$.ajax({
				type: "POST",
				url: "misc/backdoor-update.php",
				data: sended,

				success: function(data) {
					if (data == "failed")
						$.notify("Hiba", "error");
					else if (data == "updated") {
						for (var i = 0; i < $(".btn").length; i++)
							if (($(".btn")[i].classList.contains("start-btn") || $(".btn")[i].classList.contains("finish-btn")) && $(".btn")[i].getAttribute("data-holder") == sended["id"])
								$(".btn")[i].remove();

						$("#br-" + sended["id"]).remove();

						btn.replaceWith("<button data-holder='" + sended["id"] + "' class='btn btn-secondary' disabled><i class='fas fa-exclamation-circle'></i> Rendelés törölve</button>");
					}
				}
			});

			return false;
		}
	});

	$(".list-group-item").click(function() {
		if ($(this).data("holder") == "exit") {
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
	                            location.reload()
	                        }
	                    });
				}
			});

			return false;
		}
		else {
			$(".list-group-item").removeClass("li-active");
			$(this).addClass("li-active");

			$(".container .col-md-9").css("display", "none");
			$(".container ." + $(this).data("holder")).css("display", "block");
		}
	})

	$(".loginbtn").click(function() {
		$.ajax({
			type: "POST",
			url: "misc/backdoor-login.php",
			data: {password: $("#password").val()},

			success: function(data) {
				if (data == "logged")
					$.notify({
                        message: "Sikeresen bejelentkeztél",
                        status: "success",
                        timeout: 2000,
                        onClose: function() {
                            location.reload()
                        }
                    });
				else if (data == "pw")
					$.notify("Hibás jelszó", "error");
			}
		});

		return false;
	})

	/* setInterval(loadOrders, 1000);

	function loadOrders() {
		$("#accordion").load("../misc/backdoor-load.php");
	} */
});