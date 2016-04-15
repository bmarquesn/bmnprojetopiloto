<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="span3 bs-docs-sidebar">
					<?php require_once('estrutura/menu.php'); ?>
				</div>
				<div class="span9">
					<h1>Prospects</h1>
					<?php
					if(isset($_GET['msg']) && !empty($_GET['msg'])) {
						echo '<p class="alert"><strong>Mensagem!</strong> <span>'.$_GET['msg'].'</span></p>';
					}
					?>
					<p>Legenda:</p>
					<ul class="legenda_estados">
						<?php
						foreach($acao as $key => $value) {
							echo '<li><span class="estado_'.$key.'"></span> '.$value.'</li>';
						} ?>
					</ul>
					<p><em>Clique sobre o Estado para alterar o Prospect</em><img src="<?php echo base_url().'assets/img/carregando.gif'; ?>" title="Carregando" class="carregando" /></p>
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<td>ID</td>
								<td>Nome</td>
								<td>Setor</td>
								<td>Estado</td>
								<td>Data Inserção</td>
								<td>Data Próxima Ação</td>
								<td colspan="2">Ações</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($prospects)) {
								foreach($prospects as $key => $value) {
							?>
									<tr>
										<td><?php echo $value->id; ?></td>
										<td><?php echo $value->nome; ?></td>
										<td><?php echo $value->nomeSetor; ?></td>
										<td>
											<div class="estado">
												<input type="hidden" class="id_prospect num_<?php echo $value->id; ?>" value="<?php echo $value->id; ?>" />
												<?php for($i = 1; $i < 6; $i++) { ?>
													<?php if($i <= $value->acao_id) { ?>
														<div class="estado_<?php echo $i;?> prospect p<?php echo $i;?>" title="<?php echo $acao[$i]; ?>"><input type="hidden" value="<?php echo $i; ?>" /></div>
													<?php } else { ?>
														<div title="<?php echo $acao[$i]; ?>" class="prospect p<?php echo $i;?>"><input type="hidden" value="<?php echo $i; ?>" /></div>
													<?php } ?>
												<?php } ?>
											</div>
										</td>
										<td><?php echo date('d/m/Y', strtotime($value->data_insercao)); ?></td>
										<td><?php echo date('d/m/Y', strtotime($value->data_proxima_acao)); ?></td>
										<td><a href="<?php echo base_url().'prospect/editar/'.$value->id; ?>" title="Editar"><em class="icon-edit"></em></a></td>
										<td><a href="<?php echo base_url().'prospect/excluir/'.$value->id; ?>" title="Excluir" onclick="return confirmar_exclusao('Prospect')"><em class="icon-trash"></em></a></td>
									</tr>
							<?php
								}
							} else {
							?>
								<tr>
									<td colspan="8"><em>Não há Prospects Cadastrados</em></td>
								</tr>
							<?php } ?>
						</tbody>
						<?php if(!empty($prospects) && !empty($paginador)) { ?>
							<tfoot>
								<tr>
									<td colspan="8"><?php echo $paginador; ?></td>
								</tr>
							</tfoot>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		var urlAtualizarStatusProspect = "<?php echo base_url().'prospect/atualizar_status_prospect/'; ?>";
	</script>
</html>