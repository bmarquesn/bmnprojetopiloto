<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Setores cadastrados no sistema</p>
			<p class="alert bg-danger" style="display:none;"><strong>Mensagem!</strong> <span></span></p>
			<p><a href="<?php echo base_url().'admin/setores/cadastrar'; ?>" class="btn btn-primary">Cadastrar</a></p>
			<table class="table table-bordered table-hover table-condensed tablesorter" id="setores">
				<thead>
					<tr>
						<th class="header">Nome</th>
						<th colspan="2" class="txtCenter">Ações</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($setores)) {
					foreach($setores as $key => $value) {
						echo '
						<tr>
							<td>'.$value->nome.'</td>
							<td class="col-md-1"><a href="'.base_url().'admin/setores/cadastrar/'.$value->id.'" class="btn btn-default" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
							<td class="col-md-1"><a href="'.base_url().'admin/setores/excluir/'.$value->id.'" class="btn btn-danger" title="Excluir" onclick="return confirmar_exclusao(\'Setor\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
						</tr>
						';
					}
				} else {
					echo '<tr><td colspan="3"><em>Não há Setores Cadastrados</em></td></tr>';
				} ?>
				</tbody>
				<?php if($total_registros > $itens_por_pagina) { ?>
				<tfoot>
					<tr>
						<td colspan="3"><?php echo $paginador; ?></td>
					</tr>
				</tfoot>
				<?php } ?>
			</table>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
	</body>
</html>