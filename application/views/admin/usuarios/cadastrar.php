<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Cadastrar usuários no sistema</p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
			<form action="" method="post" onsubmit="return valida_cadastro_usuario()">
				<input type="hidden" name="id" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->id;} ?>" />
				<p><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->nome;} ?>" class="form-control" /></p></label>
				<p><label for="email">E-mail</label><input type="text" id="email" name="email" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->email;} ?>" class="form-control" /></p></label>
				<p><label for="senha">Senha</label><input type="password" id="senha" name="senha" value="" class="form-control" /></p></label>
				<p><em>Os próximos campos não são obrigatórios (se vazios serão requisitados quando necessário).</em></p>
				<div class="row">
					<p class="col-md-4"><label for="nick">Nick</label><input type="text" id="nick" name="nick" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->nick;} ?>" class="form-control" /></p></label>
					<p class="col-md-4"><label for="frase">Frase</label><input type="text" id="frase" name="frase" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->frase;} ?>" class="form-control" /></p></label>
					<p class="col-md-4"><label for="cor">Cor</label><input type="text" id="cor" name="cor" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->cor;} ?>" class="form-control" /></p></label>
				</div>
				<br />
				<p><input type="submit" value="Salvar" class="btn btn-default" /> <a href="<?php echo base_url().'admin/usuarios'; ?>" class="btn btn-default">Voltar</a></label>
			</form>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
		<script type="text/javascript">
		$(function(){
			<?php if(isset($usuario)&&!empty($usuario)){echo "$('#cor').css({'background':'".$usuario[0]->cor."','color':'".$usuario[0]->cor."'});\n";} ?>
			$('#cor').ColorPicker({
				color:'#0000ff',
				onShow:function(colpkr){
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide:function(colpkr){
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange:function(hsb,hex,rgb){
					$('#cor').css({'background':'#'+hex,'color':'#'+hex});
					$('#cor').val(hex);
				},
				onSubmit:function(hsb,hex,rgb,el){
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow:function(){
					$(this).ColorPickerSetColor(this.value);
				}
			});
		});
		//Function that checks if valid email
		function valida_cadastro_usuario(){
			var valido = false;
			var id = $('#id');
			var nome = $('#nome');
			var email = $('#email');
			var senha = $('#senha');
			if(nome.val()==''){
				$('p.alert').find('span').text('O campo NOME deve ser preenchido');
				$('p.alert').show('fast');
				nome.focus();
				valido = false;
			}else if(email.val()==''){
				$('p.alert').find('span').text('O campo EMAIL deve ser preenchido');
				$('p.alert').show('fast');
				email.focus();
				valido = false;
			}else if(!validEmail($('#email'))){
				$('p.alert').find('span').text('O campo EMAIL deve ser um email válido');
				$('p.alert').show('fast');
				email.focus();
				valido = false;
			}else if(id.val()==''&&senha.val()==''){
				$('p.alert').find('span').text('O campo SENHA deve ser um email válido');
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