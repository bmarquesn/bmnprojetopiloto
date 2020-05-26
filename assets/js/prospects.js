function validar_insercao_prospect(){
	var valido=false;
	var id = $('#id');
	var nome = $('#nome');
	var setor = $('#setor');
	var contatos = $('#contatos');
	var acao = $('#acao');
	var dataProximaAcao = $('#dataProximaAcao');
	if(nome.val()==''){
		completed(nome, 'NOME');
	}else if(setor.val()==''){
		completed(setor, 'SETOR');
	}else if(contatos.val()==''){
		completed(contatos, 'Contatos');
	}else if(acao.val()==''){
		completed(acao, 'ACAO');
	}else if(dataProximaAcao.val()==''){
		completed(dataProximaAcao, 'DATA PROXIMA ACAO');
	}else{
		$('p.alert').hide('fast');
		valido = true;
	}
	return valido;
}