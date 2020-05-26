<h1><?php echo $titulo_pagina; ?></h1>
<p>Entre em contato, tire suas dúvidas ou faça sugestões.</p>
<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span><?php if(isset($mensagem_enviada)){echo $mensagem_enviada;}?></span></p>
<form action="" method="post" onsubmit="return validar_envio_email()">
	<p><label>Nome: <input type="text" name="nome" value="" class="form-control" /></label></p>
	<p><label>Email: <input type="text" name="email" value="" class="form-control" /></label></p>
	<p><label>Mensagem: <textarea name="mensagem" class="form-control"></textarea></label></p>
	<p><input type="submit" value="Enviar" class="btn btn-default" /></p>
</form>
<script type="text/javascript">
var mensagem_enviada='<?php echo isset($mensagem_enviada)&&!empty($mensagem_enviada)?$mensagem_enviada:0 ?>';
</script>