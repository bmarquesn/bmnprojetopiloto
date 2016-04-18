<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Cadastrar prospetcs no sistema</p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
			<form action="" method="post" onsubmit="return validar_insercao_prospect()">
				<input type="hidden" name="id" value="<?php if(isset($prospect)&&!empty($prospect)){echo $prospect[0]->id;} ?>" />
				<p><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="<?php if(isset($prospect)&&!empty($prospect)){echo $prospect[0]->nome;} ?>" class="form-control" /></p></label>
				<p><label for="setor">Setor</label>
					<select name="setor" id="setor" class="form-control">
						<?php
						if(!empty($setores)) {
							echo '<option value="">Selecione</option>';
							foreach($setores as $key => $value) {
								if(isset($prospect) && $prospect[0]->setor_id === $value->id) {
									echo '<option value="'.$value->id.'" selected="selected">'.$value->nome.'</option>';
								} else {
									echo '<option value="'.$value->id.'">'.$value->nome.'</option>';
								}
							}
						} else {
							echo '<option value="">Não há Setores cadastrados</option>';
						}
						?>
					</select>
				</p>
				<p><label for="contatos">Contatos</label><br /><textarea name="contatos" id="contatos" class="form-control"><?php echo isset($prospect)?$prospect[0]->contato:''; ?></textarea></p></label>
				<p><label for="acao">Ação</label>
					<select name="acao" id="acao" class="form-control">
						<option value="">Selecione</option>
						<?php
						foreach($acao as $key => $value) {
							if(isset($dados) && $key == $prospect[0]->acao_id) {
								echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
							} else {
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
						}
						?>
					</select>
				</p>
				<p><label for="dataProximaAcao">Data Próxima Ação</label><input type="text" name="dataProximaAcao" value="<?php echo isset($prospect)?date('d/m/Y', strtotime($prospect[0]->data_proxima_acao)):''; ?>" class="datepicker form-control" id="dataProximaAcao" /></p>
				<br />
				<p><input type="submit" value="Salvar" class="btn btn-default" /> <a href="<?php echo base_url().'admin/usuarios'; ?>" class="btn btn-default">Voltar</a></label>
			</form>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
		<script type="text/javascript">
		function validar_insercao_prospect(){
			var valido=false;
			var id = $('#id');
			var nome = $('#nome');
			var setor = $('#setor');
			var contatos = $('#contatos');
			var acao = $('#acao');
			var dataProximaAcao = $('#dataProximaAcao');
			if(nome.val()==''){
				$('p.alert').find('span').text('O campo NOME deve ser preenchido');
				$('p.alert').show('fast');
				nome.focus();
				valido = false;
			}else if(setor.val()==''){
				$('p.alert').find('span').text('O SETOR deve ser selecionado');
				$('p.alert').show('fast');
				setor.focus();
				valido = false;
			}else if(contatos.val()==''){
				$('p.alert').find('span').text('O campo CONTATO deve ser preenchido');
				$('p.alert').show('fast');
				contatos.focus();
				valido = false;
			}else if(acao.val()==''){
				$('p.alert').find('span').text('A Acao deve ser selecionada');
				$('p.alert').show('fast');
				acao.focus();
				valido = false;
			}else if(dataProximaAcao.val()==''){
				$('p.alert').find('span').text('O campo DATA PRÓXIMA AÇÃO deve ser preenchido');
				$('p.alert').show('fast');
				dataProximaAcao.focus();
				valido = false;
			}else{
				$('p.alert').hide('fast');
				valido = true;
			}
			return valido;
		}
		</script>
	</body>
</html>