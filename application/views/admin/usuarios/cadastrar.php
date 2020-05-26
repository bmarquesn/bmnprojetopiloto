<h1><?php echo $titulo_pagina; ?></h1>
<p><?php echo isset($usuario)&&!empty($usuario)?'Editar':'Cadastrar'; ?> usuário no sistema <img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" alt="Carregando" title="Carregando" class="carregando" style="position:absolute;display:none;" /></p>
<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
<form name="cadastrar_usuario" action="" method="post" onsubmit="return valida_cadastro_usuario()">
	<input type="hidden" name="id_usuario" value="<?php echo isset($usuario)&&!empty($usuario)?$usuario[0]->id:'0'; ?>" />
	<p><label for="nome">Nome</label><input type="text" id="nome" name="nome" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->nome;} ?>" class="form-control" /></p></label>
	<p><label for="email">E-mail</label><input type="text" id="email" name="email" value="<?php if(isset($usuario)&&!empty($usuario)){echo $usuario[0]->email;} ?>" class="form-control" /></p></label>
	<p><label for="senha">Senha</label><input type="password" id="senha" name="senha" value="" class="form-control" /></p></label>
	<br />
	<p><input type="submit" value="Salvar" class="btn btn-default" /> <a href="<?php echo base_url().'admin/usuarios'; ?>" class="btn btn-default">Voltar</a></label>
</form>