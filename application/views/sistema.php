<div class="jumbotron">
	<br />
	<h1>Bruno Marques Nogueira</h1>
	<p>Gerente de projetos, desenvolvedor web</p>
</div>
<div class="row">
	<div class="col-sm-6 col-md-4 col-lg-2">
		<h2>Usuários</h2>
		<p>Lista de Usuários que poderão acessar o sistema</p>
		<p><a class="btn btn-success" href="<?php echo base_url().'admin/usuarios'; ?>">Usuários</a></p>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-2">
		<h2>Prospects</h2>
		<p>Sistema para inserção, exibição, edição ou remoção ('CRUD') de prospects</p>
		<p><a class="btn btn-success" href="<?php echo base_url().'prospects'; ?>">Prospects</a></p>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-2">
		<h2>Setores</h2>
		<p>Sistema para inserção, exibição, edição ou remoção ('CRUD') de setores</p>
		<p><a class="btn btn-success" href="<?php echo base_url().'admin/setores'; ?>">Setores</a></p>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-2">
		<h2>Procedure</h2>
		<p>Exibicao de Procedures SQL</p>
		<p><a class="btn btn-success" href="<?php echo base_url().'prospects/listar_copias_procedure'; ?>">Procedure</a></p>
	</div>
	<div class="col-sm-6 col-md-4 col-lg-2">
		<h2>Logs</h2>
		<p>Histórico de ações no sistema</p>
		<p><a class="btn btn-success" href="<?php echo base_url().'admin/logs'; ?>">Histórico</a></p>
	</div>
	<?php
	/**
	 * 2020-05-26 - Bruno Nogueira
	 * Retirado, por enquanto, o PHP Doc
	 *
	 * <div class="col-sm-6 col-md-4 col-lg-2">
	 *  <h2>PHPDoc</h2>
	 *	<p>Documentação do sistema em PHPDoc</p>
	 *	<p><a class="btn btn-success" href="<?php echo base_url().'documentacao_phpdoc'; ?>">Documentação</a></p>
	*</div>
	*/
	?>
	<div class="col-sm-6 col-md-4 col-lg-2">
		<h2>Contato</h2>
		<p>Entre em contato, tire suas dúvidas ou faça sugestões</p>
		<p><a class="btn btn-success" href="<?php echo base_url().'main/contato'; ?>">Contato</a></p>
	</div>
</div>