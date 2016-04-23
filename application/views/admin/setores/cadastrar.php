<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p><?php echo isset($setor)&&!empty($setor)?'Editar':'Cadastrar'; ?> setor no sistema <img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" alt="Carregando" title="Carregando" class="carregando" style="position:absolute;display:none;" /></p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
			<form action="" method="post" onsubmit="return valida_cadastro_setor()">
				<input type="hidden" name="id" value="<?php if(isset($setor)&&!empty($setor)){echo $setor[0]->id;} ?>" />
				<input type="hidden" name="email_existente" value="0" />
				<p><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="<?php if(isset($setor)&&!empty($setor)){echo $setor[0]->nome;} ?>" class="form-control" /></p></label>
				<br />
				<p><input type="submit" value="Salvar" class="btn btn-default" /> <a href="<?php echo base_url().'admin/setores'; ?>" class="btn btn-default">Voltar</a></label>
			</form>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
		<script type="text/javascript">
		function valida_cadastro_setor(){
			var valido = false;
			var id = $('#id');
			var nome = $('#nome');
			if(nome.val()==''){
				completed(nome, 'NOME');
			}else{
				$('p.alert').hide('fast');
				valido = true;
			}
			return valido;
		}
		</script>
	</body>
</html>