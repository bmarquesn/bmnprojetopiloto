<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once('estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once('estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Entre em contato, tire suas dúvidas ou faça sugestões.</p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span><?php if(isset($mensagem_enviada)){echo $mensagem_enviada;}?></span></p>
			<form action="" method="post" onsubmit="return validar_envio_email()">
				<p><label>Nome: <input type="text" name="nome" value="" class="form-control" /></label></p>
				<p><label>Email: <input type="text" name="email" value="" class="form-control" /></label></p>
				<p><label>Mensagem: <textarea name="mensagem" class="form-control"></textarea></label></p>
				<p><input type="submit" value="Enviar" class="btn btn-default" /></p>
			</form>
			<?php require_once('estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once('estrutura/footer.php'); ?>
		<script type="text/javascript">
		$(function(){<?php if(isset($mensagem_enviada)){echo "$('.alert.bg-danger').show();";}?>});
		function validar_envio_email(){
			var valido = false;
			var nome = $('input[name="nome"]');
			var email = $('input[name="email"]');
			var mensagem = $('textarea[name="mensagem"]');
			if(!completed(nome, 'Nome')){
				valido = false;
			}else if(!completed(email, 'E-mail')){
				valido = false;
			}else if(!validEmail(email, 'E-mail')){
				valido = false;
			}else if(!completed(mensagem, 'Mensagem')){
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