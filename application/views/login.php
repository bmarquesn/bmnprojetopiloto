<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require('estrutura/head.php'); ?>
	</head>
	<body>
		<?php require('estrutura/menu_topo.php'); ?>
		<div class="container">
			<div class="row">
				<div class="form_login">
					<h1>Faça seu login</h1>
					<p class="alert alert-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
					<form name="formLogin" method="post" action="<?php echo base_url().'login/entrar'; ?>" onsubmit="return validar_login()">
						<p><label for="email">Email:</label> <input type="text" value="" name="emailLogin" class="form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" /></p>
						<p><label for="senha">Senha:</label> <input type="password" value="" class="form-control" name="senha" id="senha" /></p>
						<p class="txtCenter">
							<input type="submit" value="Entrar" class="btn btn-primary" />
							<em><a href="" title="Esqueci minha senha" class="btn btn-default" data-target="#modalEsqueciSenha" data-toggle="modal">Esqueci minha senha</a></em>
						</p>
					</form>
				</div>
			</div>
		</div>
		<div id="modalEsqueciSenha" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Esqueci minha senha</h4></div>
					<form action="<?php echo base_url().'login/esqueci_minha_senha'; ?>" method="post" onsubmit="return valida_envio_email()">
						<div class="modal-body">
							<p align="center"><label>Digite seu email: <input type="text" name="email" class="form-control" value="" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" /> <img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" class="carregando" title="Carregando" alt="Carregando" style="display:none;" /></label></p>
						</div>
						<div class="modal-footer"><input type="submit" class="btn btn-primary" value="Enviar" /> <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button></div>
					</form>
				</div>
			</div>
		</div>
		<?php require('estrutura/footer.php'); ?>
		<script type="text/javascript">
		$(function(){
			$('.bs-docs-example').css('width','100%');
		<?php if(isset($_GET['msg']) && $_GET['msg'] === 'dadosInvalidos') { ?>
			$('.alert.alert-danger span').html('Email e/ou Senha preenchidos são inválidos.');
			$('.alert.alert-danger').show('fast');
		<?php } elseif(isset($_GET['msg']) && $_GET['msg'] === 'dadosNaoPreenchidos') { ?>
			$('.alert.alert-danger span').html('Dados nao preenchidos e/ou são inválidos.');
			$('.alert.alert-danger').show('fast');
		<?php } elseif(isset($retorno) && !empty($retorno)) { ?>
			$('.alert.alert-danger span').html('<?php echo $retorno; ?>');
			$('.alert.alert-danger').show('fast');
		<?php } ?>
		});
		function valida_envio_email(){
			var email = $('#modalEsqueciSenha').find('input[name="email"]');
			var valido = false;
			if(email.val() == '') {
				alert('O campo E-mail deve ser preenchido');
				email.focus();
			}else{
				valido = true;
			}
			return valido;
		}
		//Function that checks if valid email
		function emailFunction(field) {
			var value_field = $(field).val();
			var valido = false;
			if ((/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value_field))) {
				valido = true;
			} else {
				$('.alert.alert-danger span').html('O campo EMAIL deve ser um email válido.');
				$('.alert.alert-danger').show('fast');
				$(field).focus();
				valido = false;
			}
			return valido;
		}
		function validar_login(){
			var valido = false;
			var email = $('#email');
			var senha = $('#senha');
			if(email.val()==''){
				$('p.alert').find('span').text('O campo EMAIL deve ser preenchido');
				$('p.alert').show('fast');
				email.focus();
				valido = false;
			}else if(!emailFunction(email)){
				$('p.alert').find('span').text('O campo EMAIL deve ser um email válido');
				$('p.alert').show('fast');
				email.focus();
				valido = false;
			}else if(senha.val()==''){
				$('p.alert').find('span').text('O campo SENHA deve ser preenchido');
				$('p.alert').show('fast');
				senha.focus();
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