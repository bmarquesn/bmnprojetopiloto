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
					<div class="modal-body">
						<p><label>Digite seu email:<input type="text" name="email" class="form-control" value="" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" /></label></p>
					</div>
					<div class="modal-footer"><span class="carregando" style="display:none;">Enviando.... <img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" title="Carregando" alt="Carregando" /></span><input type="button" class="btn btn-primary" value="Enviar" /><button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button></div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		var url_esqueci_minha_senha='<?php echo base_url().'login/esqueci_minha_senha'; ?>';
		var php_get_msg='<?php echo isset($_GET['msg'])&&!empty($_GET['msg'])?$_GET['msg']:0; ?>';
		var retorno_msg='<?php echo isset($retorno)&&!empty($retorno)?$retorno:0; ?>';
		var url_redirect='<?php echo base_url().'login/index/' ?>';
		</script>
		<?php require('estrutura/footer.php'); ?>
	</body>
</html>