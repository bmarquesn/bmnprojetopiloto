<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Listagem de Cópias Prospects Procedure</p>
			<table class="table table-bordered table-hover table-condensed tablesorter" id="prospects">
				<thead>
					<tr>
						<th class="header">ID</th>
						<th class="header">Nome</th>
						<th class="header">Setor</th>
						<th class="header">Estado</th>
						<th class="header">Data Inserção</th>
						<th class="header">Data Próxima Ação</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($prospects_procedure)) {
					foreach($prospects_procedure as $key => $value) {
						echo '
						<tr>
							<td>'.$value->id.'</td>
							<td>'.$value->nome.'</td>
							<td>'.$value->nomeSetor.'</td>
							<td>'.$acao[$value->acao_id].'</td>
							<td>'.date('d/m/Y H:i:s', strtotime($value->data_insercao)).'</td>
							<td>'.date('d/m/Y H:i:s', strtotime($value->data_proxima_acao)).'</td>
						</tr>
						';
					}
				} else {
					echo '<tr><td colspan="7"><em>Não há Cópias de Prospects Cadastradas</em></td></tr>';
				} ?>
				</tbody>
			</table>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
	</body>
</html>