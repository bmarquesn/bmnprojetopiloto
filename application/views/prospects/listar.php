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
			<p><a href="<?php echo base_url().'prospects/cadastrar'; ?>" class="btn btn-primary">Cadastrar</a></p>
			<p><strong>Legenda:</strong></p>
			<ul class="legenda_estados list-unstyled">
				<?php
				foreach($acao as $key => $value) {
					echo '<li><span class="estado_'.$key.'"></span> '.$value.'</li>';
				} ?>
			</ul>
			<br /><br /><div class="clear"></div>
			<p><em>Clique sobre o Estado para alterar o Prospect</em><img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" title="Carregando" class="carregando" /></p>
			<table class="table table-bordered table-hover table-condensed tablesorter" id="usuarios">
				<thead>
					<tr>
						<th class="header">ID</th>
						<th class="header">Nome</th>
						<th class="header">Setor</th>
						<th class="header">Estado</th>
						<th class="header">Data Inserção</th>
						<th class="header">Data Próxima Ação</th>
						<th colspan="2" class="txtCenter">Ações</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(!empty($prospects)) {
					foreach($prospects as $key => $value) {
						echo '
						<tr>
							<td>'.$value->id.'</td>
							<td>'.$value->nome.'</td>
							<td>'.$value->nomeSetor.'</td>
							<td>
								<div class="estado">
									<input type="hidden" class="id_prospect num_'.$value->id.'" value="'.$value->id.'" />';
									for($i = 1; $i < 6; $i++) {
										if($i <= $value->acao_id) {
											echo '<div class="estado'.$i.' prospect p'.$i.'" title="'.$acao[$i].'"><input type="hidden" value="'.$i.'" /></div>';
										} else {
											echo '<div title="'.$acao[$i].'" class="prospect p'.$i.'"><input type="hidden" value="'.$i.'" /></div>';
										}
									}
							echo '
								</div>
							</td>
							<td>'.$value->frase.'</td>
							<td class="col-md-1"><a href="'.base_url().'admin/usuarios/cadastrar/'.$value->id.'" class="btn btn-default" title="Editar"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
							<td class="col-md-1"><a href="'.base_url().'admin/usuarios/excluir/'.$value->id.'" class="btn btn-danger" title="Excluir" onclick="return confirmar_exclusao(\'Usuário\')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
						</tr>
						';
					}
				} else {
					echo '<tr><td colspan="7"><em>Não há Prospects Cadastrados</em></td></tr>';
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
		<script type="text/javascript">var urlAtualizarStatusProspect = "<?php echo base_url().'prospects/atualizar_status_prospect/'; ?>";</script>
	</body>
</html>