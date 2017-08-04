<?php
header('Content-type: application/x-javascript');
session_start();
$idioma = $_SESSION['idioma'];
require_once('../idioma/'.$idioma.'.php');
?>
$(function(){
	var $window = $(window);

	if ($('html').attr('lang') == 'pt-br'){
	    /* --- mascara */
		$('#telefone,#celular').on('focusin focusout',function(){
	        var phone,element;

	        element = $(this);
	        element.unmask();
	        phone = element.val().replace(/\D/g,'');

	        if(phone.length > 10){
	            element.mask('(99) 99999-999?9');
	        } else {
	            element.mask('(99) 9999-9999?9');
	        }
	    });

		$('#cnpj').mask('99.999.999/9999-99');

        /*
        $('#cnpj').bind('keyup',function(event){
			$(this).val(cpfCnpj($(this).val()));
        });
        */

		$('#cnpj').bind('blur',function(event){
            var valor = $(this).val();
			//if(valor.match(/^[\d]{2}\.?[\d]{3}\.?[\d]{3}\/?[\d]{4}\-?[\d]{2}$/)){
				if(!validate_cnpj(valor)){
					alert('CNPJ incorreto!');
                    $(this).val('');
				}
            //} else {
            //    if(!validate_cpf(valor)){
			//		alert('CPF incorreto!');
            //    	$(this).val('');
			//	}
            //}
		});
    }

	/* --- contato */
	$('#form-contato,#form-trabalhe,#form-orcamento').on('change','.error',function(){
		$(this).removeClass('error');
	});
	window.$notificou = false;
   	$('#form-contato').on('change','#area',function(){
   		if (this.value == 'Comercial'){
			$('#cnpj').prop('required',true);
		} else {
			$('#cnpj').prop('required',false);
		}
   	});
   	$('#form-contato').submit(function(){

		var empresa = $(this.empresa),
			nome = $(this.nome),
			email = $(this.email),
            cidade = $(this.cidade),
            estado = $(this.estado),
			telefone = $(this.telefone),
            area = $(this.area),
			mensagem = $(this.mensagem),
			retorno = $(this).find('.retorno');

		if ($.trim(empresa.val()) == ''){
        	retorno.html('<?=$_erro['empresa']?>');
			empresa.addClass('error').focus();
			return false;
		}
		if ($.trim(nome.val()) == ''){
        	retorno.html('<?=$_erro['nome']?>');
			nome.addClass('error').focus();
			return false;
		}
        if ($.trim(email.val()) == ''){
        	retorno.html('<?=$_erro['email']?>');
			email.addClass('error').focus();
			return false;
        } else if (!validaMail(email.val())){
        	retorno.html('<?=$_erro['email2']?>');
			email.addClass('error').focus();
			return false;
		}
		if (cidade.val() == ''){
        	retorno.html('<?=$_erro['cidade']?>');
			cidade.addClass('error').focus();
			return false;
		}
		if (estado.val() == ''){
        	retorno.html('<?=$_erro['estado']?>');
			estado.addClass('error').focus();
			return false;
		}
		if ($.trim(telefone.val()) == ''){
        	retorno.html('<?=$_erro['telefone']?>');
			telefone.addClass('error').focus();
			return false;
		}
		if ($.trim(area.val()) == 0){
        	retorno.html('<?=$_erro['area']?>');
			area.addClass('error').focus();
			return false;
		}
		if ($.trim(mensagem.val()) == ''){
			retorno.html('<?=$_erro['msg']?>');
			mensagem.addClass('error').focus();
			return false;
		}

        var validate = false;

        $.ajax({
        	url:'ajax/ajax.php?acao=valida-post',
			async:false,
			type:'post',
			data: { 'validate':$("#captcha").val() },
			success:function(json){
				validate = json.status;
			}
        });

		if (!validate){
			$('.retorno').html('Não foi possível enviar sua mensagem, por favor atualize a página e tente novamente!');
			return false;
		}

		if (area.val() == 'Comercial' && !$notificou){
			var Form = $(this);
			RdIntegration.post(Form.serializeArray(),function(){
				$notificou = true;
				var date = new Date();
				var dia = date.getDate();
				dia = '00'.substring(0, 2 - dia.length) + dia;
				var mes = date.getMonth();
				mes = '00'.substring(0, 2 - mes.length) + mes;
				var strDate = date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+' '+dia+'/'+mes+'/'+date.getFullYear();
				ga('send','event','Contatos','Formulário',strDate);
				Form.submit();
			});
			return false;
		} else {
			$notificou = false;
			return true;
		}
	});
   	$('#form-trabalhe').submit(function(){

		var nome = $(this.nome),
			email = $(this.email),
            cidade = $(this.cidade),
            estado = $(this.estado),
			telefone = $(this.telefone),
            celular = $(this.celular),
			curriculo = $(this.curriculo),
			retorno = $(this).find('.retorno');

		if ($.trim(nome.val()) == ''){
        	retorno.html('<?=$_erro['nome']?>');
			nome.addClass('error').focus();
			return false;
		}
        if ($.trim(email.val()) == ''){
        	retorno.html('<?=$_erro['email']?>');
			email.addClass('error').focus();
			return false;
        } else if (!validaMail(email.val())){
        	retorno.html('<?=$_erro['email2']?>');
			email.addClass('error').focus();
			return false;
		}
		if (cidade.val() == ''){
        	retorno.html('<?=$_erro['cidade']?>');
			cidade.addClass('error').focus();
			return false;
		}
		if (estado.val() == ''){
        	retorno.html('<?=$_erro['estado']?>');
			estado.addClass('error').focus();
			return false;
		}
		if ($.trim(telefone.val()) == ''){
        	retorno.html('<?=$_erro['telefone']?>');
			telefone.addClass('error').focus();
			return false;
		}
		if ($.trim(celular.val()) == 0){
        	retorno.html('<?=$_erro['celular']?>');
			celular.addClass('error').focus();
			return false;
		}
		if ($.trim(curriculo.val()) == ''){
			retorno.html('<?=$_erro['curriculo']?>');
			return false;
		}
		return true;
	});

	/* --- orcamento */
	$("#form-orcamento").submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		$('.retorno').html('');

		if($.trim(this.empresa.value) == ''){
			$('.retorno').html('Por favor informe sua empresa!');
			$(this.empresa).addClass('error').focus();
			return false;
		}
		if($.trim(this.nome.value) == ''){
			$('.retorno').html('Por favor informe seu nome!');
			$(this.nome).addClass('error').focus();
			return false;
		}
		if(validaMail($.trim(this.email.value)) == false){
			$('.retorno').html('Por favor informe seu e-mail corretamente!');
			$(this.email).addClass('error').focus();
			return false;
		}
		if($.trim(this.telefone.value) == ''){
			$('.retorno').html('Por favor informe seu telefone!');
			$(this.telefone).addClass('error').focus();
			return false;
		}

		<? if($idioma == 'br'){ ?>
			if($.trim(this.cnpj.value) == ''){
				$('.retorno').html('Por favor informe seu CNPJ!');
				$(this.cnpj).addClass('error').focus();
				return false;
			} else {
				try {
					if(this.cnpj.value.match(/^[\d]{2}\.?[\d]{3}\.?[\d]{3}\/?[\d]{4}\-?[\d]{2}$/)){
						validaCNPJ(this.cnpj.value);
					} else {
						$('.retorno').html('Por favor informe seu CNPJ!');
						$(this.cnpj).addClass('error').focus();
						return false;
					}
				} catch (err){
					$('.retorno').html(err.message);
					return false;
				}
			}
		<? } ?>

		if($.trim(this.mensagem.value) == ''){
			$('.retorno').html('Por favor informe sua mensagem!');
			$(this.mensagem).addClass('error').focus();
			return false;
		}

		var validate = false;
		$.ajax({
			url : 'ajax/ajax.php?acao=valida-post',
			async : false,
			type : 'post',
			data : { 'validate' : $('#validate').val() },
			success : function(json){
				validate = json.status;
			}
		});

		if (!validate){
			$('.retorno').html('Não foi possível enviar sua solicitação de orçamento, por favor atualize a página e tente novamente!').removeClass('sucesso');
			return false;
		}
		var Form = $(this);
		var data = Form.serializeArray();

		$('.retorno').html('Enviando...').addClass('sucesso');

		RdIntegration.post(data,function(){
			$.ajax({
				url : 'enviar_orcamento',
				type : 'post',
				dataType : 'json',
				data : data,
				success : function(json){
					if(!!json.status){
						//Form.before('<p><strong>Seu orçamento foi enviado com sucesso.</strong></p>');
						//Form.remove();
						var date = new Date();
						var dia = date.getDate();
						dia = '00'.substring(0, 2 - dia.length) + dia;
						var mes = date.getMonth();
						mes = '00'.substring(0, 2 - mes.length) + mes;
						var strDate = date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+' '+dia+'/'+mes+'/'+date.getFullYear();
						ga('send','event','Contatos','Orçamento',strDate);

						<? if($idioma == 'br'){ ?>
							window.location.href = http+'orcamento/';
						<? } elseif($idioma == 'en'){ ?>
							window.location.href = http+'en/budget/';
						<? } elseif($idioma == 'es'){ ?>
							window.location.href = http+'es/presupuesto/';
						<? } ?>

					} else {
						$('.retorno').html(json.msg);
						//Form.find(':submit').prop('disabled',false);
					}
				}
			});
		});
		return false;
	});
});

function validaMail(email){
    var exclude = /[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
    var check = /@[\w\-]+\./;
    var checkend = /\.[a-zA-Z]{2,3}$/;

	if ((email.search(exclude) != -1) || (email.search(check) == -1) || (email.search(checkend) == -1)){
    	return false;
	} else {
    	return true;
	}
}
function validaCNPJ(CNPJ){
	var erro = '';
	if (!CNPJ.match(/^[\d]{2}\.?[\d]{3}\.?[\d]{3}\/?[\d]{4}\-?[\d]{2}$/)){
		throw "É necessário preencher corretamente o número do CNPJ!";
	}
	CNPJ = CNPJ.replace(/[\D]+/g,"");

	var a = [];
	var b = 0;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i < 12; i++){
	   a[i] = CNPJ.charAt(i);
	   b += a[i] * c[i+1];
	}
	a[12] = ((x = b % 11) < 2) ? 0:11-x;
	b = 0;
	for (y = 0; y < 13; y++) {
		b += (a[y] * c[y]);
	}
	a[13] = ((x = b % 11) < 2) ? 0:11-x;

	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
		throw "Dígito verificador com problema!";
	}
	return true;
}
function validaCPF(cpf){
	var filtro = /^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/i;
	if(!filtro.test(cpf)){
		throw "CPF inválido. Verifique se seu cpf foi digitado corretamente.";
	}

	cpf = cpf.replace(/[^\d]+/g, "");

	if(cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
	  	cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
	 	cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
	  	cpf == "88888888888" || cpf == "99999999999"){
	  	throw "CPF inválido. Verifique se seu cpf foi digitado corretamente.";
	}

	soma = 0;
	for(i = 0; i < 9; i++){
		soma += parseInt(cpf.charAt(i)) * (10 - i);
	}
	resto = 11 - (soma % 11);
	if(resto == 10 || resto == 11){
		resto = 0;
	}
	if(resto != parseInt(cpf.charAt(9))){
		throw "CPF inválido. Verifique se seu cpf foi digitado corretamente.";
	}
	soma = 0;
	for(i = 0; i < 10; i ++){
	 	soma += parseInt(cpf.charAt(i)) * (11 - i);
	 }
	resto = 11 - (soma % 11);
	if(resto == 10 || resto == 11){
	 	resto = 0;
	 }
	if(resto != parseInt(cpf.charAt(10))){
	 	throw "CPF inválido. Verifique se seu cpf foi digitado corretamente.";
	}
	return true;
}
function cpfCnpj(v){
	v=v.replace(/\D/g,""); //Remove tudo o que nÃ£o Ã© dÃ­gito

	//CPF
	if(v.length <= 13){ 
		v=v.replace(/(\d{3})(\d)/,"$1.$2"); //Coloca um ponto entre o terceiro e o quarto dÃ­gitos
		v=v.replace(/(\d{3})(\d)/,"$1.$2"); //Coloca um ponto entre o terceiro e o quarto dÃ­gitos de novo (para o segundo bloco de nÃºmeros)
		v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2"); //Coloca um hÃ­fen entre o terceiro e o quarto dÃ­gitos

    //CNPJ
	} else {
		v=v.replace(/^(\d{2})(\d)/,"$1.$2"); //Coloca ponto entre o segundo e o terceiro dÃ­gitos
		v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3"); //Coloca ponto entre o quinto e o sexto dÃ­gitos
		v=v.replace(/\.(\d{3})(\d)/,".$1/$2"); //Coloca uma barra entre o oitavo e o nono dÃ­gitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2"); //Coloca um hÃ­fen depois do bloco de quatro dÃ­gitos
	}
	return v;
}
function validate_cnpj(val){
	if(val.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/) != null) {
        var val1 = val.substring(0, 2);
        var val2 = val.substring(3, 6);
        var val3 = val.substring(7, 10);
        var val4 = val.substring(11, 15);
        var val5 = val.substring(16, 18);

        var i;
        var number;
        var result = true;

        number = (val1 + val2 + val3 + val4 + val5);

        s = number;

        c = s.substr(0, 12);
        var dv = s.substr(12, 2);
        var d1 = 0;

        for (i = 0; i < 12; i++)
            d1 += c.charAt(11 - i) * (2 + (i % 8));

        if (d1 == 0)
            result = false;

        d1 = 11 - (d1 % 11);

        if (d1 > 9) d1 = 0;

        if (dv.charAt(0) != d1)
            result = false;

        d1 *= 2;
        for (i = 0; i < 12; i++) {
            d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9) d1 = 0;

        if (dv.charAt(1) != d1)
            result = false;

        return result;
    }
    return false;
}
function validate_cpf(val){

    if (val.match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) != null) {
        var val1 = val.substring(0, 3);
        var val2 = val.substring(4, 7);
        var val3 = val.substring(8, 11);
        var val4 = val.substring(12, 14);

        var i;
        var number;
        var result = true;

        number = (val1 + val2 + val3 + val4);

        s = number;
        c = s.substr(0, 9);
        var dv = s.substr(9, 2);
        var d1 = 0;

        for (i = 0; i < 9; i++) {
            d1 += c.charAt(i) * (10 - i);
        }

        if (d1 == 0)
            result = false;

        d1 = 11 - (d1 % 11);
        if (d1 > 9) d1 = 0;

        if (dv.charAt(0) != d1)
            result = false;

        d1 *= 2;
        for (i = 0; i < 9; i++) {
            d1 += c.charAt(i) * (11 - i);
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9) d1 = 0;

        if (dv.charAt(1) != d1)
            result = false;

        return result;
    }

    return false;
}
function showButton(a){
	$('#g-recaptcha-response').parents('form').find(':submit').prop('disabled',false).attr('title','');
}
function hideButton(a){
	$('#g-recaptcha-response').parents('form').find(':submit').prop('disabled',true).attr('title','Preencha todos os campos e o captcha');
}