jQuery(document).ready(function($){

	var form;
	var url;
	var redirectUrl;
	var data;
	var submitBtn;
	var msgSuccess;
	var msgError;
	var bv;

    $('#ligamos-para-voce-form, #envie-um-email-form, #ligamos-para-voce-form-rodape, #contrato-form, #consulta-plano-coral-form').bootstrapValidator().on('success.form.bv', function(e) {
        e.preventDefault();

        form = $(this);
        bv = form.data('bootstrapValidator');

		url = form.attr('action');
		redirectUrl = form.attr('data-redirect');
		data = form.serialize();
		submitBtn = form.find('button[type="submit"]');
		msgError = form.find('.msg-erro');

		msgError.hide();
		submitBtn.button('loading');

		$.ajax({
			type: "POST",
			url: url,
			data: data,
			async: true,
			cache: false,
			success: function (output) {
				submitBtn.button('reset');
	            if (output == 1) {
	            	window.location.replace(redirectUrl);
	            } else {
	            	msgError.fadeIn();
	            }
        	}
      	});
    });


});