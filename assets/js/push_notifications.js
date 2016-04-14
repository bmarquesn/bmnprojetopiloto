function contarCaracteres(campo) {
	$('#qtd_caracteres').text(campo.val().length);
}

var errosEnvio = 0;
function valida_envio_push_notifications() {
	var retorno = false;
	var mensagem = $('#mensagem');
	var dispositivo = $('#selecione_dispositivo option:selected')
	if(mensagem.val() == ''){
		retorno = false;
		alert('É preciso digitar uma mensagem');
		mensagem.focus();
	}else if(dispositivo.val() == ''){
		retorno = false;
		alert('É preciso selecionar um dispositivo');
		$('#selecione_dispositivo').focus();
	}else{
		var confirmar = confirm('Deseja mesmo enviar esta mensagem para todos os dispositivos '+dispositivo.text()+' ?');
		if(confirmar){
			retorno  = true;
		}else{
			retorno = false;
		}
	}
	if(retorno){
		$.ajax({
			type:"POST",
			data:{'dispositivo':dispositivo.val()},
			url:base_url+'push_notifications/pegar_quantidade_tokens_dispositivos',
			cache:'false',
			dataType:'json',
			beforeSend:function(xhr) {
				
			},
			success:function(data, status) {
				if(status=='success'){
					var totalTokens = 0;
					for(var i=0; i<data.length; i++){
						totalTokens = parseInt(data[i].total);
					}
					if(totalTokens > 0){
						if(totalTokens > 5000) {
							var qtd_envios = 50;
						} else {
							var qtd_envios = 50;
						}
						var qtdPaginas = Math.floor(totalTokens/qtd_envios);
						var contadorProgresso = 0;
						$('#form_envio_push').find('input[type="button"]').attr('disabled','disabled');
						$('#loader_envio .loader').css('width','0');
						$('#loader_envio').fadeIn('fast');
						for(i=0;i<=qtdPaginas;i++) {
							$.ajax({
								type:"POST",
								data:{'device':dispositivo.val(),'push':mensagem.val(),'pagina':i,'qtd_envios':qtd_envios},
								url:base_url+'push_notifications/enviar_mensagens_tokens_dispositivo',
								timeout:3600000,
								cache:'false',
								dataType:'json',
								success:function(data, status) {
									if(status=='success'){
										if(dispositivo.val()=='1'){
											if(data.success=='0'){
												var textResposta = data.resposta;
												gravar_erros_envio_mensagens(dispositivo.val(), mensagem.val(), i, qtd_envios, textResposta);
												errosEnvio++;
											}
										}else{
											if(data!='OK'){
												var textResposta = data;
												gravar_erros_envio_mensagens(dispositivo.val(), mensagem.val(), i, qtd_envios, textResposta);
												errosEnvio++;
											}
										}
										contadorProgresso++;
										var porcentagem = (contadorProgresso*100)/(qtdPaginas+1);
										$('#loader_envio .loader').css('width',Math.round(porcentagem)+'%');
										//barraprogresso.val(porcentagem);
										if(Math.round(porcentagem) == 100) {
											if(errosEnvio>0){
												$('.alert.bg-danger span').text('As mensagens foram enviadas mas houveram erros...');
												errosEnvio=0;
											}else{
												$('.alert.bg-danger span').text('Mensagens enviadas com sucesso');
												errosEnvio=0;
											}
											$('.alert.bg-danger').fadeIn('fast');
											$('#loader_envio').fadeOut('fast');
											$('#mensagem').val('');
											$('#selecione_dispositivo').val('');
											$('#form_envio_push').find('input[type="button"]').removeAttr("disabled");
											setTimeout(function(){$('.alert.bg-danger').fadeOut('fast');},5000);
										}
									}else{
										alert('Erro ao obter os tokens');
									}
								}
							});
						}
					}else{
						alert('Não há tokens para o dispositivo selecionado');
					}
				}else{
					alert('Ocorreu um erro... tente novamente!!!');
				}
				
			}
		});
	}
}
function gravar_erros_envio_mensagens(device, mensagem, pagina, qtd_envios, results) {
	$.ajax({			
		type:"POST",
		data:{'device':device, 'mensagem':mensagem, 'pagina':pagina, 'qtd_envios':qtd_envios, 'results':results},
		url:base_url+'push_notifications/gravar_erros_envios_push',
		cache:'false',
		dataType:'json',
		success:function(data) {
			
		}
	});
}