<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Usuários cadastrados no sistema</p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
			<p><a href="<?php echo base_url().'admin/usuarios/cadastrar'; ?>" class="btn btn-primary">Cadastrar</a></p>
			<table class="table table-bordered table-hover table-condensed tablesorter" id="usuarios">
				<thead>
					<tr>
						<th class="header">Nome</th>
						<th class="header">Email</th>
						<th colspan="2" class="txtCenter">Ações</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($usuarios)) {
					foreach($usuarios as $key => $value) {
						echo '
						<tr>
							<td>'.$value->nome.'</td>
							<td>'.$value->email.'</td>							
							<td class="col-md-1"><a href="'.base_url().'admin/usuarios/cadastrar/'.$value->id.'" class="btn btn-default" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
							<td class="col-md-1"><a href="'.base_url().'admin/usuarios/excluir/'.$value->id.'" class="btn btn-danger" title="Excluir" onclick="return confirmar_exclusao(\'Usuário\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
						</tr>
						';
					}
				} else {
					echo '<tr><td colspan="6"><em>Não há Usuários Cadastrados</em></td></tr>';
				} ?>
				</tbody>
				<?php if($total_registros > $itens_por_pagina) { ?>
				<tfoot>
					<tr>
						<td colspan="6"><?php echo $paginador; ?></td>
					</tr>
				</tfoot>
				<?php } ?>
			</table>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
	</body>
</html>