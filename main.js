$(document).ready(function() {

	$('#submit').click(function(e){
    	e.preventDefault();
    	var ip = $("#ipaddress").val();
    	var ipv_format = $('input[type="radio"]:checked').val();
        var cidr = $("#cidr").val();
    	$.ajax({
        	type: "POST",
        	url: "result.php",
        	dataType: "json",
        	data: {ip:ip,ipv_format:ipv_format,cidr:cidr},
        	success : function(data){
            	if (data.code == "200"){
                    $(".display-error").html(" ");
                    $(".ip-result").html("<ul>"+data.msg+"</ul>");
                    $(".ip-result").css("display","block");
            	} else {
                    $(".ip-result").html(" ");
                	$(".display-error").html("<ul>"+data.msg+"</ul>");
                	$(".display-error").css("display","block");
            	}
        	}
    	});
  	});
    $("#myForm").validate({
                rules: {
                    ipaddress: {
                        required: true
                    },

                },
                submitHandler: function(form) {
                    console.log("submitting");
                     form.submit();

                 }
      });
})
$(document).ready(function() {
    console.log("validate");
    $("#myForm").validate({
                rules: {
                    ipaddress: {
                        required: true
                    },

                },
                submitHandler: function(form) {
                    console.log("submitting");
                     form.submit();

                 }
      });
})

