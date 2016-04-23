<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p><?php echo isset($usuario)&&!empty($usuario)?'Editar':'Cadastrar'; ?> usuário no sistema <img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" alt="Carregando" title="Carregando" class="carregando" style="position:absolute;display:none;" /></p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
			<form action="" method="post" onsubmit="return valida_cadastro_usuario()">
				<input type="hidden" name="id" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->id;} ?>" />
				<input type="hidden" name="email_existente" value="0" />
				<p><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->nome;} ?>" class="form-control" /></p></label>
				<p><label for="email">E-mail</label><input type="text" id="email" name="email" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->email;} ?>" class="form-control" onblur="verificar_email_existente()" /></p></label>
				<p><label for="senha">Senha</label><input type="password" id="senha" name="senha" value="" class="form-control" /></p></label>
				<br />
				<p><input type="submit" value="Salvar" class="btn btn-default" /> <a href="<?php echo base_url().'admin/usuarios'; ?>" class="btn btn-default">Voltar</a></label>
			</form>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
		<script type="text/javascript">
		function valida_cadastro_usuario(){
			var valido = false;
			var id = $('#id');
			var nome = $('#nome');
			var email = $('#email');
			var senha = $('#senha');
			verificar_email_existente();
			var email_existente = $('input[name="email_existente"]').val();
			if(email_existente=='0'){
				if(nome.val()==''){
					completed(nome, 'NOME');
				}else if(email.val()==''){
					completed(email, 'E-MAIL');
				}else if(!validEmail($('#email'))){
					valido=false;
				}else if(id.val()==''&&senha.val()==''){
					completed(senha, 'SENHA');
				}else{
					$('p.alert').hide('fast');
					valido = true;
				}
			}else{
				$('p.alert').find('span').text('O EMAIL digitado já está em uso por outro usuário');
				$('p.alert').show('fast');
				email.focus();
			}
			return valido;
		}
		function verificar_email_existente(){
			var id = $('#id').val();
			var email = $('#email');
			$.ajax({
				type:"POST",
				data:{'id':id,'email':email.val()},
				url:base_url+'admin/usuarios/verificar_email_existente',
				cache:'false',
				dataType: 'json',
				beforeSend: function(){
					$('.carregando').fadeIn('fast');
				},
				complete: function(msg){
					$('.carregando').fadeOut('fast');
				},
				success:function(data){
					$('input[name="email_existente"]').val(data);
					if(data == '1') {
						$('p.alert').find('span').text('O EMAIL digitado já está em uso por outro usuário');
						$('p.alert').show('fast');
						email.focus();
					} else {
						$('p.alert').hide('fast');
					}
				}
			});
		}
		</script>
	</body>
</html>