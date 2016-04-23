<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Hitórico de Ações no Sistema</p>
			<form action="" method="get">
				<fieldset>
					<legend>Filtro:</legend>
					<p class="col-xs-8"><label>Ação <input type="text" name="acao" value="<?php if(isset($_GET['acao'])&&!empty($_GET['acao'])){echo $_GET['acao'];} ?>" class="form-control" /></label></p>
					<p class="col-xs-2"><label>Data <input type="text" name="data_acao" value="<?php if(isset($_GET['data_acao'])&&!empty($_GET['data_acao'])){echo $_GET['data_acao'];} ?>" class="form-control datepicker" /></label></p>
					<div class="clear"></div>
					<p><input type="submit" value="Filtrar" class="btn btn-default" /> | <input type="button" value="Limpar Filtro" class="btn btn-default" id="limpar_filtro" /></p>
				</fieldset>
			</form>
			<br />
			<table class="table table-bordered table-hover table-condensed tablesorter" id="historic_acoes">
				<thead>
					<tr>
						<th class="header">Ação</th>
						<th class="header">Data</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($historico_acoes)) {
					foreach($historico_acoes as $key => $value) {
						echo '
						<tr>
							<td>'.$value->acao.'</td>
							<td>'.$value->data_acao.'</td>
						</tr>
						';
					}
				} else {
					echo '<tr><td colspan="2"><em>Não há Hitórico de Ações Cadastrado</em></td></tr>';
				} ?>
				</tbody>
				<?php if($total_registros > $itens_por_pagina) { ?>
				<tfoot>
					<tr>
						<td colspan="2"><?php echo $paginador; ?></td>
					</tr>
				</tfoot>
				<?php } ?>
			</table>
			<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
	</body>
</html>