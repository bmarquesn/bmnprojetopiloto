<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="container">
		<div class="navbar-header">
			<?php if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) { ?>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php } ?>
			<a class="navbar-brand" href="<?php echo base_url().'sistema'; ?>" title="Bruno Marques Nogueira - Gerente - Desenvolvedor - Projetos - Web">BMN</a>
		</div>
		<?php if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) { ?>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="nav navbar-nav">
				<li<?php if(isset($pagina) && $pagina === 'usuarios'){echo ' class="active"';}?>><a href="<?php echo base_url().'admin/usuarios'; ?>">Usuários</a></li>
				<li<?php if(isset($pagina) && $pagina === 'curriculo'){echo ' class="active"';}?>><a href="<?php echo base_url().'curriculo'; ?>">Currículo</a></li>
				<li<?php if(isset($pagina) && $pagina === 'prospects'){echo ' class="active"';}?>><a href="<?php echo base_url().'prospects'; ?>">Prospects</a></li>
				<li<?php if(isset($pagina) && $pagina === 'setores'){echo ' class="active"';}?>><a href="<?php echo base_url().'admin/setores'; ?>">Setores</a></li>
				<li<?php if(isset($pagina) && $pagina === 'logs'){echo ' class="active"';}?>><a href="<?php echo base_url().'admin/historico_acoes'; ?>">Logs</a></li>
				<li<?php if(isset($pagina) && $pagina === 'phpdoc'){echo ' class="active"';}?>><a href="<?php echo base_url().'documentacao_phpdoc'; ?>">PHPDoc</a></li>
				<li<?php if(isset($pagina) && $pagina === 'procedure'){echo ' class="active"';}?>><a href="<?php echo base_url().'documentacao_phpdoc'; ?>">Procedure</a></li>
			</ul>
			<div style="position:relative;left:10px;"><a href="<?php echo base_url().'sistema/sair'; ?>" class="btn btn-danger" onclick="return confirm('Deseja mesmo sair do sistema?')">Sair</a></div>
		</div>
		<?php } ?>
	</div>
</nav>