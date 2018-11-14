$(document).ready(function() {
	var myOrder = [];
	var totalPrice = 0;

	var types = ["30 cm", "50 cm"];
	var colors = ["bg-warning", "bg-danger"];

	$(".btn-sm").click(function() {
		//alert($(this).data("holder") + " " + $(this).data("type") + " " + $(this).data("price"));

		self = [];
		self["name"] = $(this).data("holder");
		self["type"] = $(this).data("type");
		self["price"] = $(this).data("price");

		totalPrice += self["price"];

		//alert(self["name"]);

		myOrder.push(self);

		if (myOrder.length == 1)
			$("#orders").empty();
		
		$("#orders").html($("#orders").html() + "<li class='mt-1 ml-0 pl-0'><span class='mr-2 " + colors[self["type"] - 1] + "'>" + types[self["type"] - 1] + "</span><b>" + self["name"] + "</b> - " + numberFormat(self["price"]) + " Ft</li>");
		$("#total").html("Összesen: <b>" + numberFormat(totalPrice) + " Forint</b>");
	});

	$(".clearorders").click(function() {
		myOrder = [];
		totalPrice = 0;

		$("#orders").html("<li>Kosár tartalma jelenleg üres</li>");
		$("#total").html("Összesen: <b>0 Forint</b>");
	});

	$(".completeorder").click(function() {
		if (!$.isEmptyObject(myOrder)) {
			$(".fullscreen").css("display", "block");

			var sended = {};

			for (var i = 0; i < myOrder.length; i++)
				sended[i] = $.parseJSON('{"name": "' + myOrder[i]["name"] + '", "type": ' + myOrder[i]["type"] + ', "price": ' + myOrder[i]["price"] + '}');

			var id = $.parseJSON(getCookie("json_userdata"))["datas"]["id"];
			
			$.ajax({
	            type: "POST",
	            url: "misc/order.php",
	            data: {user: id, order: sended},

	            success: function(data) {  
	                if (data == "success") {
	                	myOrder = [];
						totalPrice = 0;

						$("#orders").html("<li>Kosár tartalma jelenleg üres</li>");
						$("#total").html("Összesen: <b>0 Forint</b>");

	                	$.notify("Rendelésedet sikeresen rögzítettük", "success");

	                	$(".fullscreen").css("display", "none");
	                }
		        }
	      	});
	        
	        return false;
	    }
	});
});

function getCookie(cname) {
    var name = cname + "=";
    var ca = decodeURIComponent(document.cookie).split(';');
    
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);

        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }

    return "";
}

const numberFormat = (x) => {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}